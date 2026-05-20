@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">District Management</h1>
    </div>


    <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <h3 class="font-semibold text-dark mb-0" style="font-size: 1.1rem;">
            Districts
        </h3>

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

            @can('district-create')
            <a class="btn"
            style="background-color:#ff5733;color:white;"
            href="{{ route('district.create') }}">

                Add New District
            </a>
            @endcan

        </div>        
        </div>
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
                    @foreach ($districts as $key => $district)
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
                    @endforeach

                </tbody>
            </table>
            <div class="mt-3">
                {{ $districts->links('pagination::bootstrap-4') }}
            </div>

            <div class="mt-2">
                Showing {{ $districts->firstItem() }} to {{ $districts->lastItem() }}
                of {{ $districts->total() }} entries
            </div>
        </div>
    </div>
</section>


</main>
@endsection