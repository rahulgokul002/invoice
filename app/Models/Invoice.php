<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    protected $fillable = ['amount','total','tax','net_amount','img_name','name'];
    use HasFactory;
}
