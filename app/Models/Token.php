<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable =[
        'user_id',
        'token_value',
        'expires_at'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getStatusAttribute()
    {
        return Carbon::now()->greaterThan($this->expires_at) ? 'Expired' : 'Active';
    }

    use HasFactory;
}
