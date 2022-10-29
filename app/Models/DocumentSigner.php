<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSigner extends Model
{
    use HasFactory;

    protected $table = "document_signer";

    protected $guarded = [];

    public $timestamps = false;

    public function document(){
        return $this->belongsTo(Document::class, "document_id");
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
