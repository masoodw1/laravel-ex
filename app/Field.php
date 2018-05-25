<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function fieldCase()
    {
        return $this->belongsTo('Task', 'task_id');
    }

    public function fieldAttribute()
    {
        return $this->hasMany('App\Field_attribute', 'id', 'type');
    }
}
