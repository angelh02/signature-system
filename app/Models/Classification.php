<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    protected $table = "classifications";

    protected $guarded = [];

    public $timestamps = false;

    public function background(){
        return $this->belongsTo(Background::class, "background_id");
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function productionArea(){
        return $this->belongsTo(ProductionArea::class, "production_area_id");
    }

    public function section(){
        return $this->belongsTo(Section::class, "section_id");
    }
}
