<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Policy Number</th>
            <th>Policy Plan</th>
            <th>User</th>
            <th>User Detail</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->policy_id ?? '-' }}</td>
            <td>
                <div class="d-flex flex-column">
                    <span>{{ optional($row->policyPlan)->name ?? 'N/A' }}</span>
                    <span>{{ optional(optional($row->policyPlan)->mainClass)->name ?? 'N/A' }}</span>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span>{{ optional($row->user)->name ?? 'N/A' }}</span>
                    <span>{{ optional($row->user)->email ?? 'N/A' }}</span>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span>
                        <strong>Mobile:</strong>
                        {{ $row->mobile_number ?? 'N/A' }}
                    </span>

                    <span>
                        <strong>CNIC:</strong>
                        {{ $row->cnic_number ?? 'N/A' }}
                    </span>
                </div>
            </td>
            <td>
                <span style="
                            display:inline-block;
                            padding:4px 11px;
                            border-radius:20px;
                            font-size:11px;
                            font-weight:600;
                            background-color:
                                {{ $row->status == 'Approved' ? '#95f0b8' : 
                                ($row->status == 'Pending' ? '#cdeaff' : 
                                ($row->status == 'Rejected' ? '#f1c2c7' :
                                ($row->status == 'InCart' ? '#f6ca90' : '#edf19e'))) }};
                        ">
                    {{ ucfirst($row->status ?? '-') }}
                </span>
            </td>
            <td>
                <a class="btn p-2" style="font-size:12px;background-color:#ff5733;"
                     href="{{ route('user.policy.policyDetail', Crypt::encryptString($row->id)) }}">
                    Show Detail</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center text-muted">No policy available</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $data->links('pagination::bootstrap-4') }}
</div>

<div class="mt-2">
    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
    of {{ $data->total() }} entries
</div>