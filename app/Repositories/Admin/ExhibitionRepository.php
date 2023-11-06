<?php

namespace App\Repositories\Admin;

use App\Models\Exhibition;
use App\Repositories\BaseRepository;

class ExhibitionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'category',
        'amount',
        'description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Exhibition::class;
    }
}
