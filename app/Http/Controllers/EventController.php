<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\SpeakerRequest;
use App\Http\Requests\StepOneRequest;
use App\Models\AbstractModel;
use App\Models\Accommodation;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\ExhibitionPurchase;
use App\Models\ExhibitionType;
use App\Models\Hotel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $events = Event::whereIsPublished(true)
            ->with('userAccommodation')
            ->with(['userAttendance' => function ($query) use ($userId) {
            $query->where('user_id', $userId)->latest('created_at');
        }])->get();

        return view('user.events.index', compact('events'));
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
    public function store(Request $request, Event $event)
    {
        dd( $request->all());
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();
        $event = Event::whereId($id)->with(['userAttendance' => function ($query) use ($userId) {
            $query->where('user_id', $userId)->latest('created_at');
        }])->first();

        return view('user.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function register(Event $event)
    {
        return view('user.events.create', compact('event'));
    }

    public function stepOneGet($event)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }
        $event = Event::findOrFail($event);
        $userData = Attendance::whereUserId(auth()->id())->whereEventId($event->id)->first();

        return view('user.events.step_one', compact('event', 'userData'));
    }

    public function stepOnePost($event, StepOneRequest $request)
    {
        session()->forget('purchase');
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $event = Event::findOrFail($event);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['nature_of_practice'] = $data['nature_practice'];
        $data['event_id'] = $event->id;
        unset($data['_token']); unset($data['_method']); unset($data['phone_number']); unset($data['register_as']);
        unset($data['nature_practice']); unset($data['education_level']);

        $conditions = [
            'user_id' => $data['user_id'],
            'event_id' => $data['event_id'],
        ];

        $saveAttendance = Attendance::updateOrCreate($conditions, $data);

        if($saveAttendance) {
            $sessionData = [
                'event' => $event->toArray(),
                'attendance_data' => $data,
                'event_price' => $this->getEventAmount($event),
                'attendance' => $saveAttendance,
            ];

            session(['purchase' => $sessionData]);
            // $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();

            return redirect()->route('user.events.step_two', $event->id);
            // return view('user.events.step_two', compact('sessionData', 'event', 'hotels'));
        }

        return redirect()->back()->with('error', 'Unable to proceed at the moment');

    }

    public function getEventAmount($event)
    {
        return auth()->user()->user_type ? ($event->{auth()->user()->user_type . '_price'} ?? 0) : $event->{'ordinary_member_price'} ?? 0;
    }

    public function stepTwoPost($event, Request $request)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $event = Event::find($event);
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'quantity' => 'required|numeric',
            'res_type' => 'required'
        ]);

        if($validator->fails()){
            $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();
            return redirect()->back()->with('errors', $validator->errors());
        }

        $purchase = session('purchase');
//        $event = $purchase['event'];

        $hotel = Hotel::whereId($request['hotel_id'])->first();

        $accData['isPaid'] = 0;//($request['res_type'] == 'pay') ? 1 : 0;
        $resType = $request['res_type'];
        $accData['event_id'] = $event->id;
        $accData['hotel_id'] = $request['hotel_id'];
        $accData['quantity'] = $request['quantity'];
        $accData['user_id'] = auth()->id();
        $accData['total_amount'] = (optional($hotel)->price ?? 0) * ($request['quantity'] ?? 0);
        unset($accData['res_type']);

        $conditions = [
            'user_id' => $accData['user_id'],
            'event_id' => $accData['event_id'],
        ];

        $accommodation = Accommodation::updateOrCreate($conditions, $accData);

        $purchase['hotel'] = [
            'name' => optional($hotel)->name,
            'price' => optional($hotel)->price,
            'quantity' => $accData['quantity'],
            'reserved' => ($resType == 'reserve')
        ];

        session(['purchase' => $purchase]);
       /* return redirect()->route('user.events.register.abstract_get', $event->id);*/
        return redirect()->route('user.events.register.exhibition_get', $event->id);
