
<div class="bg-light text-center rounded p-4">
    <div class="row">
        <div class="pdmadatalist">
            <!--Toolbar-->
            <div class="toolbar">
                <div class="filters-toolbar-wrapper">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                            <input type="text" id="user_detail_search" class="form-control" placeholder="Search By Name, Email">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    
    $(document).ready(function() {
        $('.select2').select2();
        function filter_data(currentpage) {
            $('.filter_data').html('<div id="loading"></div>');
            var action = 'fetch_data';
            var sorting = $("#sorting").val();
            var direction = $("#direction").val();
            var qty = $("#qty").val();
            var user_detail_search = $("#user_detail_search").val();
            var role =$("#role").val();
            var ayis_page = currentpage ?? 1;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.index') }}",
                type: 'GET',
                data: {
                    action: action,
                    user_detail_search: user_detail_search,
                    role:role,
                    sorting: sorting,
                    direction: direction,
                    qty: qty,
                    ayis_page: ayis_page,
                },

                beforeSend: function () {
                    $('#filter_data').html(`
                        <tr>
                            <td colspan="5" class="text-center">Loading...</td>
                        </tr>
                    `);
                },
                success: function(data) {

                    $('#filter_data').html(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        $('body').on('change', '#sorting, #direction, #qty,#role', function () {
            filter_data();
        });

        $('body').on('keyup', '#user_detail_search', function () {
            filter_data();
        });
        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            filter_data(page);
        });
    });
</script>

