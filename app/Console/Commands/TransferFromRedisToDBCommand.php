<?php

namespace App\Console\Commands;

use App\Models\BinaryStructure;
use App\Models\StructureBody;
use App\Models\VipStructureBody;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TransferFromRedisToDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:fromRedisToDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer from redis to Database';

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

        $structureBodyVip = VipStructureBody::all();

        foreach ($structureBodyVip as $itemVip) {
            $this->transfer($itemVip->binary_structure_id, $itemVip->number, true);
        }
    }

    public function transfer($binaryStructureId, $number, $isVip)
    {
        $redis = new Redis();
        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;

        $redis_key = $structureName . ':' . $number;

        $tree = $redis::zRange($redis_key, 0, -1, 'WITHSCORES');

        if (!empty($tree)) {
            if ($isVip) {
                $structureBody = VipStructureBody::where(['binary_structure_id' => $binaryStructureId])
                    ->where(['number' => $number])->first();
            } else {
                $structureBody = StructureBody::where(['binary_structure_id' => $binaryStructureId])
                    ->where(['number' => $number])->first();
            }

            $structureBody->tree_representation = json_encode($tree);
            $structureBody->save();
        }
    }
}
