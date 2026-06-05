@extends('backend.layout.master')
@section('content')
<style>
    label {
    display: inline-block;
    text-align: start !important;
    width: 100%;
}
</style>

<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Management</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-dark" style="font-size: 1.1rem;">Users</h3>
            <div class="d-flex align-items-center gap-2">
            <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}"
            class="btn"
            style="border-radius:6px;
                    background:#b7b5b1;
                    color:#84827f;
                    border-color:#b7b5b1;">

                <i class="fa-solid fa-file-csv"></i>
                <span>Export</span>
            </a>
            @can('user-create')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('users.create')}}">Create New User</a>
            @endcan
            </div>
        </div>
        @include('backend.users.filter')
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody id="filter_data">
                    @include('backend.users.rows')
                </tbody>
            </table>
            <div class="mt-3">
                {{ $data->links('pagination::bootstrap-4') }}
            </div>

            <div class="mt-2">
                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                of {{ $data->total() }} entries
            </div>
        </div>
    </div>
</section>


</main>
@endsection