@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User</h1>
    </div>


    <div class="card">
        <div class="flex justify-between items-center mb-4">
             <h3 class="font-semibold text-dark" style="font-size: 1.1rem;"></h3>
             @can('user-list')
            <a class="btn  btn-icon" style="background-color:#ff5733;" href="{{route('users.index')}}">User List</a>
             @endcan
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permissions:</strong>

                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top:10px;">
                         @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                        <span style="
                        background:#e6f4ea;
                        color:#2e7d32;
                        padding:6px 12px;
                        border-radius:20px;
                        font-size:13px;
                        font-weight:500;
                    ">
                            {{ $v }}
                        </span>
                        @endforeach
                        @else
                        <span style="color: gray;">No permissions assigned</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>


    </div>
</section>


</main>
@endsection