<?php
//
//namespace sportakal\tracker;
//
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//
//
//class Visit extends Model
//{
//    protected $table = 'visits';
//    protected $guarded = [];
//
//    public function user()
//    {
//        return $this->belongsTo('App\User', 'user_id');
//    }
//
//    public function getgetNameAttribute()
//    {
//        if ($this->is_user) {
//            return $this->user->name;
//        } else {
//            return 'visitor - ' . substr($this->cookie, 3);
//        }
//    }
//
//    protected static function allVisits()
//    {
//        return Visit::where('is_bot', 0)->orderBy('id', 'DESC');
//    }
//
//    protected static function allVisitsGet()
//    {
//        return self::allVisits()->get();
//    }
//
//    public static function visits($date = 00000)
//    {
//        $visits = self::allVisitsGet()->where('created_at', '>', date('Y-m-d', strtotime($date)));
//        return $visits->groupBy('session');
//    }
//
//    public static function visitors($date = 00000)
//    {
//        $visits = self::allVisitsGet()->where('created_at', '>', date('Y-m-d', strtotime($date)));
//        return $visits->groupBy('cookie');
//    }
//
//    public static function stats($date = 00000, $stat = 'session')
//    {
//        $visits = self::allVisitsGet()->where('created_at', '>', date('Y-m-d', strtotime($date)));
//        return $visits->groupBy($stat);
//    }
//
//
//    public static function mostStats($date = 00000, $stat = 'city')
//    {
//        $mosts = self::allVisits()->where('created_at', '>', date('Y-m-d', strtotime($date)))
//            ->select($stat, DB::raw('count(' . $stat . ') as count'));
//        return $mosts->groupBy($stat)->orderBy('count', 'DESC')->get();
//    }
//
//
//    public function visitorPage()
//    {
//        $sess = $this->session;
//
//        return self::allVisits()->where('session', $sess);
//    }
//
//    public function visitorVisit()
//    {
//        $cook = $this->cookie;
//
//        return self::allVisitsGet()->where('cookie', $cook)->groupBy('session');
//    }
//
//    public function visitorStat($date = 00000, $stat = 'city', $value = 'Denizli')
//    {
//        $visits = self::allVisitsGet()->where('created_at', '>', date('Y-m-d', strtotime($date)));
//
//        return $visits->where($stat, $value);
//    }
//}
