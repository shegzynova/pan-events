<?php

namespace App\Repositories\Admin;

use App\Models\Hotel;
use App\Repositories\BaseRepository;

class HotelRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'address',
        'phone_contact',
        'price',
        'no_rooms_available'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Hotel::class;
    }
}
