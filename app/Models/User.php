<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Booking;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'reset_token_password'
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    public function getAvatarAttribute()
    {
        // if name contains space, replace it with '+'
        $name = str_replace(' ', '%20', $this->name);

        return $this->avatar ?? "https://ui-avatars.com/api/?name={$name}";
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    // public function firebase_tokens()
    // {
    //     return $this->hasMany(FirebaseToken::class, 'user_id', 'id');
    // }

    // public function updateUserDevice()
    // {
    //     if (request()->device_id) {

    //         $this->firebase_tokens()->where('device_id', request()->device_id)->delete();

    //         // Store the new token
    //         $this->firebase_tokens()->create([
    //             'device_id' => request()->device_id,
    //             'token_firebase' => request()->token_firebase,
    //         ]);
    //     }
    // }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }
}
