@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Policy</h1>
    </div>

    <div class="card">
        @include('backend.userPolicy.filter')
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Policy Number</th>
                        <th>Policy Plan</th>
                        <th>User</th>
                        <th>User Detail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="filter_data">
                    @include('backend.userPolicy.rows')
                </tbody>
            </table>
        </div>
        {{-- PAGINATION OUTSIDE TABLE --}}
    <div class="mt-3">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>

    <div class="mt-2">
        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
        of {{ $data->total() }} entries
    </div>
    </div>
</section>


</main>
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
@endsection