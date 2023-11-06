<?php

namespace App\Repositories\Admin;

use App\Models\AbstractModel;
use App\Repositories\BaseRepository;

class AbstractRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'full_name',
        'contact_phone_number',
        'email',
        'address',
        'no_of_pages',
        'abstract_title',
        'duration',
        'additional_information',
        'file'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return AbstractModel::class;
    }
}
