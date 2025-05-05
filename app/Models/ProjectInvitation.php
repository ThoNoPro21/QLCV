<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'ProjectID',
        'email',
        'token',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }
}