@extends('backend.layout.master')
@section('content')
<style>
    label {
        display: flex;

    }
</style>

<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">Policies Management</h1>
    </div>

    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Policies Product</h3>

            @can('class-create')
            <a class="btn btn-icon" style="background-color:#ff5733;"
                href="{{ route('subclass.create') }}">
                Create Policies
            </a>
            @endcan
        </div>

        <!-- Navbar End -->
        <div class="container-fluid pt-4 px-4 form_width">
            <div class="bg-light text-center rounded p-4">

                <div class="row">



                    <div class="pdmadatalist">
                        <!--Toolbar-->
                        <div class="toolbar">
                            <div class="filters-toolbar-wrapper">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label>Policy Category</label>
                                        <select name="" id="main_class" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($Classes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
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
                                            <option value="asc">ASC</option>
                                            <option value="desc" selected>DESC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="qty" id="qty" class="form-control">
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="filter_data"></div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>



@push('ayiscss')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<style>
    .pdmadatalist .form-group {
        margin-bottom: 15px;
    }

    .pdmadatalist label {
        display: block;
        text-align: left;
    }

    .pdmadatalist .select2-container {
        width: 100% !important;
        text-align: left;
    }
</style>
@endpush
@push('msncript')
<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.js-example-basic-multiple').select2();






    });

    $(document).ready(function() {
        filter_data();

        function filter_data(currentpage) {
            $('.filter_data').html('<div id="loading"></div>');
            var action = 'fetch_data';
            var sorting = $("#sorting").val();
            var direction = $("#direction").val();
            var qty = $("#qty").val();
            var main_class = $("#main_class").val();


            var district = $("#district").val();
            var tehsil_id = $("#tehsil_id").val();
            var uc_id = $("#uc_id").val();

            var beneficiary_name = $("#beneficiary_name").val();
            var bank_name = $("#bank_name").val();
            var b_reference_number = $("#b_reference_number").val();
            var cnic = $("#cnic").val();

            //var colors = get_filter('color');


            var ayis_page = currentpage ?? 1;

            $.ajax({
                type: 'POST',
                url: "{{ route('subclass.list') }}",
                data: {
                    action: action,
                    district: district,
                    tehsil_id: tehsil_id,
                    uc_id: uc_id,
                    b_reference_number: b_reference_number,
                    bank_name: bank_name,
                    beneficiary_name: beneficiary_name,
                    cnic: cnic,
                    sorting: sorting,
                    direction: direction,
                    qty: qty,
                    main_class: main_class,
                    ayis_page: ayis_page,
                    _token: '{{csrf_token()}}'
                },

                beforeSend: function() {
                    $('.filter_data').html('<center><img src="subclasses/YsUnZN2QL6RKIvkklcr6sx7zCNBsgCpU4amTlUIv.jpg" width="100" alt="Loader" /></center>');
                },
                success: function(data) {

                    $('.filter_data').html(data);
                },
                error: function(data) {
                }
            });

        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }





        $('.common_selector').click(function() {
            filter_data();
        });

        $("#b_reference_number, #beneficiary_name, #cnic").on('keyup keydown', function() {
            filter_data();
        });



        $('body').on('change', '#sorting, #direction, #qty,#main_class, #district, #tehsil_id, #uc_id,#bank_name', function(e) {
            e.preventDefault();

            filter_data();
        });

        $('body').on('click', '.pagination a', function(f) {
            f.preventDefault();
            var url = $(this).attr('href');
            var currentpage = url.split('page=')[1];
            filter_data(currentpage);
        });







    });
</script>
@endpush

@endsection