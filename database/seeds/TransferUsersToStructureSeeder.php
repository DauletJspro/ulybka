<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferUsersToStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')
            ->join('user_packet', 'users.user_id', '=', 'user_packet.user_id')
            ->whereNotIn('users.user_id', [1, 3, 4, 5, 6, 1000, 1001, 1002])
            ->where('users.status_id', true)
            ->where('user_packet.is_active', true)
            ->orderBy('users.created_at', 'ASC')
            ->get();
        foreach ($users as $user) {
            try {
                app(\App\Http\Controllers\Admin\BinaryStructureController::class)
                    ->to_next_structure($user->user_id, $user->packet_id);
            } catch (Exception $exception) {
                var_dump($exception->getMessage() .' file ' .$exception->getFile() .  ' line ' . $exception->getLine() );
            }

        }

    }
}
