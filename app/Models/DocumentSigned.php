<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSigned extends Model
{
    use HasFactory;

    protected $table = "document_signed";

    protected $guarded = [];

    public $timestamps = false;

    public function document(){
        return $this->belongsTo(Document::class, "document_id");
    }
}
