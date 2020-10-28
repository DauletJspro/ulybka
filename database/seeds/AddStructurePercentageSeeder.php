<?php

use Illuminate\Database\Seeder;

class AddStructurePercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Packet::where(['packet_id' => 1])
            ->update([
                'to_binary_structure' => 41.66,
                'to_classical_structure' => 58.33
            ]);

        \App\Models\Packet::where(['packet_id' => 2])
            ->update([
                'to_binary_structure' => 16.66,
                'to_classical_structure' => 83.33
            ]);

        \App\Models\Packet::where(['packet_id' => 3])
            ->update([
                'to_binary_structure' => 5.26,
                'to_classical_structure' => 94.73
            ]);

        \App\Models\Packet::where(['packet_id' => 4])
            ->update([
                'to_binary_structure' => 1.47,
                'to_classical_structure' => 98.53
            ]);
        \App\Models\Packet::where(['packet_id' => 5])
            ->update([
                'to_binary_structure' => 0.60,
                'to_classical_structure' => 99.39
            ]);

        \App\Models\Packet::where(['packet_id' => 6])
            ->update([
                'to_binary_structure' => 0.21,
                'to_classical_structure' => 99.79
            ]);

        \App\Models\Packet::where(['packet_id' => 7])
            ->update([
                'to_binary_structure' => 0.08,
                'to_classical_structure' => 99.96
            ]);

    }
}
