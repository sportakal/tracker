<?php

namespace sportakal\tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class spVisit extends Model
{
    protected $table = 'sp_visits';
    protected $guarded = [];


    public function session()
    {
        return $this->belongsTo('sportakal\Tracker\spSession', 'SessionID');
    }
}
