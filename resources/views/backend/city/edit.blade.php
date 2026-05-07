@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Edit City</h1>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">cities</h3>
            @can('city-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('city.index')}}">City List</a>
            @endcan
        </div>
        <form method="POST" action="{{ route('city.update', $city->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $city->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Provinces:</strong>
                        <select name="province" class="form-control">
                            <option value=""> Select Province</option>
                        @foreach($provinces as $value)
                            <option value="{{ $value->id }}" {{ ($value->id == $city->province_id) ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                        </select>
                        @error('province')
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