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

    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'EmployeeID', 'EmployeeID');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members', 'EmployeeID', 'ProjectID')
                    ->withPivot('Role', 'created_at');
    }
}