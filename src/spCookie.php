<?php

namespace sportakal\tracker;

use App\User;
use Illuminate\Database\Eloquent\Model;

class spCookie extends Model
{
    protected $table = 'sp_cookies';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spSessions()
    {
        return $this->hasMany(spSession::class, 'spCookieID');
    }

    public function spVisits()
    {
        return $this->hasManyThrough(spVisit::class, spSession::class, 'spCookieID', 'spSessionID');
    }

    public function getgetNameAttribute()
    {
        if (strlen($this->name) > 0) {
            return $this->name;
        } else {
            if ($this->is_user) {
                return $this->user->name;
            } else {
                return 'visitor - ' . $this->id;
            }
        }
    }


    public static function getData($startDate = 'first day of this month', $endDate = 'now')
    {
        return spCookie::where('is_bot', 0)
            ->where('created_at', '>', date('Y-m-d 00:00:00', strtotime($startDate)))
            ->where('created_at', '<', date('Y-m-d 23:59:59', strtotime($endDate)));
    }
}
