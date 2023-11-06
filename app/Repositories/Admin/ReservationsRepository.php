<?php

namespace App\Repositories\Admin;

use App\Models\Reservations;
use App\Repositories\BaseRepository;

class ReservationsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'hotel_id',
        'quantity',
        'isPaid'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Reservations::class;
    }

    public function query()
    {
        return $this->model->newQuery();
    }
}
