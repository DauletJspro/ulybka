<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructureBody extends Model
{
    protected $table = 'structure_body';
    protected $fillable = ['binary_structure_id', 'number', 'tree_representation'];
}
