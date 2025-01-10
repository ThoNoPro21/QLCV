<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';
    protected $primaryKey = 'ProjectID';
    protected $fillable = [
        'ProjectName',
        'Background',
        'Status',
        'Role',
        'EmployeeID',
    ];

    protected $attributes = [
        'Status' => '0',
        'Background' =>'none'
    ];
}