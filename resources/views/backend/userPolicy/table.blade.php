<div class="table-responsive">
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
                    <td>{{ ucfirst($row->status) ?? '-' }}</td>
                        <td>
                            <a class="btn p-2" style="font-size:12px;background-color:#ff5733;"
                             href="{{ route('user.policy.policyDetail',$row->id) }}"> Show Detail</a>
                        </td>
                    </tr>
                   @empty
                   <tr><td colspan="7" class="text-center text-muted">No policy available</td></tr>
                   @endforelse
                   </tbody>
            </table>
        </div>
     <!-- Pagination -->
     <div class="mt-3 d-flex justify-content-end">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>
