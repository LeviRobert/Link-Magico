<?php

namespace App\Models;

use App\Mail\MagicLoginLink;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $connection   = 'mysql';
    protected $table        = 'users';

    protected $fillable = [
        'name',
        'email'
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
    ];

    public function sendLoginLink () {
        $plaintext = Str::random(32);
        $token = $this->loginTokens()->create([
          'token' => hash('sha256', $plaintext),
          'expires_at' => now()->addMinutes(15),
        ]);
        Mail::to($this->email)->queue(new MagicLoginLink($plaintext, $token->expires_at));
    }

    public function loginTokens()
    {
        return $this->hasMany(LoginToken::class);
    }
}
