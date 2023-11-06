<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'John Boris Inn',
                'address' => 'No 5a, Ikeja',
                'phone_contact' => 23457568990,
                'price' => 3000.03,
                'no_rooms_available' => 15,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Boris Hotel',
                'address' => 'No 5b, Begger',
                'phone_contact' => 234575683108,
                'price' => 3000.03,
                'no_rooms_available' => 15,
                'created_at' => Carbon::now()
            ]
        ];
        foreach ($data as $hotel) {
            // dd($hotel);
            $data = Hotel::where('name', '=', $hotel['name'])->first();
            if (!$data) {
                DB::table('hotels')->insert($hotel);
            }
        }
        DB::table('event_hotels')->insert(['event_id'=> 1, 'hotel_id'=> 1]);
        DB::table('event_hotels')->insert(['event_id'=> 1, 'hotel_id'=> 2]);

    }
}
