<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionArea extends Model
{
    use HasFactory;

    protected $table = "production_areas";

    protected $guarded = [];

    public $timestamps = false;

    public function classifications(){
        return $this->hasMany(Classification::class);
    }
}
