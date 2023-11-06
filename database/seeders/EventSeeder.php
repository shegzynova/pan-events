<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'title'=> "Grand Event",
            'unique_id'=> "001",
            'slug'=> Str::slug(strtolower("Grand Event"), '_'),
            'location'=> 'Abuja',
            'regular_price'=> 1200.0,
            'speaker_price'=> 1500.10,
            'exhibition_price'=> 2010.2,
            'description'=> 'this is a test',
            'date'=> Carbon::now(),
            'Category'=> 'public',
            'is_published'=> 1
        ];
        DB::table('events')->insert($data);

    }
}
