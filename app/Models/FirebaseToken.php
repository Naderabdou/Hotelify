<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirebaseToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'token_firebase',
        'device_id',
        'user_id',
    ];

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
