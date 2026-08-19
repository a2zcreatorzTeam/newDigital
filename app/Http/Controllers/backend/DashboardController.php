<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\MainClass;
use App\Models\SubClass;
use App\Models\User;
use App\Models\UserPolicyData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $tz = 'Asia/Karachi';
        $now = Carbon::now($tz);
        $monthStart = $now->copy()->startOfMonth();

        $total_policies = MainClass::count();
        $active_policies = MainClass::where('status', 1)->count();
        $total_products = SubClass::count();
        $total_user_policies = UserPolicyData::count();
        $total_customers = User::where('user_type', 1)->count();

        $statusCounts = UserPolicyData::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $approved = (int) ($statusCounts['Approved'] ?? 0);
        $pending = (int) ($statusCounts['Pending'] ?? 0);
        $rejected = (int) ($statusCounts['Rejected'] ?? 0);
        $inCart = (int) ($statusCounts['InCart'] ?? 0);
        $submittedThisMonth = UserPolicyData::where('created_at', '>=', $monthStart)->count();
        $totalPremium = (float) UserPolicyData::sum('premium_paid');

        $monthKeys = [];
        $monthLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = $now->copy()->subMonths($i)->startOfMonth();
            $monthKeys[] = $d->format('Y-m');
            $monthLabels[] = $d->format('M Y');
        }

        $monthlyRaw = UserPolicyData::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $monthlyCounts = array_map(fn ($key) => (int) ($monthlyRaw[$key] ?? 0), $monthKeys);

        $planRows = UserPolicyData::query()
            ->select('plan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('plan')
            ->groupBy('plan')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $planNames = SubClass::whereIn('id', $planRows->pluck('plan')->filter())->pluck('name', 'id');
        $planLabels = $planRows->map(function ($row) use ($planNames) {
            return $planNames[$row->plan] ?? ('Plan #' . $row->plan);
        })->values();
        $planCounts = $planRows->pluck('total')->map(fn ($n) => (int) $n)->values();

        $recentPolicies = UserPolicyData::with(['user:id,name,email', 'policyPlan:id,name'])
            ->latest('id')
            ->limit(8)
            ->get(['id', 'policy_id', 'user_id', 'plan', 'status', 'premium_paid', 'created_at']);

        $statusChartLabels = ['Approved', 'Pending', 'Rejected', 'InCart'];
        $statusChartCounts = [$approved, $pending, $rejected, $inCart];

        return view('home', [
            'total_policies' => $total_policies,
            'active_policies' => $active_policies,
            'total_products' => $total_products,
            'total_user_policies' => $total_user_policies,
            'total_approved_user_policies' => $approved,
            'pending_policies' => $pending,
            'rejected_policies' => $rejected,
            'incart_policies' => $inCart,
            'submitted_this_month' => $submittedThisMonth,
            'total_customers' => $total_customers,
            'total_premium' => $totalPremium,
            'recent_policies' => $recentPolicies,
            'chart_months' => $monthLabels,
            'chart_monthly_counts' => $monthlyCounts,
            'chart_status_labels' => $statusChartLabels,
            'chart_status_counts' => $statusChartCounts,
            'chart_plan_labels' => $planLabels,
            'chart_plan_counts' => $planCounts,
        ]);
    }
}
