<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = "documents";

    protected $guarded = [];

    public $timestamps = false;

    public function classification(){
        return $this->belongsTo(Classification::class, "classification_id");
    }

    public function container(){
        return $this->belongsTo(Container::class, "container_id");
    }

    public function documentType(){
        return $this->belongsTo(DocumentType::class, "document_type_id");
    }

    public function documentSigned(){
        return $this->hasOne(DocumentSigned::class);
    }

    public function documentSigners(){
        return $this->hasMany(DocumentSigner::class);
    }

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}
