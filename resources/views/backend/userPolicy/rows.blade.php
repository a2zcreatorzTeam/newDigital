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
                        @if($row->status == 'Approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>
                        @elseif($row->status == 'Rejected')
                                <span class="badge bg-danger">
                                    Rejected
                                </span>
                        @else
                                <span class="badge bg-warning">
                                    {{ ucfirst($row->status) }}
                                </span>
                        @endif
                        @if($row->status_updated_by)
                            <div class="small text-muted mt-1" style="font-size: 9px;">
                                By: {{ $row->StatusUpdatedBy->name }}
                            </div>
                        @endif
                    </td>
                        <td>
                            <a class="btn p-2" style="font-size:12px;background-color:#ff5733;"
                             href="{{ route('user.policy.policyDetail',$row->id) }}">Detail</a>
                        </td>
                    </tr>
                   @empty
                   <tr><td colspan="7" class="text-center text-muted">No policy available</td></tr>
                   @endforelse