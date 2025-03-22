<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCardDetail extends Model
{
    //
    protected $table = 'taskcarddetail';
    protected $primaryKey = 'TaskCardDetailID';
    protected $fillable = [
        'Description',
        'File',
        'TaskCardID',
        'EmployeeID'
    ];
    public function taskCard()
    {
        return $this->belongsTo(TaskCard::class, 'TaskCardID', 'TaskCardID');
    }
}
