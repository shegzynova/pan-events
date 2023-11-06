<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

//    public function __construct()
//    {
////        $notifications = \App\Models\Notification::whereJsonContains('for', auth()->id())->orWhere('for', json_encode([]))->get();
//
//        $this->middleware('auth');
////        $userId = auth()->id();
//        dd(auth()->user());
//
////dd($notifications, $userId);
//        // Sharing is caring
//        View::share('notifications_', $notifications);
//    }
}
