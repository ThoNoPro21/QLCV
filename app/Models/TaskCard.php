<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCard extends Model
{
    //
    protected $table = 'taskcard';
    protected $primaryKey = 'TaskCardID';
    protected $fillable = [
        'TaskCardName',
        'StatustTaskID',
        'EmployeeID'
    ];
    public function statusTask()
    {
        return $this->belongsTo(StatusTask::class, 'StatustTaskID', 'StatusTaskID');
    }
}