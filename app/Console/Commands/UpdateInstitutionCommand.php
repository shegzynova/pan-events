<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateInstitutionCommand extends Command
{
    protected $signature = 'update:institution';

    protected $description = 'Update institution in events_users table based on attendances table';

    public function handle()
    {
        // Fetch data from the attendances table
        $attendances = DB::table('attendances')->get();

        // Loop through each attendance record
        foreach ($attendances as $attendance) {
            // Update the institution in the events_users table based on user_id
            DB::table('events_users')
                ->where('user_id', $attendance->user_id)
                ->update(['institution' => $attendance->institution]);
        }

        $this->info('Institution updated successfully!');
    }
}
