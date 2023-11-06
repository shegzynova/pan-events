<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateReservationsRequest;
use App\Http\Requests\UpdateReservationsRequest;
use App\Http\Controllers\AppBaseController;
use App\Jobs\HotelReservation;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Admin\ReservationsRepository;
use Illuminate\Http\Request;
use Flash;

class ReservationsController extends AppBaseController
{
    /** @var ReservationsRepository $reservationsRepository*/
    private $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepo)
    {
        $this->middleware('permission:read reservation|create reservation|update reservation|delete reservation', ['only' => ['index','store']]);
        $this->middleware('permission:create reservation', ['only' => ['create','store']]);
        $this->middleware('permission:update reservation', ['only' => ['edit','update']]);
        $this->middleware('permission:delete reservation', ['only' => ['destroy']]);
        $this->reservationsRepository = $reservationsRepo;
    }

    /**
     * Display a listing of the Reservations.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');
        $selectedHotelId = $request->input('hotel_id');

        $queryBuilder = $this->reservationsRepository->query();

        $hotels = Hotel::latest('id')->pluck('name', 'id')->toArray();

        if ($query) {
            $queryBuilder->orWhere(function ($q) use ($query) {
                $q->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->whereRaw("LOWER(first_name) LIKE ?", ['%' . strtolower($query) . '%'])
                        ->orWhereRaw("LOWER(last_name) LIKE ?", ['%' . strtolower($query) . '%'])
                        ->orWhereRaw("LOWER(email) LIKE ?", ['%' . strtolower($query) . '%']);
                });
            });
        }

        if ($selectedHotelId && array_key_exists($selectedHotelId, $hotels)) {
            $queryBuilder->where('hotel_id', $selectedHotelId);
        }

        if (strlen($status) > 0) {
            $queryBuilder->where('isPaid', intval($status));
        }

        $reservations = $queryBuilder->paginate(10);

        return view('admin.reservations.index', compact('reservations', 'query', 'selectedHotelId', 'hotels', 'status'));
    }

    /**
     * Show the form for creating a new Reservations.
     */
    public function create()
    {
        $hotels = Hotel::latest('id')->pluck('name', 'id')->toArray();
        $users = ['Select User'];
        $all_users = User::latest('id')->get();

        foreach ($all_users as $user) {
            $users[$user->id] = $user->full_name;
        }
        $events = Event::latest('id')->pluck('title', 'id')->toArray();
        $transactions = [];

        return view('admin.reservations.create', compact('hotels', 'users', 'transactions', 'events'));
    }

    /**
     * Store a newly created Reservations in storage.
     */
    public function store(CreateReservationsRequest $request)
    {
        $input = $request->all();

        $reservations = $this->reservationsRepository->create($input);

        Flash::success('Reservations saved successfully.');

        $this->updateAccommodationTotalAmount($reservations);

        HotelReservation::dispatch($reservations->toArray())->onQueue('default');
        return redirect(route('admin.reservations.index'));
    }


    public function updateAccommodationTotalAmount($reservations)
    {
        if ($reservations) {
            $hotelPrice = Hotel::find($reservations->hotel_id)->price ?? 0;
            $reservations->total_amount = $hotelPrice * ($reservations->quantity ?? 0);
            $reservations->save();
        }
    }

    /**
     * Display the specified Reservations.
     */
    public function show($id)
    {
        $reservations = $this->reservationsRepository->find($id);

        if (empty($reservations)) {
            Flash::error('Reservations not found');

            return redirect(route('admin.reservations.index'));
        }

        return view('admin.reservations.show')->with('reservations', $reservations);
    }

    /**
     * Show the form for editing the specified Reservations.
     */
    public function edit($id)
    {
        $reservations = $this->reservationsRepository->find($id);

        if (empty($reservations)) {
            Flash::error('Reservations not found');

            return redirect(route('admin.reservations.index'));
        }

        $hotels = Hotel::latest('id')->pluck('name', 'id')->toArray();
        $users = ['Select User'];
        $all_users = User::latest('id')->get();

        foreach ($all_users as $user) {
            $users[$user->id] = $user->full_name;
        }
        $events = Event::latest('id')->pluck('title', 'id')->toArray();

        $transactions = Transaction::whereUserId($reservations->user_id)->get();

        return view('admin.reservations.edit', compact('hotels', 'users', 'transactions', 'events', 'reservations'));
    }

    /**
     * Update the specified Reservations in storage.
     */
    public function update($id, UpdateReservationsRequest $request)
    {
        $reservations = $this->reservationsRepository->find($id);

        if (empty($reservations)) {
            Flash::error('Reservations not found');

            return redirect(route('admin.reservations.index'));
        }

        $reservations = $this->reservationsRepository->update($request->all(), $id);

        $this->updateAccommodationTotalAmount($reservations);

        Flash::success('Reservations updated successfully.');

        return redirect(route('admin.reservations.index'));
    }

    /**
     * Remove the specified Reservations from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reservations = $this->reservationsRepository->find($id);

        if (empty($reservations)) {
            Flash::error('Reservations not found');

            return redirect(route('admin.reservations.index'));
        }

        $this->reservationsRepository->delete($id);

        Flash::success('Reservations deleted successfully.');

        return redirect(route('admin.reservations.index'));
    }
}
