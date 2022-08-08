<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;

    protected $table = "backgrounds";

    protected $guarded = [];

    public $timestamps = false;

    public function classifications(){
        return $this->hasMany(Classification::class);
    }
}
