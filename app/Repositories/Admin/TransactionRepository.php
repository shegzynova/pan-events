<?php

namespace App\Repositories\Admin;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'event_id',
        'user_id',
        'amount',
        'status',
        'transaction_reference'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Transaction::class;
    }

    public function query()
    {
        return $this->model->newQuery();
    }
}
