<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentValue extends Model
{
    use HasFactory;

    protected $table = "document_values";

    protected $guarded = [];

    public $timestamps = false;

    public function containers(){
        return $this->hasMany(Container::class);
    }
}
