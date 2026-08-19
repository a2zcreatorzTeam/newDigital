@extends('backend.layout.master')
@section('content')

<style>
    .dash-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .dash-kpi-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .chart-card h3 {
        font-size: 1.05rem;
        font-weight: 650;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .status-pill {
        display: inline-block;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .recent-meta {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .dash-empty {
        text-align: center;
        color: var(--text-muted);
        padding: 2rem 1rem;
    }
</style>

<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Overview Dashboard</h1>
            <p class="dash-subtitle">Live policy applications, status mix, and product performance</p>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="card kpi-card">
            <div class="kpi-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div>
                <div class="text-muted">Policy Categories</div>
                <div class="kpi-value">{{ $total_policies }}</div>
                <div class="dash-kpi-hint">{{ $active_policies }} active</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: var(--success-bg); color: var(--success);"><i class="fa-solid fa-layer-group"></i></div>
            <div>
                <div class="text-muted">Products</div>
                <div class="kpi-value">{{ $total_products }}</div>
                <div class="dash-kpi-hint">Available plans</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #fef3c7; color: var(--warning);"><i class="fa-solid fa-file-signature"></i></div>
            <div>
                <div class="text-muted">User Policies</div>
                <div class="kpi-value">{{ $total_user_policies }}</div>
                <div class="dash-kpi-hint">{{ $submitted_this_month }} submitted this month</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #e0f2fe; color: #0284c7;"><i class="fa-solid fa-circle-check"></i></div>
            <div>
                <div class="text-muted">Approved</div>
                <div class="kpi-value">{{ $total_approved_user_policies }}</div>
                <div class="dash-kpi-hint">{{ $pending_policies }} pending · {{ $rejected_policies }} rejected</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #ede9fe; color: #6d28d9;"><i class="fa-solid fa-users"></i></div>
            <div>
                <div class="text-muted">Customers</div>
                <div class="kpi-value">{{ $total_customers }}</div>
                <div class="dash-kpi-hint">Registered applicants</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #dcfce7; color: #15803d;"><i class="fa-solid fa-coins"></i></div>
            <div>
                <div class="text-muted">Total Premium</div>
                <div class="kpi-value">{{ number_format($total_premium) }}</div>
                <div class="dash-kpi-hint">Calculated premium (PKR)</div>
            </div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="card chart-card">
            <h3><i class="fa-solid fa-chart-area text-primary"></i> Applications (last 12 months)</h3>
            <div class="chart-container">
                <canvas id="chartMonthly"></canvas>
            </div>
        </div>
        <div class="card chart-card">
            <h3><i class="fa-solid fa-chart-pie text-primary"></i> Status mix</h3>
            <div class="chart-container">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>

    <div class="charts-grid" style="grid-template-columns: 1fr;">
        <div class="card chart-card">
            <h3><i class="fa-solid fa-chart-column text-primary"></i> Applications by product</h3>
            <div class="chart-container" style="height: 280px;">
                <canvas id="chartPlans"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Recent submissions</h3>
            @can('userPolicy-list')
            <a href="{{ route('user.policy.filter') }}" class="btn btn-outline btn-sm" style="color: var(--primary) !important;">View all</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Policy Number</th>
                        <th>Plan</th>
                        <th>Applicant</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_policies as $row)
                    @php
                        $statusColor = $row->status == 'Approved' ? '#95f0b8' : ($row->status == 'Pending' ? '#cdeaff' : ($row->status == 'Rejected' ? '#f1c2c7' : ($row->status == 'InCart' ? '#f6ca90' : '#edf19e')));
                    @endphp
                    <tr>
                        <td>{{ $row->policy_id ?? '-' }}</td>
                        <td>{{ optional($row->policyPlan)->name ?? 'N/A' }}</td>
                        <td>
                            <div>{{ optional($row->user)->name ?? 'N/A' }}</div>
                            <div class="recent-meta">{{ optional($row->user)->email ?? '' }}</div>
                        </td>
                        <td>
                            @if($row->created_at)
                                {{ $row->created_at->timezone('Asia/Karachi')->format('d-m-Y') }}
                                <div class="recent-meta">{{ $row->created_at->timezone('Asia/Karachi')->format('h:i A') }}</div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="status-pill" style="background-color: {{ $statusColor }};">{{ $row->status ?? '-' }}</span>
                        </td>
                        <td>
                            @can('userPolicy-list')
                            <a class="btn p-2" style="font-size:12px;background-color:#ff5733;white-space:nowrap;"
                                href="{{ route('user.policy.policyDetail', \Illuminate\Support\Facades\Crypt::encryptString($row->id)) }}">
                                Show Detail</a>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="dash-empty">No user policies submitted yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@push('msncript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthLabels = @json($chart_months);
        const monthCounts = @json($chart_monthly_counts);
        const statusLabels = @json($chart_status_labels);
        const statusCounts = @json($chart_status_counts);
        const planLabels = @json($chart_plan_labels);
        const planCounts = @json($chart_plan_counts);

        const gridColor = '#e2e8f0';
        const tickColor = '#64748b';

        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = tickColor;

        const monthlyEl = document.getElementById('chartMonthly');
        if (monthlyEl) {
            new Chart(monthlyEl, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Applications',
                        data: monthCounts,
                        borderColor: '#1e40af',
                        backgroundColor: 'rgba(30, 64, 175, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#1e40af'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: gridColor } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        const statusEl = document.getElementById('chartStatus');
        if (statusEl) {
            new Chart(statusEl, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusCounts,
                        backgroundColor: ['#10b981', '#38bdf8', '#ef4444', '#f59e0b'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } }
                    },
                    cutout: '62%'
                }
            });
        }

        const plansEl = document.getElementById('chartPlans');
        if (plansEl) {
            new Chart(plansEl, {
                type: 'bar',
                data: {
                    labels: planLabels.length ? planLabels : ['No data'],
                    datasets: [{
                        label: 'Applications',
                        data: planCounts.length ? planCounts : [0],
                        backgroundColor: '#3b82f6',
                        borderRadius: 6,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: gridColor } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endpush
