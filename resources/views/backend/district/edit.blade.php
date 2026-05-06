@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Edit District</h1>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Districts</h3>
            @can('district-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('district.index')}}">District List</a>
            @endcan
        </div>
        <form method="POST" action="{{ route('district.update', $district->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $district->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>City:</strong>
                        <select name="city_id" class="form-control">
                            <option value=""> Select City</option>
                        @foreach($cities as $value)
                            <option value="{{ $value->id }}" {{ ($value->id == $district->city_id) ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                        </select>
                        @error('city_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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