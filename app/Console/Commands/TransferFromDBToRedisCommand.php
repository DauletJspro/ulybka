<?php

namespace App\Console\Commands;

use App\Models\BinaryStructure;
use App\Models\StructureBody;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TransferFromDBToRedisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:fromDbToRedis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->transfer(1, 1);
        $this->transfer(1, 2);
        $this->transfer(2, 1);
        $this->transfer(2, 2);
        $this->transfer(3, 1);
        $this->transfer(3, 2);
        $this->transfer(4, 1);
        $this->transfer(5, 1);
    }

    public function transfer($binaryStructureId, $number)
    {
        $redis = new Redis();
        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;
        $redis_key = $structureName . ':' . $number;

        $first_structure_first_number = StructureBody::where(['binary_structure_id' =>$binaryStructureId])
            ->where(['number' => $number])->first();

        $tree = json_decode($first_structure_first_number->tree_representation);

        foreach ($tree as $key => $item) {
            if ($item != 0) {
                $redis::zAdd(($redis_key), $item, $key);
            }
        }
    }
}
