<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('admin.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();

        return view('admin.notification.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    {
        $validated = $request->validated();

        if($request->filled('for')){
            $validated['for'] = json_encode($validated['for']);
        }

        if(Notification::create($validated)){
            return redirect()->route('admin.notifications.index')->with('success', 'Notification Created Successfully');
        }

        return redirect()->route('admin.notifications.index')->with('error', 'Unable to create Notification');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notification = Notification::findOrFail($id);

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->latest('id')->pluck(DB::raw("CONCAT(first_name, ' ', last_name)"), 'id')->toArray();

        return view('admin.notification.edit', compact('users', 'notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationRequest $request, string $id)
    {
        $notification = Notification::findOrFail($id);
        $validated = $request->validated();

        if($request->filled('for')){
            $validated['for'] = json_encode($validated['for']);
        }

        if($notification->update($validated)){
            return redirect()->route('admin.notifications.index')->with('success', 'Notification Updated Successfully');
        }

        return redirect()->route('admin.notifications.index')->with('error', 'Unable to update Notification');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->delete();
        }

        return redirect()->route('admin.notification.roles')
            ->with('success','Notification deleted successfully');
    }

    public function updateNot($id)
    {
        $notification = Notification::findOrFail($id);

        $seen = json_decode($notification->seen, true) ?: [];

        if (!in_array(auth()->id(), $seen)) {
            $seen[] = auth()->id();
            $notification->update(['seen' => json_encode($seen)]);
        }

        return response()->json('success', 200);
    }
}
