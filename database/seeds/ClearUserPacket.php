<?php

use Illuminate\Database\Seeder;

class ClearUserPacket extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userPaket = \App\Models\UserPacket::whereNotIn('packet_id', [1,2,3,4,5])->get();
        foreach ($userPaket as $item){
            $item->delete();
        }
    }
}
