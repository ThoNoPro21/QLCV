<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employees';
    protected $primaryKey = 'EmployeeID';
    protected $fillable = [
        'Address',
        'Dateofbirth',
        'Role',
        'SubsciptionID',
        'userId',
    ];
}