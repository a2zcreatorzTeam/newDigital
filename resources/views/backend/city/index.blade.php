@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">City Management</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Cities</h3>
             @can('city-create')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('city.create')}}">Add New City</a>
             @endcan
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Province</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $key => $city)
                    <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->province->name }}</td>
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
                    @endforeach

                </tbody>
            </table>
            {{ $cities->links() }}
        </div>
    </div>
</section>


</main>
@endsection