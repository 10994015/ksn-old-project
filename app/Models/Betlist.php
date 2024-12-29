<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betlist extends Model
{
    use HasFactory;
    protected $table = 'betlist';
    protected $fillable = [
        'bet_number',
        'money',
        'result',
        'user_id',
        'chips',
        'bet_info',
        'topline',
        'game_type',
        'bet_time',
        'bet_arr'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User'::class);
    }
}
