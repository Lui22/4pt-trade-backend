<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function generateToken()
    {
        $this->api_token = Str::uuid();
        $this->save();

        return $this->api_token;
    }

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'user_role_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
