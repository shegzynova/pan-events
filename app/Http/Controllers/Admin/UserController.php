<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\EventUser;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use App\Services\EmailService;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends AppBaseController
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('permission:read user|create user|update user|delete user', ['only' => ['index', 'create', 'edit', 'destroy']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {

        $query = $request->input('query');
        $role = $request->input('role');

        //dd($role);

        $queryBuilder = $this->userRepository->query();

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->whereRaw("LOWER(first_name) LIKE ?", ['%' . strtolower($query) . '%'])
                    ->orWhereRaw("LOWER(last_name) LIKE ?", ['%' . strtolower($query) . '%'])
                    ->orWhereRaw("LOWER(email) LIKE ?", ['%' . strtolower($query) . '%'])
                    ->orWhereRaw("LOWER(username) LIKE ?", ['%' . strtolower($query) . '%'])
                    ->orWhereRaw("LOWER(phone) LIKE ?", ['%' . strtolower($query) . '%']);
            });
        }

        if (!empty($role)) {
            $queryBuilder->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.name', $role);
        }

        $users = $queryBuilder->paginate(10);

        return view('admin.users.index', compact('users', 'query', 'role'));
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $roles = ['Select Role'] + Role::pluck('name', 'id')->toArray();
        $user_types = ['' => 'Select User Type', 'ordinary_member' => 'Ordinary Member', 'trainee_member' => 'Trainee Member', 'associate_member' => 'Associate Member'];
        $permissions = ['Select Permission'] + Permission::pluck('name', 'id')->toArray();

        return view('admin.users.create', compact('roles', 'user_types', 'permissions'));
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make('password');
        $input['email_verified_at'] = now();
        $user = $this->userRepository->create($input);

        $user->assignRole($input['role']);

        Flash::success('User saved successfully.');

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $user_types = ['' => 'Select User Type', 'ordinary_member' => 'Ordinary Member', 'trainee_member' => 'Trainee Member', 'associate_member' => 'Associate Member'];

        $roles = ['Select Role'] + Role::pluck('name', 'id')->toArray();

        $permissions = ['Select Permission'] + Permission::pluck('name', 'id')->toArray();
        $rolePermissions = $user->permissions()->pluck('id')->toArray();

        return view('admin.users.edit', compact('roles', 'user', 'user_types', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified User in storage.
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        $user->syncRoles($request->role);
        if($request->filled('permission')){
            $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();

//            dd($permissions);
            $user->syncPermissions($permissions);
        }else{
            $user->syncPermissions([]);
        }

        Flash::success('User updated successfully.');

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('admin.users.index'));
    }

    public function sendSms(Request $request)
    {
        $message = $request->message;
        $ids = $request->ids;


        foreach ($ids AS $id){

            $eventUser = EventUser::whereId($id)->first();

            if(!is_null($eventUser)){
                (new SMSService())->sendSMS($message, $eventUser->phone_number);
            }

        }

        return response()->json('success', 200);
    }

    public function sendEmail(Request $request)
    {
        $message = $request->message;
        $subject = $request->subject;
        $ids = $request->ids;



        foreach ($ids AS $id){

            $eventUser = EventUser::whereId($id)->first();

            if(!is_null($eventUser)){
                $data = [
                    'data' => [
                        'message' => $message,
                        'name' => optional($eventUser)->first_name
                    ]
                ];
                (new EmailService())->sendEmail($eventUser->email, $subject, 'emails.email', $data);
            }

        }


        return response()->json('success', 200);
    }
}
