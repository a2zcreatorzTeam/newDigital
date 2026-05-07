<div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($districts as $key => $district)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $district->name }}</td>
                        <td>{{ $district->city->name }}</td>
                        <td>
                            @can('district-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('district.edit',$district->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan

                            @can('district-delete')
                            <form method="POST" action="{{ route('district.destroy', $district->id) }}" style="display:inline" class="delete-form">
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
    {{ $districts->links('pagination::bootstrap-5') }}
</div>