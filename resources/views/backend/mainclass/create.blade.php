@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Create Main Class</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Main Classes</h3>
            @can('class-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('roles.index')}}">Role List</a>
            @endcan
        </div>
        <form method="POST" action="{{ route('class.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- Name -->
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Enter Class Name" class="form-control">
                    </div>
                </div>

                <!-- Logo -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Logo:</strong>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Submit
                    </button>
                </div>

            </div>
        </form>


    </div>
</section>

</main>
@endsection