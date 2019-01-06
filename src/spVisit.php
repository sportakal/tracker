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


    public static function getHumanVisitsByDate($startDate = 'first day of this month', $endDate = 'now')
    {
        return self::orderBy('created_at', 'DESC')
            ->where('created_at', '>', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime($endDate)))
            ->where('is_bot', 0);
    }


    public static function urlVisits($startDate = 0, $endDate = 'now')
    {
        return spVisit::getHumanVisitsByDate($startDate, $endDate)->get()->groupBy('url');
    }

    public function notAjax()
    {
        return 'asdas';
    }

}
