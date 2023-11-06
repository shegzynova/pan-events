<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbstractsExport;
use App\Exports\EventExport;
use App\Exports\ExhibitionPurchasesExport;
use App\Exports\ExhibitionsExport;
use App\Exports\HotelExport;
use App\Exports\TransactionsExport;
use App\Exports\EventUsersExport;
use App\Exports\ReservationExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\AbstractModel;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Exhibition;
use App\Models\ExhibitionPurchase;
use App\Models\Hotel;
use App\Models\Reservations;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PDFService;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function pdf($model)
    {
        return $this->exportPDF($model);
    }

    public function excel($model)
    {
        return $this->exportExcel($model);
    }

    public function exportPDF($model)
    {
        $data = $this->getModelData($model);
        $pdfService = new PDFService($data);
        $title = 'report.' . $model;

        return $pdfService->downloadPDF($title);
    }

    public function exportExcel($model)
    {
        $export = $this->getModelExport($model);
        $filename = 'all ' . $model . '.xlsx';

        return Excel::download($export, $filename);
    }

    private function getModelData($model)
    {
        return match ($model) {
            'events' => $this->eventsPdf(),
            'hotels' => $this->hotelsPdf(),
            'users' => $this->usersPdf(),
            'event-users' => $this->eventUsersPdf(),
            'transactions' => $this->transactionsPdf(),
            'reservations' => $this->reservationsPdf(),
            'abstracts' => $this->abstractsPdf(),
            'exhibitions' => $this->exhibitionsPdf(),
            'exhibition-purchases' => $this->exhibitionPurchasesPdf(),
            default => [],
        };
    }

    private function getModelExport($model)
    {
        return match ($model) {
            'events' => new EventExport(),
            'hotels' => new HotelExport(),
            'users' => new UsersExport(),
            'reservations' => new ReservationExport(),
            'event-users' => new EventUsersExport(),
            'transactions' => new TransactionsExport(),
            'abstracts' => new AbstractsExport(),
            'exhibitions' => new ExhibitionsExport(),
            'exhibition-purchases' => new ExhibitionPurchasesExport(),
            default => null,
        };
    }

    public function eventsPdf()
    {
        $events = Event::latest()->select(
                        'category',
                        'title',
                        'unique_id',
                        'location',
                        'ordinary_member_price',
                        'trainee_member_price',
                        'associate_member_price',
                        'is_published',
                        'date')
                    ->get()->toArray();

        $headers = [
            '#',
            'Category',
            'Title',
            'UUID',
            'Location',
            'Ordinary Member Price',
            'Trainee Member Price',
            'Associate Member Price',
            'Status',
            'Date',
        ];

        return [
            'title' => 'Events Report',
            'data' => $events,
            'headers' => $headers
        ];
    }

    public function hotelsPdf()
    {
        $hotels = Hotel::latest()->select(
            'name',
            'address',
            'phone_contact',
            'price',
            'no_rooms_available',
            'event_id')
            ->get();

        $headers = [
            '#',
            'Name',
            'Address',
            'Contact',
            'Price',
            'No Rooms Available',
            'Event',
        ];

        return [
            'title' => 'Hotels Report',
            'data' => $hotels,
            'headers' => $headers
        ];
    }

    private function transactionsPdf()
    {
        $transactions = Transaction::latest()->select(
            'event_id',
            'user_id',
            'amount',
            'status',
            'transaction_reference',
            'payment_method',
            'created_at')
            ->get();

        $headers = [
            '#',
            'Event',
            'User',
            'Amount',
            'Status',
            'Transaction Reference',
            'Payment Method',
            'Date',
        ];

        return [
            'title' => 'Transactions Report',
            'data' => $transactions,
            'headers' => $headers
        ];
    }

    private function usersPdf()
    {
        $data = User::latest()->select(
            'first_name',
            'last_name',
            'username',
            'phone',
            'email',
            'user_type')
            ->get();

        $headers = [
            '#',
            'First Name',
            'Last Name',
            'Username',
            'Phone',
            'Email',
            'User Type',
        ];

        return [
            'title' => 'Users Report',
            'data' => $data,
            'headers' => $headers
        ];
    }

    private function eventUsersPdf()
    {
        $data = EventUser::latest()->select(
            'user_id',
            'event_id',
            'title',
            'first_name',
            'surname',
            'phone_number',
            'email',
            'gender',
            'nature_practice',
            'institution',
            'city',
            'state',
            'nationality',
            'paid',
            'payment_ref',
            'payment_type')
            ->get();

        $headers = [
            '#',
            'User',
            'Event',
            'Gender',
            'Nature of Practice',
            'Institution',
            'City',
            'State',
            'Nationality',
            'Paid',
            'Payment Ref',
            'Payment Type'
        ];

        return [
            'title' => 'Event Users Report',
            'data' => $data,
            'headers' => $headers
        ];
    }

    private function reservationsPdf()
    {
        $data = Reservations::latest()->select(
            'hotel_id',
            'user_id',
            'event_id',
            'quantity',
            'isPaid')
            ->get();

        $headers = [
            '#',
            'Hotel',
            'User',
            'Event',
            'Quantity',
            'IsPaid',
        ];

        return [
            'title' => 'Reservations Report',
            'data' => $data,
            'headers' => $headers
        ];
    }

    private function exhibitionsPdf()
    {
        $data = Exhibition::latest()
            ->get();

        $headers = [
            '#',
            'Category',
            'Amount',
            'Description',
            'Exhibition Type',
        ];

        return [
            'title' => 'Exhibitions Report',
            'data' => $data,
            'headers' => $headers
        ];
    }

    private function exhibitionPurchasesPdf()
    {
        $data = ExhibitionPurchase::latest()
            ->get();

        $headers = [
            '#',
            'Exhibition',
            'Attendee',
            'Paid',
        ];

        return [
            'title' => 'Exhibition Purchases Report',
            'data' => $data,
            'headers' => $headers
        ];
    }


    private function abstractsPdf()
    {
        $data = AbstractModel::latest()
            ->get();

        $headers = [
            '#',
            'Name',
            'Phone Number',
            'Email',
            'No Of Pages',
            'Abstract Title',
            'Duration',
            'Abstract Status',
            'Full Paper Status',
            'Presentation Status',
        ];

        return [
            'title' => 'Abstracts Report',
            'data' => $data,
            'headers' => $headers
        ];
    }
}
