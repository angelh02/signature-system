<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    use HasFactory;

    protected $table = "deletion_request";

    protected $guarded = [];

    public $timestamps = false;

    public function document(){
        return $this->belongsTo(Document::class);
    }
}
