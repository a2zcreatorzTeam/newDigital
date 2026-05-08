@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Policy</h1>
    </div>

    <div class="card">
    <div class="bg-light text-center rounded p-4">
    <div class="row">
        <div class="pdmadatalist">
            <!--Toolbar-->
                <div class="toolbar">
                    <div class="filters-toolbar-wrapper">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label>Policy Category</label>
                                <select name="" id="plan" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($Classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Policy Number</label>
                                <input type="text" id="policy_number" class="form-control" placeholder="Policy Number">
                            </div>
                            <div class="col-md-4">
                                <label>User Search</label>
                                <input type="text" id="user_detail_search" class="form-control" placeholder="Name, Email, Mobile, CNIC">
                            </div>
                            <div class="col-md-4">
                                <label for="Sorting">Sort By</label>
                                <select name="sorting" id="sorting" class="form-control">
                                    <option value="id">ID</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Sorting">Direction</label>
                                <select name="direction" id="direction" class="form-control">
                                    <option value="asc" selected>ASC</option>
                                    <option value="desc" >DESC</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Sorting">Qty</label>
                                <select name="qty" id="qty" class="form-control">
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- AJAX CONTENT -->
        <div id="table_data">
            @include('backend.userPolicy.table')
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
                url: "{{ route('user.policy.list') }}?page=" + page,
                type: "GET",
                data: {
                    policy_number: $("#policy_number").val(),
                    user_detail_search: $("#user_detail_search").val(),
                    plan: $("#plan").val(),
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
        $("#plan, #sorting, #direction, #qty").on("change", function () {
            loadData();
        });

        $("#policy_number, #user_detail_search").on("keyup", function () {
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