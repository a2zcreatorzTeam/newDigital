@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Main Policies Ctaegory Management</h1>
    </div>


    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h3 class="font-semibold text-dark mb-0" style="font-size: 1.1rem;">Policies Category</h3>
            <div class="d-flex align-items-center gap-2">

            <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}"
            class="btn"
            style="border-radius:6px;
                    background:#b7b5b1;
                    color:#84827f;
                    border-color:#b7b5b1;">

                <i class="fa-solid fa-file-csv"></i>
                <span>Export</span>
            </a>

            @can('class-create')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('class.create')}}">Create New Category</a>
            @endcan
        </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $key => $data)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->name }}</td>

                        <td>
                            <img src="{{ asset('storage/'.$data->logo) }}" alt="logo image" width="100px" height="100px">
                        </td>
                        <td>{{ $data->status==1 ? 'Active' : 'In active' }}</td>


                        <td>
                            @can('class-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('class.edit',$data->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan

                            @can('class-delete')
                            <form method="POST" action="{{ route('class.destroy', $data->id) }}" style="display:inline" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="mt-3">
                {{ $classes->links('pagination::bootstrap-4') }}
            </div>

            <div class="mt-2">
                Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }}
                of {{ $classes->total() }} entries
            </div>
        </div>
    </div>
</section>


</main>
@endsection