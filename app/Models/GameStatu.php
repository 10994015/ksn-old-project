<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gamenumber', 'statu', 'maintenance'];
    protected $table = "gamestatus";
}
