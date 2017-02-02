<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];

    public function note(){
        return $this->hasMany(ProjectNote::class);
    }

    public function task(){
        return $this->hasMany(ProjectTask::class);
    }

    public function member(){
        return $this->belongsToMany(User::class,'project_members');
    }

    public function owner()
    {
        return $this->belongsTo('CodeProject\Entities\User', 'owner_id');
    }

    public function client()
    {
        return $this->belongsTo('CodeProject\Entities\Client', 'client_id');
    }

    public function files(){
        return $this->hasMany(ProjectFile::class);
    }


}
