@extends('layouts.admin-app')


@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Payments</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
              <div class="card-title"> Payment Detail </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-striped table-hover">
                  <tbody>
                      <tr>
                          <th width="200px">Name</th>
                          <td width="30px">:</td>
                          <td> 
                            @if($studentPayment->student_id != 0)
                              <a href="{{url('/admin/users/'.$studentPayment->student_id)}}"> {{$studentPayment->name}}  </a>
                            @else
                            {{$studentPayment->name}}
                            @endif
                            
                          </td>
                      </tr>
                      <tr>
                          <th width="200px">Email</th>
                          <td width="30px">:</td>
                          <td> {{$studentPayment->email}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Phone</th>
                          <td width="30px">:</td>
                          <td> {{$studentPayment->phone}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Course</th>
                          <td width="30px">:</td>
                          <td> {{$studentPayment->course->course_name}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Payment Method</th>
                          <td width="30px">:</td>
                          <td> {{$studentPayment->paymentType->bank_name}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Payment Description</th>
                          <td width="30px">:</td>
                          <td> {{$studentPayment->payType->pay_name}} </td>
                      </tr>
                      
                      @if($studentPayment->payType->pay_name == "Installment")
                      <tr>
                        <th>Installment Time</th>
                        <td>:</td>
                        <td> {{$studentPayment->installment_time}} </td>
                      </tr>
                      @endif

                      <tr>
                          <th width="200px">Slip Image</th>
                          <td width="30px">:</td>
                          <td> 
                            @if(!empty($studentPayment->payment_screenshot))
                            <a href="{{asset('/uploads/payment_slips/'.$studentPayment->payment_screenshot)}}" data-toggle="lightbox" data-title="Payment Slip">
                              <img src="{{asset('/uploads/payment_slips/'.$studentPayment->payment_screenshot)}}" alt="Payment Slip Image" style="width:200px;">
                            </a>
                            @else
                            Empty Slip Image
                            @endif
                          </td>
                      </tr>
                      <tr>
                        <th width="200px">Approve Status</th>
                        <td width="30px">:</td>
                        <td> {{($studentPayment->approve_status == 1)? 'Approved':'Pending'}} </td>
                    </tr>
                      
                  </tbody>
              </table>
              </div>

            </div>

            <div class="card-footer">
              @php
                $next = $studentPayment->id-1;
              @endphp
              <a style="width:120px;" href="{{route('payments.index')}}" class="btn btn-info">Back To List</a>
              @if($studentPayment->approve_status == 0)
                @if(count($batch_groups) == 0)
                  <a style="width:170px;" href="{{url('/admin/payments/'.$studentPayment->id.'/approve?next='.$next)}}" class="btn btn-success">Approve and Next</a>
                @else
                  <a style="width:170px;" href="#" data-toggle="modal" data-target="#batchModal" class="btn btn-success">Approve and Next</a>
                @endif
              @endif
              <a style="width:120px;" href="{{route('payments.show', $next)}}" class="btn btn-primary">Next</a>
            </div>
        </div>
        
    </section>
    <!-- /.content -->

    <!-- Modal -->
  <div class="modal fade" id="batchModal" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="batchModalLabel">Select Batch Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('/admin/payments/'.$studentPayment->id.'/approve')}}" method="get" id="batch_group_form">

            <input type="hidden" name="next" id="next" value="{{$next}}">

            <div class="form-group">
              {!! Form::select('batch_group_id', $batch_groups, old('batch_group_id'), array('placeholder' => 'Select Batch Group','class' => 'form-control', 'id'=>'batch_group_id')) !!}
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('styles')
<style>
.course-row.bg-primary {
  background-color: rgba(1,1,209, 0.7) !important
}
</style>
@endpush

@push('scripts')
<script>
$(function () {
  $("#batch_group_id").select2({
    theme: 'bootstrap4',
    placeholder: "Select Batch Group"
  });
});   
</script>
@endpush