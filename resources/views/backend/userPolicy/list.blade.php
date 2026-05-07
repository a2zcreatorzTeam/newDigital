@extends('backend.layout.master')
@section('content')


<section id="section-dashboard">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-dark" style="font-size: 1.5rem;">User Policy</h1>
    </div>


    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Policy</th>
                        <th>User</th>
                        <th>User Detail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a class="btn  btn-sm" style="background-color:#ff5733;"
                             href="{{ route('user.policy.policyDetail',2) }}"><i class="fa-solid fa-list"></i> Show Detail</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</section>


</main>
@endsection