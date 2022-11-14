<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $guard_name = 'web';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'surnames',
        'user_name',
        'password',
        'email',
        'active',
        'aws_user_id',
        'aws_auth_token',
    ];
    
    public $timestamps = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'aws_auth_token',
        'remember_token',
    ];
    protected $appends = array('status');

    public function getStatusAttribute()
    {
        return $this->active == 1?"Activo":"Inactivo";  
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function documentsToSign()
    {
        return $this->hasMany(DocumentSigner::class);
    }
}
