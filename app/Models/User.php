<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'image',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'otp_code',

    ];
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    public function token(){
        return $this->hasOne(Token::class);
    }

    protected static function booted()
    {
        static::retrieved(function ($user) {
          
            $user->checkAndDeleteExpiredToken();
        });
    }

    public function checkAndDeleteExpiredToken()
    {
        $role = $this->roles; 

        if ($role && $role->role_name !== 'admin') {
            $token = $this->token; 
            
            if ($token && Carbon::now()->greaterThanOrEqualTo($token->expires_at)) {
                $token->delete();
                
            }
        }
    }
    
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

    public function setPasswordAttribute($value){
        return $this->attributes['password'] = Hash::make($value);
    }
}
