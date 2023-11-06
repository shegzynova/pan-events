<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = json_decode(file_get_contents(base_path('countries.json')));

        $countryData = Country::count();
        if($countryData >= 250){
            Country::where("id", ">=", 250)->delete();
        }

        foreach ($countries as $country) {
            $countryData = Country::whereName($country)->first();
            if (!$countryData) {
                $data = [
                    'name' => $country,
                    'created_at' => Carbon::now()
                ];

                DB::table('countries')->insert($data);
            }
        }


        $states = json_decode(file_get_contents(base_path('nigeria-states.json')));

        $stateData = State::count();
        if($stateData >= 38){
            State::where("id", ">=", 38)->delete();
        }

        foreach ($states as $state) {
            $stateData = State::whereName($state)->first();
            if (!$stateData) {
                $data = [
                    'name' => $state,
                    'created_at' => Carbon::now()
                ];

                DB::table('states')->insert($data);
            }
        }
    }
}
