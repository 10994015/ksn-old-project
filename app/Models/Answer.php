<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = "answer";
    protected $fillable = ['number', 'ranking', 'overt', 'date_number', 'bet_time'];
}
