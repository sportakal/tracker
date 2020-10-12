<?php

namespace sportakal\tracker\middlewares;

use App\Helper\General;
use Closure;
use Jenssegers\Agent\Agent;
use sportakal\tracker\spCookie;
use sportakal\tracker\spSession;
use sportakal\tracker\spVisit;
use sportakal\tracker\Visit;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;


class Tracker
{
    public $deneme = 0;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $microTimeFirst = microtime(true);
        $agent = new Agent();

        $microTime = microtime(true) - $microTimeFirst;
        config()->set('speed.Agent', $microTime);

        $user_agent = $request->server('HTTP_USER_AGENT');
        $is_desktop = $agent->isDesktop();
        $is_mobile = $agent->isPhone();
        $is_bot = $agent->isRobot();


        if (request()->getHost() == 'simpliers.com.tr') {
            return redirect('https://simpliers.com/cekilis', 301);
        }

        if (!$is_bot) {
//            Config::set('cache.default', 'array');

            if (auth()->check()) {
                $check_user = true;
            } else {
                $check_user = false;
            }

            $cookie_value = $_COOKIE['spCookie'] ?? null;
//            $spCookie = spCookie::find($cookie_value);
            $spCookie = true;

            if (!isset($_COOKIE['spCookie']) || !$spCookie) {
                $bot = $agent->robot();

                $device = $agent->device();
                $os_family = $agent->platform();
                $os = $os_family . ' ' . $agent->version($os_family);
                $browser_family = $agent->browser();
                $browser = $browser_family . ' ' . $agent->version($browser_family);
                $browser_language = $request->server('HTTP_ACCEPT_LANGUAGE');

                $spCookie = new spCookie();
                $spCookie->is_user = $check_user;
                $spCookie->user_id = auth()->user()->id ?? null;
                $spCookie->user_agent = $user_agent;
                $spCookie->is_desktop = $is_desktop;
                $spCookie->is_mobile = $is_mobile;
                $spCookie->is_bot = $is_bot;
                $spCookie->bot = $bot;
                $spCookie->device = $device;
                $spCookie->os_family = $os_family;
                $spCookie->os = $os;
                $spCookie->browser_family = $browser_family;
                $spCookie->browser = $browser;
                $spCookie->browser_language = $browser_language;
                $spCookie->save();

                setcookie('spCookie', $spCookie->id, time() + 60 * 24 * 365, '/');
                $cookie_value = $spCookie->id;
            };

            if (!session_id()) {
                session_start();
            }
            $ip = $request->server('REMOTE_ADDR');
            if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            }
            $session_value = $_SESSION['spSession'] ?? null;

            $microTime = microtime(true) - $microTimeFirst;
            config()->set('speed.beforeSession', $microTime);

            $spSession = spSession::find($session_value);

            $microTime = microtime(true) - $microTimeFirst;
            config()->set('speed.afterSession', $microTime);

//            $spSession = true;
            if (!isset($_SESSION['spSession']) || !$spSession) {
                $microTime = microtime(true) - $microTimeFirst;
                config()->set('speed.beforeGeoIP', $microTime);

//                $ip = '78.190.181.125';
                ////////////////////////////////////
                $location = self::geoIP($ip);
                ////////////////////////////////////
//                $location = geoip($ip);

                $microTime = microtime(true) - $microTimeFirst;
                config()->set('speed.afterGeoIP', $microTime);

                $country = $location->country_name;
                $country_code = $location->country_code2;
                $city = $location->city;
                $state_name = $location->district;
                $state = $location->state ?? null;
                $lat = $location->latitude;
                $lon = $location->longitude;
                $continent_code = $location->continent_code;
                $currency_code = $location->currency->code ?? null;

                $spSession = new spSession();
                $spSession->spCookieID = $cookie_value;
                $spSession->referer = $request->server('HTTP_REFERER');
                $spSession->ip = $ip;

                $spSession->country = $country;
                $spSession->country_code = $country_code;
                $spSession->is_bot = null;
                $spSession->city = $city;
                $spSession->state_name = $state_name;
                $spSession->state = $state;
                $spSession->lat = $lat;
                $spSession->lon = $lon;
                $spSession->continent_code = $continent_code;
                $spSession->currency_code = $currency_code;
                $spSession->gmt_offset = $location->time_zone->offset ?? 0;
                $spSession->calling_code = $location->calling_code ?? null;

//                $url_components = parse_url($request->fullUrl());
//                if (isset($url_components['query'])) {
//                    parse_str($url_components['query'], $params);
//                    $spSession->track_ad = $params['gclid'] ?? null;
//                }

                $microTime = microtime(true) - $microTimeFirst;
                config()->set('speed.beforeSessionSave', $microTime);
                $spSession->save();
                $microTime = microtime(true) - $microTimeFirst;
                config()->set('speed.afterSessionSave', $microTime);

                $_SESSION["spSession"] = $spSession->id;
                $session_value = $spSession->id;
            }


            $method = $request->server('REQUEST_METHOD');
            $is_ajax = $request->ajax();
            $fullUrl = $request->fullUrl();
            $urlPath = explode('?', $request->server('REQUEST_URI'));
            $url = $urlPath[0];
            $referer = $request->server('HTTP_REFERER');


            $spVisit = new spVisit();
            $spVisit->spSessionID = $session_value;
            $spVisit->is_loggedin = $check_user;
            $spVisit->is_bot = 0;
            $spVisit->method = $method;
            $spVisit->is_ajax = $is_ajax;
            $spVisit->url = $url;
            $spVisit->full_url = $fullUrl;
            $spVisit->referer = $referer;
            $spVisit->locale = app()->getLocale();
            $spVisit->save();
            $spCookie = $cookie_value;
            $_COOKIE['spCookie'] = $cookie_value;

//            if ($spCookie) {
//                $spCookie->touch();
//                $spCookie->save();
//            }
        }

        Config::set('credentials.is_mobile', ($is_mobile ?? false));
        Config::set('credentials.country_code', ($spSession->country_code ?? 'US'));
        Config::set('credentials.currency_code', ($spSession->currency_code ?? 'USD'));
        Config::set('credentials.calling_code', ($spSession->calling_code ?? '+1'));
        Config::set('credentials.gmt_offset', ($spSession->gmt_offset ?? '0'));


        return $next($request);
    }

    public function geoIP($ip)
    {
        $url = 'https://de-api.ipgeolocation.io/ipgeo?apiKey=4f9507f54b144fe6b60c04bd803b0598&ip=' . $ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //connection timeout in seconds


        $page = curl_exec($ch);
        $location = (object)[
            'ip' => '127.0.0.0',
            'country_code2' => 'US',
            'country_name' => 'United States',
            'city' => 'New Haven',
            'state' => 'CT',
            'district' => 'Connecticut',
            'postal_code' => '06510',
            'latitude' => 41.31,
            'longitude' => -72.92,
            'timezone' => (object)[
                "name" => "America/New_York",
                "offset" => 3,
                "is_dst" => false,
                "dst_savings" => 0,
                'offset' => 0,
            ],
            'continent_code' => 'NA',
            'currency' => (object)[
                'code' => 'USD',
                'symbol' => '$',
            ],
            'default' => true,
            'cached' => false,
        ];


        if (!curl_errno($ch)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 200) {
                $location = json_decode($page);
            } else {
                $this->deneme++;
                if ($this->deneme < 3) {
                    self::geoIP($ip);
                }
            }
        }

        return $location;
//                dd($location);
    }
}
