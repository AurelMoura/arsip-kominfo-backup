<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserActivityLog;
use App\Models\User;

class UserActivityController extends Controller
{
    /**
     * Admin: View user activity logs (page only, no data preload)
     */
    public function adminActivityLogs()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        return view('admin.user_activity');
    }

    /**
     * Superadmin: View all user activity logs (page only, no data preload)
     */
    public function superadminActivityLogs()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        return view('superadmin.user_activity');
    }

    /**
     * AJAX: Server-side paginated data for admin
     */
    public function adminActivityData(Request $request)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->getActivityData($request);
    }

    /**
     * AJAX: Server-side paginated data for superadmin
     */
    public function superadminActivityData(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->getActivityData($request);
    }

    /**
     * AJAX: Stats for admin
     */
    public function adminActivityStats()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->getActivityStats();
    }

    /**
     * AJAX: Stats for superadmin
     */
    public function superadminActivityStats()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->getActivityStats();
    }

    /**
     * Core: Get paginated activity data with search
     */
    private function getActivityData(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);
        $search  = $request->input('search', '');

        // Clamp per_page
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $query = UserActivityLog::with('user')
            ->orderBy('login_at', 'desc');

        // Apply search filter at DB level
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('pegawai_id', 'like', "%{$search}%");
                })
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('browser', 'like', "%{$search}%")
                ->orWhere('os', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Get total before pagination (for "filtered from X")
        $totalAll = UserActivityLog::count();
        $totalFiltered = $query->count();

        // Paginate
        $activities = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(function ($activity) {
                return $this->formatActivity($activity);
            });

        return response()->json([
            'data'           => $activities,
            'total'          => $totalFiltered,
            'total_all'      => $totalAll,
            'page'           => $page,
            'per_page'       => $perPage,
            'total_pages'    => max(1, (int) ceil($totalFiltered / $perPage)),
        ]);
    }

    /**
     * Core: Get aggregate stats (lightweight queries)
     */
    private function getActivityStats()
    {
        $totalLogin     = UserActivityLog::count();
        $uniqueUsers    = UserActivityLog::distinct('user_id')->count('user_id');
        $uniqueIps      = UserActivityLog::distinct('ip_address')->count('ip_address');

        return response()->json([
            'total_login'   => $totalLogin,
            'unique_users'  => $uniqueUsers,
            'unique_ips'    => $uniqueIps,
        ]);
    }

    /**
     * Format activity data for display
     */
    private function formatActivity($activity)
    {
        $lastPassChange = $activity->user?->last_password_change ? $activity->user->last_password_change->format('d/m/Y H:i:s') : '-';
        $passChangeCount = $activity->user?->password_change_count ?? 0;

        $browser = $activity->browser;
        if (!$browser && $activity->ip_address) {
            $browser = UserActivityLog::where('ip_address', $activity->ip_address)
                ->whereNotNull('browser')
                ->orderByDesc('login_at')
                ->value('browser');
        }

        return [
            'id' => $activity->id,
            'user_name' => $activity->user?->name ?? $activity->username ?? 'Unknown',
            'pegawai_id' => $activity->user?->pegawai_id ?? 'N/A',
            'ip_address' => $activity->ip_address ?? '-',
            'os' => $activity->os ?? 'Unknown',
            'browser' => $browser ?? 'Unknown',
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
