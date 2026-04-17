@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Management</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Users</h3>
            @can('user-create')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('users.create')}}">Create New User</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                            <details>
                                <summary style="cursor:pointer; font-weight:600; color:#0d6efd;">
                                    View {{ count($user->getRoleNames()) }} Roles
                                </summary>

                                <div style="margin-top:8px;">
                                    @foreach($user->getRoleNames() as $v)
                                    <ul>
                                        <li> {{ $v }}</li>
                                    </ul>
                                    @endforeach
                                </div>
                            </details>
                            @endif
                        </td>
                        <td>
                            <a class="btn  btn-sm" style="background-color:#ff5733;" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
         
                            @can('user-delete')
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline" class="delete-form">
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