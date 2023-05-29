<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['name', 'qty', 'amount', 'total', 'tax', 'net_amount', 'img_name', 'created_at'];

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key column name

    protected $table = 'invoices'; // Assuming 'invoices' is the table name
    protected $casts = [
        'created_at' => 'datetime',
    ];
    public $timestamps = false; 
        use HasFactory;
}
