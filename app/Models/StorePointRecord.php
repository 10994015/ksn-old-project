<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePointRecord extends Model
{
    use HasFactory;
    protected $fillable = ['money', 'store', 'store_type', 'order_number', 'username', 'status', 'proxy_id', 'member_id', 'is_first'];
    protected $table = "store_point_record";
}
