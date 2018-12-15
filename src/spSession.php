<?php

namespace sportakal\tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class spSession extends Model
{
    protected $table = 'sp_sessions';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function visits()
    {
        return $this->hasMany('sportakal\Tracker\spVisit', 'SessionID');
    }
}
