<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventUserRequest;
use App\Models\Accommodation;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventHotel;
use App\Models\EventUser;
use App\Models\ExhibitionPurchase;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Event $event)
    {
        dd($event, $request->all());
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventUserRequest $request, Event $event)
    {

        $eventUserData = $request->all();
        $eventUserData['user_id'] = auth()->id();
        $eventUserData['event_id'] = $event->id ?? 1;

        $event_user = EventUser::create($eventUserData);

        // Update Users Records as well

        if ($event_user) {
            $hotels = EventHotel::whereEventId(1)->get();
            return view('user.events.hotel', compact('hotels'))->with('success', 'Signup successfully!');

            // return Redirect::route('user.events.hotel')->with('success', 'Signup successfully!');
        }

        return back()->withErrors('Signup failed. Please try again.');
    }

    public function downloadReceipt($txn)
    {
        $transaction = Transaction::findOrFail($txn);
        $exhibition_amount = 0;
        $accommodation = Accommodation::where('user_id', $transaction->user_id)->where('event_id', $transaction->event_id)->where('IsPaid', true)->first();
        $attendance = Attendance::whereUserId($transaction->user_id)->whereEventId($transaction->event_id)->first();
        if (!is_null($attendance)) {
            $exhibitions = ExhibitionPurchase::where('attendance_id', $attendance->id)->where('paid', 'paid')->get();

            foreach ($exhibitions AS $exhibition){
                $exhibition_amount += $exhibition->total_amount;
            }
        }
        $event_price = EventUser::where('event_id', $transaction->event_id)->where('user_id', $transaction->user_id)->first();
        $event_price = isset(optional($event_price)->total_amount) ? $event_price->total_amount : 0;
        $hotel_price = isset(optional($accommodation)->total_amount) ? $accommodation->total_amount : 0;


        $data = [
            'data' => [
                'name' => optional(optional($transaction)->user)->full_name,
                'event' => optional(optional($transaction)->event)->toArray(),
                'accommodation' => $accommodation ?? [],
                'amount' => $exhibition_amount + $hotel_price + $event_price,
                'exhibition' => $exhibitions ?? [],
                'attendance' => isset($attendance) ? $attendance->toArray() : [],
                'type' => $transaction->payment_method == 'card' ? 'Card Payment' : 'Bank Transfer/Online Payment',
                'hotel' => optional(optional($accommodation)->hotel)->toArray(),
                'quantity' => optional($accommodation)->quantity,
                'event_price' => $event_price,
                'hotel_price' => $hotel_price,
            ]
        ];

        $pdf = Pdf::setPaper('letter')->loadView('receipt', $data);

        return $pdf->stream(optional($transaction)->transaction_reference .'.pdf');

    }



}
