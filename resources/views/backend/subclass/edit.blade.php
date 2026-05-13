@extends('backend.layout.master')
@section('content')

<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Edit Policy</h1>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Policy</h3>

            @can('class-list')
            <a class="btn btn-icon" style="background-color:#ff5733;" href="{{ route('subclass.index') }}">
                Policiy List
            </a>
            @endcan
        </div>

        <form method="POST" action="{{ route('subclass.update', $subclass->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Main Class Dropdown -->
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Main Class:</strong>
                        <select name="class_id" class="form-control">
                            <option value="">Select Main Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ $subclass->class_id == $class->id ? 'selected' : '' }}>
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
                        <input type="text" name="name" class="form-control"
                               value="{{ $subclass->name }}"
                               placeholder="Enter Sub Class Name">
                    </div>
                </div>

                <!-- Current Logo -->
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Current Image:</strong><br>

                        @if($subclass->logo)
                            <img src="{{ asset('storage/'.$subclass->logo) }}" width="80">
                        @else
                            <span class="text-muted">No Logo</span>
                        @endif
                    </div>
                </div>

                <!-- Change Logo -->
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
                            <option value="1" {{ $subclass->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $subclass->status == 0 ? 'selected' : '' }}>Inactive</option>
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

@endsection