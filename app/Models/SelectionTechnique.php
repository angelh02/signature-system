<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectionTechnique extends Model
{
    use HasFactory;

    protected $table = "selection_techniques";

    protected $guarded = [];

    public $timestamps = false;

    public function containers(){
        return $this->hasMany(Container::class);
    }
}
