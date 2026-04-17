<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserActivityLog;
use App\Models\User;

class UserActivityController extends Controller
{
    /**
     * Admin: View user activity logs
     */
    public function adminActivityLogs()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $activities = UserActivityLog::with('user')
            ->orderBy('login_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($activity) {
                return $this->formatActivity($activity);
            });

        return view('admin.user_activity', compact('activities'));
    }

    /**
     * Superadmin: View all user activity logs
     */
    public function superadminActivityLogs()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        $activities = UserActivityLog::with('user')
            ->orderBy('login_at', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($activity) {
                return $this->formatActivity($activity);
            });

        return view('superadmin.user_activity', compact('activities'));
    }

    /**
     * Format activity data for display
     */
    private function formatActivity($activity)
    {
        $lastPassChange = $activity->user?->last_password_change ? $activity->user->last_password_change->format('d/m/Y H:i:s') : '-';
        $passChangeCount = $activity->user?->password_change_count ?? 0;

        return [
            'id' => $activity->id,
            'user_name' => $activity->user?->name ?? $activity->username ?? 'Unknown',
            'pegawai_id' => $activity->user?->pegawai_id ?? 'N/A',
            'ip_address' => $activity->ip_address ?? '-',
            'os' => $activity->os ?? 'Unknown',
            'browser' => $activity->browser ?? 'Unknown',
            'device' => $activity->device_type ?? 'Desktop',
            'login_at' => $activity->login_at ? $activity->login_at->format('d/m/Y H:i:s') : '-',
            'login_date' => $activity->login_at ? $activity->login_at->format('d F Y') : '-',
            'login_time' => $activity->login_at ? $activity->login_at->format('H:i:s') : '-',
            'status' => $activity->status ?? 'logged_in',
            'user_agent' => $activity->user_agent ?? '-',
            'last_password_change' => $lastPassChange,
            'password_change_count' => $passChangeCount,
        ];
    }

    /**
     * Get recent login activity for sidebar widget (Admin)
     */
    public function getRecentActivityAdmin()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return [];
        }

        return UserActivityLog::with('user')
            ->where('status', 'logged_in')
            ->orderBy('login_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return $this->formatActivity($activity);
            });
    }

    /**
     * Get recent login activity for sidebar widget (Superadmin)
     */
    public function getRecentActivitySuperadmin()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return [];
        }

        return UserActivityLog::with('user')
            ->where('status', 'logged_in')
            ->orderBy('login_at', 'desc')
            ->limit(15)
            ->get()
            ->map(function ($activity) {
                return $this->formatActivity($activity);
            });
    }
}
