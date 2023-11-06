<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\ExhibitionPurchase;
use App\Models\Hotel;
use App\Models\Transaction;
use App\Models\User;
use App\Services\EmailService;
use App\Services\SMSService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function allTransaction()
    {
        $transactions = Transaction::whereUserId(auth()->id())->latest('id')->get();

        return view('user.trx.index', compact('transactions'));
    }

    public function initPayment()
    {
        $data = Session('purchase');
        $purchase = $data;
        $event_price = optional($data)['event_price'];
        $exhibition = optional($data)['exhibition'];
        $isReserved = optional(optional($data)['hotel'])['reserved'];

        //TODO Fetch total hotel amount from accommodation table instead of cache
        //$hotel_price = optional(optional($data)['hotel'])['price'] * optional(optional($data)['hotel'])['quantity'];
        $accommodation = optional(
            Accommodation::where('user_id', auth()->id())
                ->where('event_id', $data['event']['id'])
                ->first()
        );
        $hotel_price = $accommodation->total_amount ?? 0;

        //TODO Fetch total exhibition amount from exhibition purchases table instead of cache

        $exhibition_total_price = 0;
        $attendance_id = $purchase['attendance']['id'];
        if($attendance_id){
            $exhibitions = ExhibitionPurchase::where('attendance_id', $attendance_id)->get();
            $exhibition_total_price = $exhibitions->sum('total_amount') ?? 0;
        }


        // Add Extra Charge When Done
        $total_price = $event_price + ($isReserved ? 0 : $hotel_price) + $exhibition_total_price;

        $ref = $this->genTranxRef();

        $conditions = [
            'event_id' => $data['event']['id'],
            'user_id' => auth()->user()->id,
        ];

        // Data to be inserted or updated
        $transactionData = [
            'event_id' => $data['event']['id'],
            'user_id' => auth()->user()->id,
            'amount' => $total_price,
            'status' => 'pending',
            'transaction_reference' => $ref,
            'payment_method' => 'card'
        ];

        // Use updateOrCreate to create or update the record based on conditions
        $transaction = Transaction::updateOrCreate($conditions, $transactionData);

        $PaymentData = array_filter([
            "amount" => $this->getPaystackAmount($total_price),
            "reference" => optional($transaction)->transaction_reference ?? $ref,
            "email" => auth()->user()->email,
            "callback_url" => env('APP_URL') . '/user/verify_payment',
            "currency" => "NGN",
            'channels' => ["card", "bank", "ussd", "qr", "mobile_money", "bank_transfer", "eft"],
            'metadata' => [
                'fee_type' => 'event',
                'custom_fields' => [
                    [
                        'display_name' => 'First Name',
                        'variable_name' => 'customer_first_name',
                        'value' => auth()->user()->first_name,
                    ],
                    [
                        'display_name' => 'Last Name',
                        'variable_name' => 'customer_last_name',
                        'value' => auth()->user()->last_name,
                    ],
                    [
                        'display_name' => 'Phone',
                        'variable_name' => 'customer_phone',
                        'value' => auth()->user()->phone,
                    ],
                ],
            ],
        ]);

        $splitCode = trim(config('pan.payment_split_code', ''));
        if ($this->isValidSplitCode($splitCode)) {
            $PaymentData["split_code"] = $splitCode;
        }

        try {
            $response = Http::withHeaders([
                'authorization' => 'Bearer ' . config('pan.paystack_secret_key')
            ])->post(config('pan.paystack_url') . '/initialize', $PaymentData);

            $response = $response->json();

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return redirect($response['data']['authorization_url']);
        } catch (Exception $e) {
            $event = $purchase['event'];
            $event = Event::find($event['id']);
            $error = 'Unable to Make Payment, ' . $e->getMessage();
            return view('user.events.step_three', compact('event', 'purchase', 'error'));
        }
    }

    public function isValidSplitCode($splitCode)
    {
        // Check if the input is empty or null
        if (empty($splitCode) || is_null($splitCode)) {
            return false;  // Return false for empty or null input
        }

        // Define the regular expression pattern to match the desired format
        $pattern = '/SPL_[A-Za-z0-9]+/';

        // Use preg_match to check if the pattern is found in the input string
        return preg_match($pattern, $splitCode) === 1;
    }

    public function bookHotelPay($event, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'quantity' => 'required|numeric',
            'res_type' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->errors());
        }

        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if (count($transactions) < 1) {
            return redirect()->back()->with('error', 'Unable to proceed, You have to complete your event registration');
        }

        $paidAccommodation = Accommodation::where('user_id', auth()->id())->where('event_id', $event)
            ->where('IsPaid', 1)->first();

        if (!is_null($paidAccommodation)) {
            return redirect()->back()->with('error', 'Unable to proceed, You have already booked a hotel for this event.');
        }

        $hotel = Hotel::whereId($request['hotel_id'])->first();
        if (is_null($hotel)) {
            return redirect()->back()->with('error', 'Selected hotel cannot be mapped to your account.');
        }

        if ($request['res_type'] <> 'pay') {

            $accData['hotel_id'] = $request['hotel_id'];
            $accData['user_id'] = auth()->id();
            $accData['event_id'] = $event;
            $accData['quantity'] = $request['quantity'];
            $accData['isPaid'] = 0;
            $accData['total_amount'] = (optional($hotel)->price ?? 0) * ($request['quantity'] ?? 0);

            $conditions = [
                'user_id' => $accData['user_id'],
                'event_id' => $accData['event_id'],
            ];

            Accommodation::updateOrCreate($conditions, $accData);
            return redirect()->route('user.events.index')
                ->with('success', 'Hotel Booking Accommodation Reserved Successfully.');
        }

        $ref = $this->genTranxRef();

        $accData['hotel_id'] = $request['hotel_id'];
        $accData['user_id'] = auth()->id();
        $accData['event_id'] = $event;
        $accData['payment_ref'] = $ref;
        $accData['quantity'] = $request['quantity'];
        $accData['isPaid'] = 0;
        $accData['total_amount'] = (optional($hotel)->price ?? 0) * ($request['quantity'] ?? 0);

        $conditions = [
            'user_id' => $accData['user_id'],
            'event_id' => $accData['event_id'],
        ];

        $accommodation = Accommodation::updateOrCreate($conditions, $accData);
        $hotel_price = $accommodation->total_amount ?? 0;

        $PaymentData = array_filter([
            "amount" => $this->getPaystackAmount($hotel_price),
            "reference" => $ref,
            "email" => auth()->user()->email,
            "callback_url" => env('APP_URL') . '/user/verify_payment',
            "currency" => "NGN",
            'channels' => ["card", "bank", "ussd", "qr", "mobile_money", "bank_transfer", "eft"],
            'metadata' => [
                'fee_type' => 'accommodation',
                'custom_fields' => [
                    [
                        'display_name' => 'First Name',
                        'variable_name' => 'customer_first_name',
                        'value' => auth()->user()->first_name,
                    ],
                    [
                        'display_name' => 'Last Name',
                        'variable_name' => 'customer_last_name',
                        'value' => auth()->user()->last_name,
                    ],
                    [
                        'display_name' => 'Phone',
                        'variable_name' => 'customer_phone',
                        'value' => auth()->user()->phone,
                    ],
                ],
            ],
        ]);

        $splitCode = trim(config('pan.payment_split_code', ''));
        if ($this->isValidSplitCode($splitCode)) {
            $PaymentData["split_code"] = $splitCode;
        }

        try {
            $response = Http::withHeaders([
                'authorization' => 'Bearer ' . config('pan.paystack_secret_key')
            ])->post(config('pan.paystack_url') . '/initialize', $PaymentData);

            $response = $response->json();

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return redirect($response['data']['authorization_url']);
        } catch (Exception $e) {
            $event = Event::find($event);
            $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();
            return view('user.events.book_hotel', compact('event', 'hotels', 'accommodation'))
                ->with('error', 'Unable to Make Payment, ' . $e->getMessage());
        }
    }

    public function manualPayment($id)
    {
        $transaction = Transaction::whereId($id)->first();
        $ref = $this->genTranxRef();

        $PaymentData = array_filter([
            "amount" => $this->getPaystackAmount($transaction->amount),
            "reference" => $ref,
            "email" => auth()->user()->email,
            "callback_url" => env('APP_URL') . '/user/verify_payment',
            "currency" => "NGN",
            'channels' => ["card", "bank", "ussd", "qr", "mobile_money", "bank_transfer", "eft"],
            'metadata' => [
                'fee_type' => 'event',
                'custom_fields' => [
                    [
                        'display_name' => 'First Name',
                        'variable_name' => 'customer_first_name',
                        'value' => auth()->user()->first_name,
                    ],
                    [
                        'display_name' => 'Last Name',
                        'variable_name' => 'customer_last_name',
                        'value' => auth()->user()->last_name,
                    ],
                    [
                        'display_name' => 'Phone',
                        'variable_name' => 'customer_phone',
                        'value' => auth()->user()->phone,
                    ],
                ],
            ]
        ]);

        $splitCode = trim(config('pan.payment_split_code', ''));
        if ($this->isValidSplitCode($splitCode)) {
            $PaymentData["split_code"] = $splitCode;
        }

        try {
            $response = Http::withHeaders([
                'authorization' => 'Bearer ' . config('pan.paystack_secret_key')
            ])->post(config('pan.paystack_url') . '/initialize', $PaymentData);

            $response = $response->json();

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            $transaction->transaction_reference = $PaymentData['reference'];
            $transaction->payment_method = 'card';
            $transaction->save();

            return redirect($response['data']['authorization_url']);
        } catch (Exception $e) {

            return redirect()->route('user.transactions')->with('error', 'Unable to Pay, ' . $e->getMessage());
        }
    }


    public function bankTransfer()
    {
        $data = Session('purchase');
        $event_price = optional($data)['event_price'];
        $exhibition = optional($data)['exhibition'];
        $isReserved = optional(optional($data)['hotel'])['reserved'];

        //TODO Fetch total hotel amount from accommodation table instead of cache
        //$hotel_price = (optional(optional($data)['hotel'])['price'] * optional(optional($data)['hotel'])['quantity']) ?? 0;
        $accommodation = optional(
            Accommodation::where('user_id', auth()->id())
                ->where('event_id', $data['event']['id'])
                ->first()
        );
        $hotel_price = $accommodation->total_amount ?? 0;

        //TODO Fetch total exhibition amount from exhibition purchases table instead of cache
        //$exhibition_total_price = optional($data)['exhibition_total_price'] ?? 0;
        $attendance_id = $data['attendance']['id'];
        $exhibition_total_price = 0;
        if($attendance_id){
            $exhibitions = ExhibitionPurchase::where('attendance_id', $attendance_id)->get();
            $exhibition_total_price = $exhibitions->sum('total_amount') ?? 0;
        }

        // Add Extra Charge When Done
        $total_price = $event_price + ($isReserved ? 0 : $hotel_price) + ($exhibition_total_price);

        $ref = sprintf("TRANS_%s", $this->genTranxRef(19));

        $conditions = [
            'event_id' => $data['event']['id'],
            'user_id' => auth()->user()->id,
        ];

        // Data to be inserted or updated
        $transactionData = [
            'event_id' => $data['event']['id'],
            'user_id' => auth()->user()->id,
            'amount' => $total_price,
            'status' => 'pending',
            'transaction_reference' => $ref
        ];

        // Use updateOrCreate to update or create the record and retrieve the model
        $transaction = Transaction::updateOrCreate($conditions, $transactionData);

        $event_price = $event_price ?? $this->getEventPrice(optional($transaction)->event, $transaction->user_id);

        $accommodation = Accommodation::where('user_id', $transaction->user_id)->where('event_id', $transaction->event_id)->orderBy('id', 'DESC')->first();

        $user = optional(optional($transaction)->user);
        $event = optional(optional($transaction)->event);
        $attendance = Attendance::whereUserId($user->id)->whereEventId($event->id)->first();

        $eventUserData = [
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'phone_number' => $user->phone,
            'email' => $user->email,
            'event_id' => optional(optional($transaction)->event)->id,
            'title' => optional(optional($transaction)->event)->title,
            'surname' => $attendance->surname,
            'gender' => $attendance->gender,
            'nature_practice' => $attendance->nature_of_practice,
            'institution' => $attendance->gender,
            'city' => $attendance->city,
            'state' => $attendance->state,
            'nationality' => $attendance->country,
            'paid' => false,
            'payment_ref' => $transaction->transaction_reference,
            'payment_type' => '',
            'total_amount' => $event_price ?? 0
        ];

        $conditions = [
            'event_id' => optional(optional($transaction)->event)->id,
            'user_id' => $user->id,
        ];

        EventUser::updateOrCreate($conditions, $eventUserData);

        /*if($accommodation){
            $hotel = Hotel::whereId(optional(optional($accommodation)->hotel)->id)->first();
            $hotel->no_rooms_available = ($hotel->no_rooms_available - optional($accommodation)->quantity);
            $hotel->save();
        }*/

        //TODO Add exhibitions as part of the email sent

        // Send Email
        $emailData = [
            'data' => [
                'name' => optional(optional($transaction)->user)->full_name,
                'event' => optional(optional($transaction)->event)->toArray(),
                'accommodation' => $accommodation ?? [],
                'amount' => $exhibition_total_price + $hotel_price + $event_price,
                'exhibition' => $exhibitions ?? [],
                'attendance' => isset($attendance) ? $attendance->toArray() : [],
                'type' => 'Bank Transfer',
                'event_price' =>  $event_price,
                'hotel' => optional(optional($accommodation)->hotel)->toArray(),
                'quantity' => optional($accommodation)->quantity,
                'event_price' => $event_price ?? 0,
                'hotel_price' => optional($accommodation)->total_amount ?? 0,
            ]
        ];

        (new EmailService())->sendEmail(optional(optional($transaction)->user)->email, 'Registration Confirmation | Pending Payment for ' . optional(optional(optional($emailData)['data'])['event'])['title'], 'emails.transfer', $emailData);

        //Send SMS
        $msg = 'Hello ' . optional(optional($transaction)->user)->full_name . ', We are excited to confirm your registration for the upcoming ' . optional(optional($transaction)->event)->title . ', which is scheduled to take place on ' . optional(optional($transaction)->event)->date . ' at ' . optional(optional($transaction)->event)->location . ' We have received your payment and can confirm the successful transaction';

        (new SMSService())->sendSMS($msg, auth()->user()->phone);

        return redirect('/user/events')->with('success', 'Congratulations, your event booking is confirmed. Check your email for payment details.');
    }

    public function finalizePayment(Request $request)
    {
        $response = Http::withHeaders([
            'authorization' => 'Bearer ' . config('pan.paystack_secret_key')
        ])->get(config('pan.paystack_url') . '/verify/' . $request->reference);

        if ($response->successful()) {
            $data = $response->json()['data'];
            $reference = $data['reference'];
            $status = $data['status'];

            $transaction = Transaction::where('transaction_reference', $reference)->whereNot('status', 'successful')->first();
            $accommodation = Accommodation::where('payment_ref', $reference)->whereNot('isPaid', true)->first();

            if (!is_null($transaction) || !is_null($accommodation)) {

                if ($status == 'success') {

                    //HOTEL BOOKING
                    if (isset($data['metadata']['fee_type']) && $data['metadata']['fee_type'] == 'accommodation')
                    {
                        $type = 'success';
                        $message = 'Hotel Booking Paid Successfully, you can download your event receipt.';

                        $accommodation->isPaid = 1;
                        $accommodation->save();

                        $transaction = Transaction::whereEventId($accommodation->event_id)
                            ->whereStatus('successful')
                            ->whereUserId($accommodation->user_id)
                            ->first();

                        $hotel = $accommodation->hotel;

                        $emailData = [
                            'data' => [
                                'name' => optional(optional($transaction)->user)->full_name,
                                'event' => optional(optional($transaction)->event)->toArray(),
                                'amount' => optional($accommodation)->total_amount ?? 0,
                                'type' => 'Card Payment',
                                'hotel' => optional(optional($accommodation)->hotel)->toArray(),
                                'quantity' => optional($accommodation)->quantity,
                                'hotel_price' => optional($accommodation)->total_amount ?? 0,
                            ]
                        ];

                        (new EmailService())->sendEmail(optional(optional($transaction)->user)->email, sprintf("Confirmation of Hotel Accommodation Payment - (%s)", $hotel->name), 'emails.hotel-paid', $emailData);

                    } else {
                        //EVENT PAYMENT
                        $accommodation = Accommodation::where('user_id', $transaction->user_id)->where('event_id', $transaction->event_id)->first();
                        $attendance = Attendance::whereUserId($transaction->user_id)->whereEventId($transaction->event_id)->first();

                        $type = 'success';
                        $message = 'Event Successfully Purchased';

                        $transaction->status = 'successful';
                        $transaction->save();

                        $totalHotelPrice = 0;
                        $exhibitionTotalPrice = 0;

                        if (!is_null($accommodation)) {
                            $accommodation->isPaid = 1;
                            $accommodation->transaction_id = $transaction->id;
                            $accommodation->payment_ref = null;
                            $totalHotelPrice = $accommodation->total_amount ?? 0;
                            $accommodation->save();
                        }

                        if (!is_null($attendance)) {
                            $exhibitions = ExhibitionPurchase::where('attendance_id', $attendance->id)->get();
                            $exhibitionTotalPrice = $exhibitions->sum('total_amount') ?? 0;

                            foreach ($exhibitions as $exhibition) {
                                $exhibition->update(['paid' => 'paid']);
                            }
                        }

                        $eventPrice = ($transaction->amount ?? 0) - $totalHotelPrice - $exhibitionTotalPrice;


                        //Create Event USer Record
                        $user = optional(optional($transaction)->user);
                        $event = optional(optional($transaction)->event);
                        $attendance = Attendance::whereUserId($user->id)->whereEventId($event->id)->first();

                        $eventUserData = [
                            'user_id' => $user->id,
                            'first_name' => $user->first_name,
                            'phone_number' => $user->phone,
                            'email' => $user->email,
                            'event_id' => optional(optional($transaction)->event)->id,
                            'title' => optional(optional($transaction)->event)->title,
                            'surname' => $attendance->surname,
                            'gender' => $attendance->gender,
                            'nature_practice' => $attendance->nature_of_practice,
                            'institution' => $attendance->institution,
                            'city' => $attendance->city,
                            'state' => $attendance->state,
                            'nationality' => $attendance->country,
                            'paid' => true,
                            'payment_ref' => $transaction->transaction_reference,
                            'payment_type' => '',
                            'total_amount' => $eventPrice
                        ];

                        $conditions = [
                            'event_id' => optional(optional($transaction)->event)->id,
                            'user_id' => $user->id,
                        ];


                        EventUser::updateOrCreate($conditions, $eventUserData);


                        $emailData = [
                            'data' => [
                                'name' => optional(optional($transaction)->user)->full_name,
                                'event' => optional(optional($transaction)->event)->toArray(),
                                'accommodation' => $accommodation ?? [],
                                'amount' => $exhibitionTotalPrice + (optional($accommodation)->total_amount ?? 0) + $eventPrice,
                                'exhibition' => $exhibitions ?? [],
                                'attendance' => isset($attendance) ? $attendance->toArray() : [],
                                'type' => $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment',
                                'hotel' => optional(optional($accommodation)->hotel)->toArray(),
                                'quantity' => optional($accommodation)->quantity,
                                'event_price' => $eventPrice,
                                'hotel_price' => optional($accommodation)->total_amount ?? 0,
                            ]
                        ];

                        /*$hotel = optional(optional($accommodation)->hotel);
                        $hotel->no_rooms_available = ($hotel->no_rooms_available - optional($accommodation)->quantity);
                        $hotel->save();*/

                        (new EmailService())->sendEmailWithReceipt(optional(optional($transaction)->user)->email, 'Registration and Payment Confirmation for ' . optional(optional(optional($emailData)['data'])['event'])['title'], 'emails.bought', $emailData);

                        //Send SMS
                        $msg = 'Hello ' . optional(optional($transaction)->user)->full_name . ', We are excited to confirm your registration for the upcoming ' . optional(optional($transaction)->event)->title . ', which is scheduled to take place on ' . optional(optional($transaction)->event)->date . ' at ' . optional(optional($transaction)->event)->location . ' We have received your payment and can confirm the successful transaction';
                        (new SMSService())->sendSMS($msg, auth()->user()->phone);
                        session()->forget('purchase');
                    }

                } else {
                    $transaction->status = 'failed';
                    $message = 'Unable to Purchase Event';
                    $type = 'success';
                }

                return redirect('/user/transactions')->with($type, $message);

            } else {
                $message = 'Transaction seems to have been processed, please check transaction status';
                $type = 'success';
                return redirect('/user/transactions')->with($type, $message);
            }
        }

    }

    /**
     * Handle Paystack webhook for successful transactions.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handlePaystackWebhook(Request $request)
    {
        // Log the incoming request
        Log::info('Paystack Webhook Request:', [
            'Headers' => $request->header(),
            'Payload' => $request->getContent(),
        ]);

        if ($request->method() !== 'POST' || !$request->header('x-paystack-signature')) {
            abort(403, 'Invalid Request');
        }

        // Retrieve the request's body (payload)
        $payload = $request->getContent();

        $paystackSecretKey = config('pan.paystack_secret_key');

        // Verify the webhook signature
        $signature = hash_hmac('sha512', $payload, $paystackSecretKey);

        if ($request->header('x-paystack-signature') !== $signature) {
            abort(403, 'Invalid Signature');
        }

        // Proceed with processing the webhook event
        $event = json_decode($payload);

        // Handle the event based on your application's requirements.
        if ($event->event === 'charge.success') {
            // Handle a successful payment event
            $reference = $event->data->reference;
            // Find and update the related transaction in your database.
            $transaction = Transaction::where('transaction_reference', $reference)->whereNot('status', 'successful')->first();

            if (!is_null($transaction)) {
                $accommodation = Accommodation::where('user_id', $transaction->user_id)->where('event_id', $transaction->event_id)->first();
                $attendance = Attendance::whereUserId($transaction->user_id)->whereEventId($transaction->event_id)->first();

                $transaction->status = 'successful';
                $transaction->save();

                $totalHotelPrice = 0;
                $exhibitionTotalPrice = 0;

                if (!is_null($accommodation)) {
                    $accommodation->isPaid = 1;
                    $accommodation->transaction_id = $transaction->id;
                    $totalHotelPrice = $accommodation->total_amount ?? 0;
                    $accommodation->save();
                }

                if (!is_null($attendance)) {
                    $exhibitions = ExhibitionPurchase::where('attendance_id', $attendance->id)->get();
                    $exhibitionTotalPrice = $exhibitions->sum('total_amount') ?? 0;
                    ExhibitionPurchase::where('attendance_id', $attendance->id)->update(['paid' => 'paid']);
                }

                // Send Email
                $emailData = [
                    'data' => [
                        'name' => optional(optional($transaction)->user)->full_name,
                        'event' => optional(optional($transaction)->event)->toArray(),
                        'hotel' => optional(optional($accommodation)->hotel)->toArray(),
                        'quantity' => optional($accommodation)->quantity,
                        'amount' => optional($transaction)->amount,
                    ]
                ];

                $eventPrice = ($transaction->amount ?? 0) - $totalHotelPrice - $exhibitionTotalPrice;

                //Create Event USer Record
                $user = optional(optional($transaction)->user);
                $event = optional(optional($transaction)->event);
                $attendance = Attendance::whereUserId($user->id)->whereEventId($event->id)->first();

                $eventUserData = [
                    'user_id' => $user->id,
                    'first_name' => $user->first_name,
                    'phone_number' => $user->phone,
                    'email' => $user->email,
                    'event_id' => optional(optional($transaction)->event)->id,
                    'title' => optional(optional($transaction)->event)->title,
                    'surname' => $attendance->surname,
                    'gender' => $attendance->gender,
                    'nature_practice' => $attendance->nature_of_practice,
                    'institution' => $attendance->gender,
                    'city' => $attendance->city,
                    'state' => $attendance->state,
                    'nationality' => $attendance->country,
                    'paid' => true,
                    'payment_ref' => $transaction->transaction_reference,
                    'payment_type' => '',
                    'total_amount' => $eventPrice
                ];

                $conditions = [
                    'event_id' => optional(optional($transaction)->event)->id,
                    'user_id' => $user->id,
                ];

                EventUser::updateOrCreate($conditions, $eventUserData);

                /*$hotel = optional(optional($accommodation)->hotel);
                $hotel->no_rooms_available = ($hotel->no_rooms_available - optional($accommodation)->quantity);
                $hotel->save();*/

                (new EmailService())->sendEmailWithReceipt(optional(optional($transaction)->user)->email, 'Registration and Payment Confirmation for ' . optional(optional(optional($emailData)['data'])['event'])['title'], 'emails.bought', $emailData);

                //Send SMS
                $msg = 'Hello ' . optional(optional($transaction)->user)->full_name . ', We are excited to confirm your registration for the upcoming ' . optional(optional($transaction)->event)->title . ', which is scheduled to take place on ' . optional(optional($transaction)->event)->date . ' at ' . optional(optional($transaction)->event)->location . ' We have received your payment and can confirm the successful transaction';
                (new SMSService())->sendSMS($msg, auth()->user()->phone);
            }
        }
        // Return a response to acknowledge the webhook.
        return response()->json(['message' => 'Webhook received']);
    }

    /**
     * Generate a Unique Transaction Reference
     * @return string
     */
    public function genTranxRef($length = 25)
    {
        do {
            $reference = TransRef::getHashedToken($length);
        } while (Transaction::where('transaction_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Calculate Paystack amount plus charge
     *
     * @param $amount
     * @return int
     */
    public function getPaystackAmount($amount){
        // Calculate the charge as (1.5% of amount) + extra_charge
        $charge = ($amount * 0.015) + config('pan.extra_charge', 0);

        // Calculate the total by adding amount and charge, then multiply by 100
        $total = ($amount + $charge) * 100;

        // Ensure the total is an integer value
        return intval($total);
    }


    public function loadUserTransactions(Request $request)
    {
        $userId = $request->input('user_id');

        if (is_null($userId)) {
            return response()->json('NO USER ID SUPPLIED', 404);
        }

        $transactions = Transaction::whereUserId($userId)->with('event')->get();
        return response()->json($transactions);
    }

    public function getEventPrice($event, $user_id)
    {
        if(!is_null($user_id) && !is_null($event)){
            $user = User::find($user_id);
            return $user->user_type ? ($event->{$user->user_type . '_price'} ?? 0) : $event->{'ordinary_member_price'} ?? 0;
        }

        return 0;

    }
}
