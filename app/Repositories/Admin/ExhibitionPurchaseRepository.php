<?php

namespace App\Repositories\Admin;

use App\Models\ExhibitionPurchase;
use App\Repositories\BaseRepository;

class ExhibitionPurchaseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'paid'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ExhibitionPurchase::class;
    }
}
