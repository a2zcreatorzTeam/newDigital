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
        <div class="bg-light p-3">

            <!-- FILTERS -->
            <div class="row mb-3">

                <div class="col-md-3">
                    <select id="province" class="form-control">
                        <option value="">Select Province</option>
                        @foreach($provinces as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" id="city_name" class="form-control" placeholder="City name">
                </div>

                <div class="col-md-2">
                    <select id="sorting" class="form-control">
                        <option value="id">ID</option>
                        <option value="name">Name</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="direction" class="form-control">
                        <option value="asc">ASC</option>
                        <option value="desc" selected>DESC</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="qty" class="form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

            </div>

            <!-- AJAX CONTENT -->
            <div id="table_data">
                @include('backend.city.table')
            </div>

        </div>
    </div>
</section>


</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    function loadData(page = 1) {

        $.ajax({
            url: "{{ route('city.index') }}?page=" + page,
            type: "GET",
            data: {
                province: $("#province").val(),
                city_name: $("#city_name").val(),
                sorting: $("#sorting").val(),
                direction: $("#direction").val(),
                qty: $("#qty").val(),
            },
            success: function (data) {
                $("#table_data").html(data);
            }
        });

    }

    // filters
    $("#province, #sorting, #direction, #qty").on("change", function () {
        loadData();
    });

    $("#city_name").on("keyup", function () {
        loadData();
    });

    // pagination
    $(document).on("click", ".pagination a", function (e) {
        e.preventDefault();
        let page = $(this).attr("href").split("page=")[1];
        loadData(page);
    });

});
</script>
@endsection