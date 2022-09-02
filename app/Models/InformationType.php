<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationType extends Model
{
    use HasFactory;

    protected $table = "information_types";

    protected $guarded = [];

    public $timestamps = false;

    public function containers(){
        return $this->hasMany(Container::class);
    }
}
