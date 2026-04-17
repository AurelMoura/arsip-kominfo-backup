<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class UserActivityHelper
{
    /**
     * Capture user activity information
     */
    public static function captureActivity(Request $request)
    {
        $agent = new Agent();
        
        return [
            'ip_address' => self::getClientIp($request),
            'user_agent' => $request->header('User-Agent'),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'device' => $agent->device() ?? 'Desktop',
            'device_type' => self::getDeviceType($agent),
            'location' => self::getLocationFromIp(self::getClientIp($request)),
        ];
    }

    /**
     * Get client IP address
     */
    public static function getClientIp(Request $request)
    {
        if ($request->header('CF-Connecting-IP')) {
            return $request->header('CF-Connecting-IP');
        }
        
        if ($request->header('X-Forwarded-For')) {
            $ips = explode(',', $request->header('X-Forwarded-For'));
            return trim($ips[0]);
        }

        return $request->ip() ?? 'Unknown';
    }

    /**
     * Get device type from agent
     */
    public static function getDeviceType($agent)
    {
        if ($agent->isMobile()) {
            return 'Mobile';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        }
        
        return 'Desktop';
    }

    /**
     * Get location from IP address (simple version)
     * For production, use a proper IP geolocation service
     */
    public static function getLocationFromIp($ip)
    {
        // Simple approach - you can integrate with an IP geolocation service
        if ($ip === '127.0.0.1' || $ip === 'localhost') {
            return 'Localhost';
        }

        // Placeholder - in production, use a service like ip-api.com, maxmind, etc.
        // Example:
        // $response = Http::get("https://ipapi.co/{$ip}/json/");
        // return $response->json()['city'] ?? 'Unknown';
        
        return 'Indonesia'; // Placeholder
    }

    /**
     * Format activity data for display
     */
    public static function formatActivityData($activity)
    {
        return [
            'browser' => $activity['browser'] ?? 'Unknown',
            'os' => $activity['os'] ?? 'Unknown',
            'device' => $activity['device_type'] ?? 'Unknown',
            'ip_address' => $activity['ip_address'] ?? 'Unknown',
            'location' => $activity['location'] ?? 'Indonesia',
            'formatted' => ($activity['browser'] ?? 'Unknown') . ' / ' . 
                          ($activity['os'] ?? 'Unknown') . ' / ' . 
                          ($activity['device_type'] ?? 'Desktop')
        ];
    }
}
