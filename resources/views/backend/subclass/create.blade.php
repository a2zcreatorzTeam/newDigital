@extends('backend.layout.master')
@section('content')

<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Create Policies</h1>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Policies</h3>

            @can('class-list')
            <a class="btn btn-icon" style="background-color:#ff5733;" href="{{ route('class.index') }}">
                Policies List
            </a>
            @endcan
        </div>

        <form method="POST" action="{{ route('subclass.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- Main Class Dropdown -->
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select name="class_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Sub Class Name -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Enter Sub Class Name" class="form-control">
                    </div>
                </div>

                <!-- Logo -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Image:</strong>
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

@endsection