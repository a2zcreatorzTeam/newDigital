@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Overview Dashboard</h1>
    </div>

    <div class="kpi-grid">
        <div class="card kpi-card">
            <div class="kpi-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div>
                <div class="text-muted">Total Policies</div>
                <div class="kpi-value" id="kpi-total">{{ $total_policies }}</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: var(--success-bg); color: var(--success);"><i class="fa-solid fa-check-shield"></i></div>
            <div>
                <div class="text-muted">Active Policies</div>
                <div class="kpi-value" id="kpi-active">{{ $active_policies }}</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #fef3c7; color: var(--warning);"><i class="fa-solid fa-coins"></i></div>
            <div>
                <div class="text-muted">Total Premium</div>
                <div class="kpi-value" id="kpi-premium">0</div>
            </div>
        </div>
        <div class="card kpi-card">
            <div class="kpi-icon" style="background: #e0f2fe; color: #0284c7;"><i class="fa-solid fa-chart-line"></i></div>
            <div>
                <div class="text-muted">Total Users Policies</div>
                <div class="kpi-value" id="kpi-avg">0</div>
            </div>
        </div>
    </div>



    <div class="widgets-grid">
        <div class="card">
            <h3 class="font-semibold mb-4 text-dark" style="font-size: 1.1rem;"><i class="fa-solid fa-trophy text-warning"></i> Top Policy Holders</h3>
            <div id="top-holders-list">
            </div>
        </div>
        <div class="card">
            <h3 class="font-semibold mb-4 text-dark" style="font-size: 1.1rem;"><i class="fa-solid fa-bolt text-secondary"></i> Quick Stats</h3>
            <div class="flex items-center gap-4 mt-4">
                <div style="font-size: 2.5rem; color: var(--primary);"><i class="fa-solid fa-hourglass-half"></i></div>
                <div>
                    <div class="font-bold" style="font-size: 1.5rem;" id="expiring-count">3</div>
                    <div class="text-muted">Policies expiring this quarter</div>
                </div>
            </div>
        </div>
        <div class="card">
            <h3 class="font-semibold mb-4 text-dark" style="font-size: 1.1rem;"><i class="fa-solid fa-clock-rotate-left text-primary"></i> Recent Activity</h3>
            <div id="activity-feed"></div>
        </div>
    </div>
    {{--
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Recent Policies</h3>
                <button class="btn btn-outline btn-icon" onclick="switchTab('manager')">View All</button>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Policy ID</th>
                            <th>Policy Name</th>
                            <th>Holder Name</th>
                            <th>Premium</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="dashboard-recent-table">
                    </tbody>
                </table>
            </div>
        </div>
        --}}
</section>

<section id="section-manager" class="hidden">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Policy Manager</h1>
    </div>

    <div class="manager-grid">
        <div class="card" style="position: sticky; top: 20px;">
            <h3 id="form-title" class="font-semibold mb-4 text-primary" style="font-size: 1.1rem;">Create New Policy</h3>
            <form id="policy-form">
                <input type="hidden" id="form-id">
                <div class="form-group">
                    <label class="form-label">Policy Name</label>
                    <input type="text" id="form-name" class="form-control" placeholder="e.g. Health Plus" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Holder Name</label>
                    <input type="text" id="form-holder" class="form-control" placeholder="e.g. Ali Khan" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Premium Amount ($)</label>
                    <input type="number" id="form-premium" class="form-control" min="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="form-status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" id="form-submit-btn" class="btn btn-primary" style="flex: 1;">Save</button>
                    <button type="button" id="form-cancel-btn" class="btn btn-outline hidden">Cancel</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">All Policies Directory</h3>
                <span class="text-muted font-bold" id="manager-count">0 Records</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Policy Name</th>
                            <th>Holder</th>
                            <th>Premium</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="manager-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</main>
@endsection