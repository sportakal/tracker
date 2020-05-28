<?php

namespace sportakal\tracker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class spSession extends Model
{
    protected $table = 'sp_sessions';
    protected $guarded = [];

    public function spCookie()
    {
        return $this->belongsTo(spCookie::class, 'spCookieID');
    }

    public function spVisits()
    {
        return $this->hasMany(spVisit::class, 'spSessionID');
    }

    public static function getData($startDate = 'first day of this month', $endDate = 'now')
    {
        return spSession::where('is_bot', 0)
            ->where('created_at', '>', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime($endDate)));
    }
}
