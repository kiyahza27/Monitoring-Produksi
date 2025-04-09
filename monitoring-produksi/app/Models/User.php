<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */

    const ROLE_ADMIN = 'Admin';

    const ROLE_PRODUKSI = 'Produksi';

    const ROLE_PEMILIK = 'Pemilik';

    const ROLES=[
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_PRODUKSI => 'Produksi',
        self::ROLE_PEMILIK => 'Pemilik',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isProduksi() || $this->isPemilik();
    }

    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }

    public function isProduksi(){
        return $this->role === self::ROLE_PRODUKSI;
    }

    public function isPemilik(){
        return $this->role === self::ROLE_PEMILIK;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
