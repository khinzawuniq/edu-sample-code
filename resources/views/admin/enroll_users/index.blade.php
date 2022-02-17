@extends('layouts.admin-app')
@push('styles')
    <style>
      .active-control, .filter-courses {
        cursor: pointer;
      }
    </style>
@endpush
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="m-0 wfh-text-color font-weight-bold">Enrolled Students</h3>
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row mt-2">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <table class="table table-striped table-hover datatable">
                <thead>
                    <tr class="wfh-table-bg text-center">
                     <th>ID</th>
                     <th>Name</th>
                     <th>Course Name</th>
                     <th>Slip Image</th>
                     <th>Payment Status</th>
                     {{-- <th>Actions</th> --}}
                  </tr>
                </thead>
                <tbody id="sortable">
                  @foreach($enroll_users as $key => $enroll_user)
                  <tr>

                    <td>{{$enroll_user->id}}</td>
                    <td>{{$enroll_user->user->name}}</td>
                    <td>{{$enroll_user->course ? $enroll_user->course->course_name : '-'}}</td>
                    <td>
                        @if ($enroll_user->slip)
                          @if($enroll_user->status == "payment")
                            <img src="{{asset('uploads/payment_slips/'.$enroll_user->slip)}}" alt="" width="50px">
                          @else
                            <img src="{{asset('uploads/enroll_slip/'.$enroll_user->slip)}}" alt="" width="50px">
                          @endif
                        @endif
                    </td>
                    <td>{{$enroll_user->payment_status ? config('payment-status.status')[$enroll_user->payment_status] : 'Pending'}}</td>
                    {{-- <td>
                       <a href="" class="btn btn-sm btn-success"><i class="fas fa-user-check"></i></a>
                       <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td> --}}
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection