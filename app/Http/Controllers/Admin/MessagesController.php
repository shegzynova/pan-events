<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Messages::select('from_id', 'to_id', DB::raw('COUNT(*) as message_count, body'))
            ->where('to_id', auth()->id())
            ->orWhere('from_id', auth()->id())
            ->groupBy('from_id', 'to_id')
            ->get();

        $unseen_messages = Messages::select('from_id', DB::raw('COUNT(*) as message_count'))
            ->where(function ($query) {
                $query->where('to_id', auth()->id())
                    ->orWhere('from_id', auth()->id());
            })
            ->where('seen', false)
            ->groupBy('from_id')
            ->get();

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
