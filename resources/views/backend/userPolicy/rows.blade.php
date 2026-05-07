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
                             href="{{ route('user.policy.policyDetail',$row->id) }}"><i class="fa-solid fa-list"></i> Show Detail</a>
                        </td>
                    </tr>
                   @empty
                   <tr><td colspan="7" class="text-center text-muted">No policy available</td></tr>
                   @endforelse