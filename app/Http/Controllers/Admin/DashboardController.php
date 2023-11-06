<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Attendance;
use App\Models\Hotel;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_payable = Transaction::whereNot('status', 'successful')->sum('amount');

        $total_hotel_payable = Accommodation::where('isPaid', false)->sum('total_amount');

        $total_hotel_paid = Accommodation::where('isPaid', true)->sum('total_amount');

        $total_paid_online = Transaction::where('status', 'successful')->where('payment_method', 'card')->sum('amount');

        $total_hotel_local = Transaction::where('status', 'successful')->whereNot('payment_method', 'card')->sum('amount');

        $total_paid = Transaction::where('status', 'successful')->sum('amount');

        $data = [
            'registration' => [
                'all_registrants' => Attendance::all()->count(),
                'naija_registrants' => Attendance::where('country', 161)->count(),
                'foreign_registrant' => Attendance::whereNot('country', 161)->count(),
                'total_paid' => Transaction::where('status', 'successful')->count(),
                'total_unpaid' => Transaction::whereNot('status', 'successful')->count(),
                'total_checked_in' => Accommodation::where('isPaid', true)->count(),
                'paid_online' => Transaction::where('status', 'successful')->where('payment_method', 'card')->count(),
                'paid_in_bank' => Transaction::where('status', 'successful')->whereNot('payment_method', 'card')->count()
            ],
            'financial' => [
                'total_payable' => $total_payable,
                'total_reg_fee_payable' => $total_payable - $total_hotel_payable,
                'total_hotel_fee_payable' => $total_hotel_payable,
                'total_paid' => $total_paid,
                'total_paid_for_reg' => $total_paid - $total_hotel_paid,
                'total_paid_for_hotel' => $total_hotel_paid,
                'total_paid_online' => $total_paid_online,
                'total_paid_in_bank' => $total_hotel_local,
            ]
        ];

        $hotels = Hotel::latest()->get();
        $hotelData = [];

        foreach ($hotels as $hotel) {

            $DATA = [
                'name' => $hotel->name ?? '',
                'price' => $hotel->price,
                'total_paid' => Accommodation::whereHotelId($hotel->id)->where('isPaid', true)->sum('total_amount'),
                'total_unpaid' => Accommodation::whereHotelId($hotel->id)->where('isPaid', false)->sum('total_amount') ?? 0
            ];
            $hotelData[] = $DATA;
        }

        return view('admin.dashboard.index', compact('data', 'hotelData'));
    }
}
