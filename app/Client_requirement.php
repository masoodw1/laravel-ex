<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Client_requirement extends Model
{
 
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function fieldAttribute()
    {
        return $this->belongsToMany('App\Field_attribute', 'client_requirements', 'client_id', 'fieldattr_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'managed_by');
        
    }

}