//        return view('user.events.exhibition', compact('event', 'purchase', 'exhibitions', 'userData'));
    }

    public function skipHotel($event)
    {
        $event = Event::find($event);
        $purchase = session('purchase');
        $exhibitions = Exhibition::latest('id')->get();
        $userData = Attendance::whereUserId(auth()->id())->whereEventId($event->id)->first();

        return view('user.events.abstract', compact('event', 'purchase', 'exhibitions', 'userData'));
    }


    public function stepTwo($event)
    {

        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $purchase = session('purchase');
        $event = Event::find($event);

        $accommodation = Accommodation::where('user_id', auth()->id())->where('event_id', $event->id)->first();

        $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();

        return view('user.events.step_two', compact('event', 'purchase', 'hotels', 'accommodation'));
    }

    public function bookHotel($event)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if (count($transactions) < 1) {
            return redirect()->back()->with('error', 'Unable to proceed, You have to complete your event registration');
        }

        $event = Event::find($event);

        $accommodation = Accommodation::where('user_id', auth()->id())->where('event_id', $event->id)->first();

        $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();

        return view('user.events.book_hotel', compact('event', 'hotels', 'accommodation'));
    }

    public function exhibitionGet($event)
    {

        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $purchase = session('purchase');
        $event = Event::find($event);
        $exhibition_types = ExhibitionType::with('exhibitions')->get();

        $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();

        $attendance = Attendance::whereUserId(auth()->id())->whereEventId($event->id)->first();
        $exhibitionIds = ExhibitionPurchase::where('attendance_id', $attendance->id)->pluck('exhibition_id')->toArray();

        return view('user.events.exhibition', compact('event', 'purchase', 'hotels', 'exhibition_types', 'exhibitionIds'));
    }

    public function abstractGet($event)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $purchase = session('purchase');
        $event = Event::find($event);

        $hotels = Hotel::orderBy('name', 'ASC')->where('event_id', $event->id)->get();

        return view('user.events.abstract', compact('event', 'purchase', 'hotels'));
    }

    public function abstractPost($event, Request $request)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $event = Event::find($event);
        $purchase = session('purchase');

        try {
            DB::beginTransaction();
            //Save if there is abstract
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $validations = Validator::make($request->all(), SpeakerRequest::rules());
                if($validations->fails()){
                    return redirect()->back()->with('errors', $validations->errors())->withInput($request->all());
                }
                $data = $request->all();
                $data['attendance_id'] = $purchase['attendance']['id'];

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('abstracts');
                $data['file'] = 'abstracts/'.$fileName;
                unset($data['_token']); unset($data['_method']); unset($data['exhibition']);

                $conditions = [
                    'attendance_id' => $data['attendance_id']
                ];
                $abstract = AbstractModel::updateOrCreate($conditions, $data);

                if($abstract) {
                    $file->move($filePath, $fileName);
                }
            }

            DB::commit();
            return redirect()->route('user.events.register.exhibition_get', $event->id);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Unable to proceed '. $e->getMessage());
        }
    }

    public function exhibitionPost($event, Request $request)
    {
        $transactions = Transaction::whereEventId($event)->whereStatus('successful')->whereUserId(auth()->id())->get();

        if( count($transactions) > 0 ){
            return redirect()->back()->with('error', 'Unable to proceed, You have already registered for this Event');
        }

        $event = Event::find($event);
        $purchase = session('purchase');

        try {
            DB::beginTransaction();
            //Save if there is abstract
            $validations = Validator::make($request->all(), ExhibitionRequest::rules());
            if($validations->fails()){
                return redirect()->back()->with('errors', $validations->errors())->withInput($request->all());
            }

            $exhibitions = $request->exhibition;

            $exhibitions = Exhibition::whereIn('id', $exhibitions);
            $exhibition_total_amount = $exhibitions->sum('amount');
            $exhibitions = $exhibitions->get();

            $attendance_id = $purchase['attendance']['id'];

            if ($attendance_id) {
                $exhibitionIds = $exhibitions->pluck('id')->toArray();

                foreach ($exhibitions as $exhibition) {
                    ExhibitionPurchase::updateOrInsert(
                        [
                            'attendance_id' => $attendance_id,
                            'exhibition_id' => $exhibition->id,
                            'total_amount' => $exhibition->amount
                        ]
                    );
                }

                // Delete records that are not in the $exhibitionIds array
                ExhibitionPurchase::where('attendance_id', $attendance_id)
                    ->whereNotIn('exhibition_id', $exhibitionIds)
                    ->delete();
            }


            $purchase['exhibitions'] = $exhibitions;
            $purchase['exhibition_total_price'] = $exhibition_total_amount;

            session(['purchase' => $purchase]);

            DB::commit();
            return redirect()->route('user.events.register.final_get', $event->id);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Unable to proceed '. $e->getMessage());
        }
    }

    public function finalGet($event)
    {
        $event = Event::find($event);
        $purchase = session('purchase');

        return view('user.events.step_three', compact('event', 'purchase'));
    }
}
