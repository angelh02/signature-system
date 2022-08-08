<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConservationTime extends Model
{
    use HasFactory;

    protected $table = "conservation_times";

    protected $guarded = [];

    public $timestamps = false;

    public function containers(){
        return $this->hasMany(Container::class);
    }
}
