<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $total_payable = Transaction::whereUserId(auth()->id())->where('status', '<>', 'successful')->sum('amount');
        $total_paid = Transaction::whereUserId(auth()->id())->whereStatus('successful')->sum('amount');
        $total_hotel_payable = Accommodation::where('isPaid', false)->whereUserId(auth()->id())->sum('total_amount');
        $total_hotel_paid = Accommodation::where('isPaid', true)->whereUserId(auth()->id())->sum('total_amount');

        $total_event_payable = $total_payable - $total_hotel_payable;
        $total_event_paid = $total_paid - $total_hotel_paid;

        $data = [
            'total_payable' => $total_payable ?? 0,
            'total_event_payable' => max($total_event_payable, 0),
            'total_hotel_payable' => $total_hotel_payable ?? 0,
            'total_paid' => ($total_paid + $total_hotel_paid) ?? 0,
            'total_event_paid' => max($total_event_paid, 0),
            'total_hotel_paid' => $total_hotel_paid,
        ];
        return view('user.dashboard.index', compact('data'));
    }
}
