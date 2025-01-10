<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsciption extends Model
{
    //
    protected $table = 'subscription';
    protected $primaryKey = 'SubsciptionID';
    protected $fillable = [
        'Name',
        'Price',
        'PriceSale',
        'Feature',
    ];

}