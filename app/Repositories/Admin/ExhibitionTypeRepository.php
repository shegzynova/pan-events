<?php

namespace App\Repositories\Admin;

use App\Models\ExhibitionType;
use App\Repositories\BaseRepository;

class ExhibitionTypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'type',
        'is_active'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ExhibitionType::class;
    }
}
