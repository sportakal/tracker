<?php

namespace sportakal\tracker\middlewares;

use Closure;
use Jenssegers\Agent\Agent;
use sportakal\tracker\spSession;
use sportakal\tracker\spVisit;
use sportakal\tracker\Visit;
use Illuminate\Support\Facades\Config;


class Tracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Config::set('cache.default', 'array');

        $agent = new Agent();

        if (auth()->check()) {
            $check_user = true;
        } else {
            $check_user = false;
        }
        if (isset($_COOKIE['visitTime'])) {
            $cookie_value = $_COOKIE['visitTime'];
        } else {
            $cookie_value = strtotime('now');
            setcookie('visitTime', $cookie_value, time() + 365 * 24 * 60 * 60);
        }

        session_start();
        if (isset($_SESSION['this'])) {
            $session_value = $_SESSION['this'];
            $SessionID = spSession::where('session', $session_value)->first()->id;
        } else {
            $session_value = strtotime('now');
            $_SESSION['this'] = $session_value;
        }

        $ip = $request->server('REMOTE_ADDR');
        $method = $request->server('REQUEST_METHOD');
        $is_ajax = $request->ajax();
        $url = $request->server('REQUEST_URI');
        $referer = $request->server('HTTP_REFERER');

        if (!isset($SessionID)) {
            $spSession = new spSession();

            $is_user = $check_user;
            $user_id = auth()->user()->id ?? null;
            $cookie = $cookie_value;
            $session = $session_value;


            $user_agent = $request->server('HTTP_USER_AGENT');
            $is_desktop = $agent->isDesktop();
            $is_mobile = $agent->isPhone();
            $is_bot = $agent->isRobot();
            $bot = $agent->robot();

            $device = $agent->device();
            $os_family = $agent->platform();
            $os = $os_family . ' ' . $agent->version($os_family);
            $browser_family = $agent->browser();
            $browser = $browser_family . ' ' . $agent->version($browser_family);
            $browser_language = $request->server('HTTP_ACCEPT_LANGUAGE');

            //78.190.177.188    176.54.244.197
            $location = geoip($ip);
            $country = $location->country;
            $country_code = $location->iso_code;
            $city = $location->city;
            $state_name = $location->state_name;
            $state = $location->state;
            $lat = $location->lat;
            $lon = $location->lon;


            $spSession->is_user = $is_user;
            $spSession->user_id = $user_id;
            $spSession->cookie = $cookie;
            $spSession->session = $session;

            $spSession->ip = $ip;

            $spSession->url = $url;
            $spSession->referer = $referer;

            $spSession->user_agent = $user_agent;
            $spSession->is_desktop = $is_desktop;
            $spSession->is_mobile = $is_mobile;
            $spSession->is_bot = $is_bot;
            $spSession->bot = $bot;

            $spSession->device = $device;
            $spSession->os_family = $os_family;
            $spSession->os = $os;
            $spSession->browser_family = $browser_family;
            $spSession->browser = $browser;
            $spSession->browser_language = $browser_language;

            $spSession->country = $country;
            $spSession->country_code = $country_code;
            $spSession->city = $city;
            $spSession->state_name = $state_name;
            $spSession->state = $state;
            $spSession->lat = $lat;
            $spSession->lon = $lon;

            $spSession->save();

            $spSession = $spSession->id;
        } else {
            $spSession = $SessionID;
        }

        $visits = new spVisit();

        $visits->SessionID = $spSession;

        $visits->ip = $ip;
        $visits->method = $method;
        $visits->is_ajax = $is_ajax;
        $visits->url = $url;
        $visits->referer = $referer;

        $visits->save();

        return $next($request);
    }
}
