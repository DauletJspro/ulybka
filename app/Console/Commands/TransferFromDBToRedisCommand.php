<?php

namespace App\Console\Commands;

use App\Models\BinaryStructure;
use App\Models\StructureBody;
use App\Models\VipStructureBody;
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
    protected $description = 'Transfer from db to Redis';

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

        $structureBody = StructureBody::all();

        foreach ($structureBody as $item) {
            $this->transfer($item->binary_structure_id, $item->number, false);
        }

        $structureBody = VipStructureBody::all();

        foreach ($structureBody as $item) {
            $this->transfer($item->binary_structure_id, $item->number, true);
        }
    }

    public function transfer($binaryStructureId, $number, $isVip)
    {
        $redis = new Redis();
        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;
        $redis_key = $structureName . ':' . $number;

        if ($isVip) {
            $structureBody = VipStructureBody::where(['binary_structure_id' => $binaryStructureId])
                ->where(['number' => $number])->first();
        } else {
            $structureBody = StructureBody::where(['binary_structure_id' => $binaryStructureId])
                ->where(['number' => $number])->first();
        }


        $tree = (array)json_decode($structureBody->tree_representation);

        foreach ($tree as $key => $item) {
            if ($item != 0) {
                $redis::zAdd(($redis_key), (int)$item, $key);
            }
        }
    }
}
