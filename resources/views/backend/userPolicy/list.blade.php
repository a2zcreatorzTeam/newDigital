@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Policy</h1>
    </div>

    <div class="card">
        @include('backend.userPolicy.filter')
        <div class="table-responsive">
                <div id="policy_list">
                    @include('backend.userPolicy.rows')
                </div>
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