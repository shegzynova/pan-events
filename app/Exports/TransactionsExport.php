<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        $transactions = Transaction::latest()->get();

        $processedTransactions = [];

        foreach ($transactions as $index => $transaction) {
            $event = $transaction->event;
            $eventUser = $transaction->eventUser ?? $transaction->user;
            $reservation = optional($transaction->reservation);
            $hotel = optional($reservation->hotel);

            $exhibitionPurchases = optional($transaction->attendance)->exhibitionPurchases;
            $exhibitionTotalPrice = $exhibitionPurchases->sum("total_amount");
            $exhibitionStatus = optional($exhibitionPurchases->first())->paid;

            $eventAmount = $eventUser->total_amount ?? $transaction->amount;

            $user = $transaction->user;

            $processedTransactions[] = [
                'number' => $index + 1,
                'event' => optional($event)->title,
                'last_name' => $eventUser->surname ?? $user->last_name,
                'first_name' => $eventUser->first_name ?? $user->first_name,
                'email' => $eventUser->email ?? $user->email,
                'phone' => $eventUser->phone_number ?? $user->phone,
                'user_type' => ucwords(str_replace('_', ' ', ($transaction->user->user_type ?? "ordinary_member"))),
                'event_amount' => $eventAmount,
                'hotel_name' => $hotel->name ?? "No Bookings",
                'hotel_no_nights' => $hotel->name ? $reservation->quantity : "No Bookings",
                'hotel_unit_cost' => $hotel->name ? ($reservation->total_amount / max(1, $reservation->quantity)) : "No Bookings",
                'hotel_total_cost' => $hotel->name ? $reservation->total_amount : "No Bookings",
                'hotel_status' => $hotel->name ? ($reservation->isPaid == 1 ? "Paid" : "Reserved") : "No Bookings",
                'hotel_payment_ref' => $hotel->name ? ($reservation->isPaid == 1 ?
                    ($reservation->payment_ref ?? $transaction->transaction_reference) : "N/A") : "No Bookings",
                'exhibition_total' => $exhibitionStatus ? $exhibitionTotalPrice : "N/A",
                'exhibition_status' => $exhibitionStatus ? ($exhibitionStatus == "paid" ? "Paid" : "Unpaid") : "N/A",
                'total_amount_payable' => $eventAmount + ($exhibitionTotalPrice ?? 0) + ($reservation->total_amount ?? 0),
                'total_amount_paid' => $transaction->amount,
                'transaction_status' => ucfirst($transaction->status),
                'transaction_ref' => $transaction->transaction_reference,
                'payment_method' => ($transaction->payment_method === 'card') ? 'Card Payment' : 'Bank Transfer/Online Payment',
                'updated_at' => $transaction->updated_at ? date('Y-m-d h:i:s A', strtotime($transaction->updated_at)) : "",
            ];
        }

        return $processedTransactions;

    }

    public function headings(): array
    {
        return [
            '#',
            'Event',
            'Surname',
            'First Name',
            'Email',
            'Phone No.',
            'User type',
            'Event Amount paid',
            'Hotel name',
            'Number of nights',
            'Unit Hotel price',
            'Hotel total amount',
            'Hotel Payment status',
            'Hotel Payment Reference',
            'Exhibition total amount',
            'Exhibition payment status',
            'Total amount payable',
            'Total amount paid',
            'Transaction Status',
            'Transaction Reference',
            'Payment Method',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = Transaction::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:V' . $totalCount + 1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
