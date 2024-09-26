<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    protected $table = 'checklist';
    protected $fillable = [
        'name',
        'inner_code',
        'checkin_time',
        'checkin_operation',
        'checkout_time',
        'checkout_operation',
        'checkin_ip',
        'checkout_ip'
    ];

}
