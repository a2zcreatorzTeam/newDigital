<div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>City</th>
                        <th>Province</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->province->name ?? '' }}</td>
                        <td>
                            @can('city-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('city.edit',$city->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan

                            @can('city-delete')
                            <form method="POST" action="{{ route('city.destroy', $city->id) }}" style="display:inline" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                   <tr><td colspan="4" class="text-center text-muted">No data available</td></tr>
                   @endforelse

                </tbody>
            </table>
        </div>

<!-- PAGINATION -->
<div class="mt-3 d-flex justify-content-end">
    {{ $cities->links('pagination::bootstrap-5') }}
</div>