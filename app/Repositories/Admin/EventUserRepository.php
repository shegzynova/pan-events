<?php

namespace App\Repositories\Admin;

use App\Models\EventUser;
use App\Repositories\BaseRepository;

class EventUserRepository extends BaseRepository
{
    protected $fieldSearchable = [
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
        'payment_type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return EventUser::class;
    }

    public function query()
    {
        return $this->model->newQuery();
    }
}
