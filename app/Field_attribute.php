<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field_attribute extends Model
{
    public function field(){
        return $this->belongsTo('App\Field', 'id');
    }
}
