<?php

namespace sportakal\tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class spSession extends Model
{
    protected $table = 'sp_sessions';
    protected $guarded = [];

    public function getgetNameAttribute()
    {
        if ($this->is_user) {
            return $this->user->name;
        } else {
            return 'visitor - ' . substr($this->cookie, 3);
        }
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function spVisits()
    {
        return $this->hasMany(spVisit::class, 'SessionID');
    }

    public function visit()
    {
        return $this->hasMany(spVisit::class, 'SessionID')->where('is_ajax', 0);
    }


    protected static function getHumanVisitsByDate($startDate = 'first day of this month', $endDate = 'now')
    {
        return self::orderBy('created_at', 'DESC')
            ->where('created_at', '>', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime($endDate)))
            ->where('is_bot', 0);
    }


    public static function visits($startDate = 0, $endDate = 'now')
    {
        return self::getHumanVisitsByDate($startDate, $endDate)->get();
    }

    public static function visitors($startDate = 0, $endDate = 'now')
    {
        return self::getHumanVisitsByDate($startDate, $endDate)->get()->groupBy('cookie');
    }


    public static function stats($startDate = 0, $stat = 'city', $endDate = 'now')
    {
        return self::getHumanVisitsByDate($startDate, $endDate)->get()->groupBy($stat);
    }


    public static function urlVisits($startDate = 0, $endDate = 'now')
    {
        return spVisit::getHumanVisitsByDate($startDate, $endDate)->get()->groupBy('url');
    }


    public function pageVisits()
    {
        return $this->hasMany(spVisit::class, 'SessionID')->where('is_ajax', 0);
    }

    public function ajaxVisits()
    {
        return $this->hasMany(spVisit::class, 'SessionID')->where('is_ajax', 1);
    }


}
