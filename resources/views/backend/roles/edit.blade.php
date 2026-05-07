@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Edit Role</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Roles</h3>
            @can('role-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('roles.index')}}">Role List</a>
            @endcan
        </div>
        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permission:</strong>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top:10px;">
                            @foreach($permission as $value)
                            <label style="background:#f1f1f1; padding:6px 12px; border-radius:20px; cursor:pointer;">
                                <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}"
                                {{ in_array($value->id, $rolePermissions) ? 'checked' : ''}} style="margin-right:5px;">
                                {{ $value->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                </div>
            </div>
        </form>


    </div>
</section>

</main>
@endsection