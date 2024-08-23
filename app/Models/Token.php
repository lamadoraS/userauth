<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['user_id', 'token_value', 'expiration'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    use HasFactory;
}
