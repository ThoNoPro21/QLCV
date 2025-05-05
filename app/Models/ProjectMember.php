<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'ProjectID',
        'EmployeeID',
        'role',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID');
    }
}