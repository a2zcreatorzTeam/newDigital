@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Main Class Management</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Main Classess</h3>
            @can('class-create')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('class.create')}}">Create New Class</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>logo</th>
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
                            <img src="{{asset($data->logo)}}" alt="logo image" width="100px" height="100px">
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
        </div>
    </div>
</section>


</main>
@endsection