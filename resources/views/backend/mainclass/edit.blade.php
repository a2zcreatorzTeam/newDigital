@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Edit Policies Category</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Policies Category</h3>
            @can('class-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('class.index')}}">Category List</a>
            @endcan
        </div>
        <form method="POST" action="{{ route('class.update', $class->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Name -->
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" class="form-control"
                            value="{{ $class->name }}" placeholder="Enter Class Name">
                    </div>
                </div>

                <!-- Old Logo Preview -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Current Logo:</strong><br>

                        @if($class->logo)
                        <img src="{{ asset('storage/'.$class->logo) }}" width="80">
                        @else
                        <span class="text-muted">No Logo</span>
                        @endif
                    </div>
                </div>

                <!-- Upload New Logo -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Change Logo:</strong>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="status" class="form-control">
                            <option value="1" {{ $class->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $class->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Update
                    </button>
                </div>

            </div>
        </form>


    </div>
</section>

</main>
@endsection