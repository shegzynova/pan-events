<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateEventUserRequest;
use App\Http\Requests\UpdateEventUserRequest;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Admin\EventUserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventUserController extends AppBaseController
{
    /** @var EventUserRepository $eventUserRepository */
    private $eventUserRepository;

    public function __construct(EventUserRepository $eventUserRepo)
    {
        $this->middleware('permission:read eventuser|create eventuser|update eventuser|delete eventuser', ['only' => ['index','store']]);
        $this->middleware('permission:create eventuser', ['only' => ['create','store']]);
        $this->middleware('permission:update eventuser', ['only' => ['edit','update']]);
        $this->middleware('permission:delete eventuser', ['only' => ['destroy']]);
        $this->eventUserRepository = $eventUserRepo;
    }

    /**
     * Display a listing of the EventUser.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $queryBuilder = $this->eventUserRepository->query();

        if ($query) {
            $queryBuilder->orWhere('payment_ref', '=', $query)
                ->orWhere(function ($q) use ($query) {
                    $q->whereHas('user', function ($userQuery) use ($query) {
                        $userQuery->whereRaw("LOWER(first_name) LIKE ?", ['%' . strtolower($query) . '%'])
                            ->orWhereRaw("LOWER(last_name) LIKE ?", ['%' . strtolower($query) . '%'])
                            ->orWhereRaw("LOWER(email) LIKE ?", ['%' . strtolower($query) . '%']);
                    });
                });
        }

        if (strlen($status) > 0) {
            $queryBuilder->where('paid', intval($status));
        }

        $eventUsers = $queryBuilder->paginate(10);

        return view('admin.event_users.index', compact('eventUsers', 'query', 'status'));
    }

    /**
     * Show the form for creating a new EventUser.
     */
    public function create()
    {
        $events = ['Select an Event'] + Event::latest('id')->pluck('title', 'id')->toArray();
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();

        $genders = [
            'male' => 'Male',
            'female' => 'Female'
        ];

        $titles = [
            'mr' => 'Mr',
            'mrs' => 'Mrs',
            'dr' => 'Dr',
            'miss' => 'Miss',

        ];

        return view('admin.event_users.create', compact('users', 'events', 'genders', 'titles'));
    }

    /**
     * Store a newly created EventUser in storage.
     */
    public function store(CreateEventUserRequest $request)
    {
        $input = $request->all();
        $user = User::find($input['user_id']);
        $input['total_amount'] = $this->getEventAmount($input['user_id'], $input['event_id']);
        $input['first_name'] = optional($user)->first_name;
        $input['email'] = optional($user)->email;
        $input['phone_number'] = optional($user)->phone;
        $input['last_name'] = optional($user)->last_name;


        $this->eventUserRepository->create($input);

        Flash::success('Event User saved successfully.');

        return redirect(route('admin.eventUsers.index'));
    }

    public function getEventAmount($userId, $eventId)
    {
        $event = Event::find($eventId);
        $user = User::find($userId);
        return $user->user_type ? ($event->{$user->user_type . '_price'} ?? 0) : $event->{'ordinary_member_price'} ?? 0;
    }

    /**
     * Display the specified EventUser.
     */
    public function show($id)
    {
        $eventUser = $this->eventUserRepository->find($id);

        if (empty($eventUser)) {
            Flash::error('Event User not found');

            return redirect(route('admin.eventUsers.index'));
        }
        $transactions = Transaction::whereUserId($eventUser->user_id)->get();

        return view('admin.event_users.show', compact('eventUser', 'transactions'));
    }

    /**
     * Show the form for editing the specified EventUser.
     */
    public function edit($id)
    {
        $eventUser = $this->eventUserRepository->find($id);

        if (empty($eventUser)) {
            Flash::error('Event User not found');

            return redirect(route('admin.eventUsers.index'));
        }
        $events = Event::latest('id')->pluck('title', 'id')->toArray();
        $events = ['Select an Event'] + $events;

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();


        $genders = [
            'male' => 'Male',
            'female' => 'Female'
        ];

        $titles = [
            'mr' => 'Mr',
            'mrs' => 'Mrs',
            'dr' => 'Dr',
            'miss' => 'Miss',

        ];

        $transactions = Transaction::whereUserId($eventUser->user_id)->get();

        return view('admin.event_users.edit', compact('genders', 'users', 'events', 'eventUser', 'transactions', 'titles'));
    }

    /**
     * Update the specified EventUser in storage.
     */
    public function update($id, UpdateEventUserRequest $request)
    {
        $eventUser = $this->eventUserRepository->find($id);

        if (empty($eventUser)) {
            Flash::error('Event User not found');

            return redirect(route('admin.eventUsers.index'));
        }
        $input = $request->all();
        $user = User::find($input['user_id']);
        $input['total_amount'] = $this->getEventAmount($input['user_id'], $input['event_id']);
        $input['first_name'] = optional($user)->first_name;
        $input['email'] = optional($user)->email;
        $input['phone_number'] = optional($user)->phone;
        $input['last_name'] = optional($user)->last_name;


        $this->eventUserRepository->update($input, $id);

        Flash::success('Event User updated successfully.');

        return redirect(route('admin.eventUsers.index'));
    }

    /**
     * Remove the specified EventUser from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $eventUser = $this->eventUserRepository->find($id);

        if (empty($eventUser)) {
            Flash::error('Event User not found');

            return redirect(route('admin.eventUsers.index'));
        }

        $this->eventUserRepository->delete($id);

        Flash::success('Event User deleted successfully.');

        return redirect(route('admin.eventUsers.index'));
    }

    public function downloadReceipt($txn)
    {
        return (new \App\Http\Controllers\EventUserController())->downloadReceipt($txn);
    }
}
