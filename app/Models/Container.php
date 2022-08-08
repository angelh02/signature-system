<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $table = "containers";

    protected $guarded = [];

    public $timestamps = false;

    public function conservationTime(){
        return $this->belongsTo(ConservationTime::class, "conservatio_time_id");
    }

    public function conservationType(){
        return $this->belongsTo(ConservationType::class, "conservation_type_id");
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function documentValue(){
        return $this->belongsTo(DocumentValue::class, "document_value_id");
    }

    public function informationType(){
        return $this->belongsTo(InformationType::class, "information_type_id");
    }

    public function selectionTechnique(){
        return $this->belongsTo(SelectionTechnique::class, "selection_technique_id");
    }
}
