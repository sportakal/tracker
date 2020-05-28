<?php

namespace sportakal\tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class spVisit extends Model
{
    protected $table = 'sp_visits';
    protected $guarded = [];


    public function spSession()
    {
        return $this->belongsTo('sportakal\Tracker\spSession', 'spSessionID');
    }


    public static function getData($startDate = 'first day of this month', $endDate = 'now')
    {
        return spVisit::where('is_bot', 0)
            ->where('is_ajax', 0)
            ->where('created_at', '>', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime($endDate)));
    }
}
