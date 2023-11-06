<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Accommodation;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\ExhibitionPurchase;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PaymentApprovalNot;
use App\Repositories\Admin\TransactionRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends AppBaseController
{
    /** @var TransactionRepository $transactionRepository*/
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->middleware('permission:read transaction|create transaction|update transaction|delete transaction', ['only' => ['index','store']]);
        $this->middleware('permission:create transaction', ['only' => ['create','store']]);
        $this->middleware('permission:update transaction', ['only' => ['edit','update']]);
        $this->middleware('permission:delete transaction', ['only' => ['destroy']]);
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the Transaction.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $queryBuilder = $this->transactionRepository->query();

        if ($query) {
            $queryBuilder->orWhere('transaction_reference', '=', $query)
                ->orWhere(function ($q) use ($query) {
                    $q->whereHas('user', function ($userQuery) use ($query) {
                        $userQuery->whereRaw("LOWER(first_name) LIKE ?", ['%' . strtolower($query) . '%'])
                            ->orWhereRaw("LOWER(last_name) LIKE ?", ['%' . strtolower($query) . '%'])
                            ->orWhereRaw("LOWER(email) LIKE ?", ['%' . strtolower($query) . '%']);
                    });
                });
        }

        if ($status && in_array($status, ['successful', 'pending', 'failed'])) {
            $queryBuilder->where('status', $status);
        }

        $transactions = $queryBuilder->orderBy('id', 'DESC')->paginate(10);

        return view('admin.transactions.index', compact('transactions', 'query', 'status'));
    }

    /**
     * Show the form for creating a new Transaction.
     */
    public function create()
    {
        $events = Event::latest('id')->pluck('title', 'id')->toArray();
        $users = User::latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();
        $status = [
            'pending' => 'Pending',
            'successful' => 'Successful',
            'failed' => 'Failed'
        ];

        return view('admin.transactions.create', compact('events', 'users', 'status'));
    }

    /**
     * Store a newly created Transaction in storage.
     */
    public function store(CreateTransactionRequest $request)
    {
        $input = $request->all();

        $transaction = $this->transactionRepository->create($input);

        Flash::success('Transaction saved successfully.');

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Display the specified Transaction.
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('admin.transactions.index'));
        }

        return view('admin.transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified Transaction.
     */
    public function edit($id)
    {
        $transaction = $this->transactionRepository->find($id);
        $events = Event::latest('id')->pluck('title', 'id')->toArray();
        $events = $events + ['Select an Event'];

        $users = User::latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();
        $users = $users + ['Select a User'];

        $status = [
            'pending' => 'Pending',
            'successful' => 'Successful',
            'failed' => 'Failed'
        ];

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('admin.transactions.index'));
        }

        return view('admin.transactions.edit', compact('transaction', 'status', 'events', 'users'));
    }

    /**
     * Update the specified Transaction in storage.
     */
    public function update($id, UpdateTransactionRequest $request)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('admin.transactions.index'));
        }

        $transaction = $this->transactionRepository->update($request->all(), $id);
//        dd($transaction);

        if (!is_null($transaction)) {
            $accommodation = Accommodation::where('user_id', $transaction->user_id)->where('event_id', $transaction->event_id)->first();
            $attendance = Attendance::whereUserId($transaction->user_id)->whereEventId($transaction->event_id)->first();
            $eventUser = EventUser::whereUserId($transaction->user_id)->whereEventId($transaction->event_id)->first();

            if (!is_null($accommodation)) {
                $accommodation->isPaid = $transaction->status == 'successful' ? 1 : 0;
                $accommodation->transaction_id = $transaction->status == 'successful' ? $transaction->id : null;
                $accommodation->save();
            }

            if (!is_null($eventUser)) {
                $eventUser->paid = $transaction->status == 'successful' ? true : false;
                $eventUser->payment_ref = $transaction->status == 'successful' ? $transaction->transaction_reference : null;
                $eventUser->save();
            }

            if (!is_null($attendance)) {
                $newStatus = $transaction->status == 'successful' ? 'paid' : 'unpaid';
                ExhibitionPurchase::where('attendance_id', $attendance->id)->update(['paid' => $newStatus]);
            }

            if($request->status == 'successful'){
                //Send Email
                $user = $transaction->user;
                $data = [
                    'full_name' => $user->full_name,
                    'event_name' => optional(optional($transaction)->event)->title,
                    'event_date' => optional(optional($transaction)->event)->date,
                    'event_venue' => optional(optional($transaction)->event)->location,
                ];

                $user->notify(new PaymentApprovalNot($data));
            }
        }

        Flash::success('Transaction and all related records updated successfully.');

        return redirect(route('admin.transactions.index'));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('admin.transactions.index'));
        }

        $this->transactionRepository->delete($id);

        Flash::success('Transaction deleted successfully.');

        return redirect(route('admin.transactions.index'));
    }
}
