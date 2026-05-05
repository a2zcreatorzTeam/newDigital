<div class="table-responsive">

    <table class="table table-bordered table-hover align-middle text-center">

        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Policy Name</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $item)
            <tr>

                <td class="align-middle">
                    {{ $loop->iteration }}
                </td>

                <td class="align-middle">
                    {{ $item->mainClass->name ?? 'N/A' }}
                </td>

                <td class="align-middle">
                    {{ $item->name }}
                </td>

                <td class="align-middle">
                    <img src="{{ asset('storage/'.$item->logo) }}"
                        width="60"
                        height="60"
                        style="object-fit: cover; border-radius: 6px;">
                </td>

                <td class="align-middle">
                    <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td class="align-middle">
                    @can('class-edit')
                    <a class="btn btn-primary btn-sm"
                        href="{{ route('subclass.edit', $item->id) }}">
                        Edit
                    </a>
                    @endcan

                    @can('class-delete')
                    <form method="POST"
                        action="{{ route('subclass.destroy', $item->id) }}"
                        style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                    @endcan
                </td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>

{{-- PAGINATION OUTSIDE TABLE --}}
<div class="mt-3">
    {{ $data->links('pagination::bootstrap-4') }}
</div>

<div class="mt-2">
    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
    of {{ $data->total() }} entries
</div>