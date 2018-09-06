<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Redis;


class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function fetchData($id){
        
    }
}
