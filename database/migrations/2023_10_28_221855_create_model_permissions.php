<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelPermissions extends Migration
{
    public function up()
    {
        $models = [
            "transaction" => "Transaction",
            "event" => "Event",
            "hotel" => "Hotel",
            "exhibition" => "Exhibition",
            "country" => "Country",
            "abstractmodel" => "AbstractModel",
            "attendance" => "Attendance",
            "exhibitionpurchase" => "ExhibitionPurchase",
            "state" => "State",
            "hotels" => "Hotels",
            "eventuser" => "EventUser",
            "reservations" => "Reservations",
            "setting" => "Setting",
            "messages" => "Messages",
            "eventhotel" => "EventHotel",
            "exhibitiontype" => "ExhibitionType",
            "accommodation" => "Accommodation",
            "user" => "Users",
        ];

        foreach ($models as $model => $modelName) {
            $crudActions = ['create', 'read', 'update', 'delete'];

            foreach ($crudActions as $action) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $action . ' ' . strtolower($model),
                    'guard_name' => 'web',
                ]);
            }
        }
    }

    public function down()
    {
        // Reverse the migration if needed.
    }
}
