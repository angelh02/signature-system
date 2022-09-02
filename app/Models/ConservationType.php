<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConservationType extends Model
{
    use HasFactory;

    protected $table = "conservation_types";

    protected $guarded = [];

    public $timestamps = false;

    public function containers(){
        return $this->hasMany(Container::class);
    }
}
