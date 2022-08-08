<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = "sections";

    protected $guarded = [];

    public $timestamps = false;

    public function classifications(){
        return $this->hasMany(Classification::class);
    }
}
