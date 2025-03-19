<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    //
    protected $table = 'statustask';
    protected $primaryKey = 'StatustTaskID';
    protected $fillable = [
        'StatusName',
        'ProjectID',
    ];
    public function taskCards()
    {
        return $this->hasMany(TaskCard::class, 'StatustTaskID', 'StatustTaskID');
    }
}