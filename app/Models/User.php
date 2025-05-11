<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Attempt;
use App\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

 
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany {
    
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role) {
    
        return $this->roles()->where('name', $role)->exists();
    }

    public function attempts() {
        return $this->hasMany(Attempt::class);
    }

    public function scores(){
        return $this->hasMany(Score::class);
    }
    // public function getAvatarUrlAttribute()
    // {
    //     // Example if avatar path is stored in DB
    //     return $this->avatar 
    //         ? asset('storage/avatars/' . $this->avatar) 
    //         : asset('images/default-avatar.png');
    // }
}
