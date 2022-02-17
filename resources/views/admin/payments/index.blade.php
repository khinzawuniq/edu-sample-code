@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Payments</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body">

        <div class="header-group w-100" style="display:inline-block;">
          <div class="float-left">
            <span class="font-weight-bold">Total : {{count($studentPayments)}} </span>
          </div>
          
          <div class="float-right">
            <div class="input-group">
              <form action="" method="get" class="filter-payment form-inline">
                <input type="text" class="form-control mr-2" placeholder="Search ..." id="searchDatatable">

                <select name="approve_status" id="approve_status" placeholder="Approve Status" class="form-control" style="width:130px;">
                  <option value="all" {{($status == 'all')? 'selected':''}} >All</option>
                  <option value="1" {{($status == "1")? 'selected':''}}>Approve</option>
                  <option value="0" {{($status == "0")? 'selected':''}}>Pending</option>
                </select>
              </form>
            </div>
          </div>
        </div>

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Course</th>
                      <th>Payment Method</th>
                      <th>Payment Description</th>
                      <th>Installment For</th>
                      <th>Slip Image</th>
                      <th>Approve Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = count($studentPayments)+1; ?>
                @foreach($studentPayments as $key => $payment)
                <tr>
                  <td align="center" data-column="SN">{{ --$i }}</td>
                  <td data-column="Name">
                    @if($payment->student_id != 0)
                      <a href="{{url('/admin/users/'.$payment->student_id)}}"> {{$payment->name}} </a>
                    @else
                      {{$payment->name}}
                    @endif
                  </td>
                  <td data-column="Email"> {{$payment->email}} </td>
                  <td data-column="Phone"> {{$payment->phone}} </td>
                  <td data-column="Class"> {{$payment->course->course_name}} </td>
                  <td data-column="Payment Method"> {{$payment->paymentType->bank_name}} </td>
                  <td data-column="Payment Description"> {{$payment->payType->pay_name}} </td>
                  <td data-column="Installment For"> {{$payment->installment_time}} </td>
                  <td>
                    @if(!empty($payment->payment_screenshot))
                    <a href="{{asset('/uploads/payment_slips/'.$payment->payment_screenshot)}}" data-toggle="lightbox" data-title="Payment Slip">
                    <img src="{{asset('/uploads/payment_slips/'.$payment->payment_screenshot)}}" alt="Payment Slip" width="50px">
                    </a>
                    @else
                    Empty Slip Image
                    @endif
                  </td>
                  <td> 
                    @if($payment->approve_status == 1)
                      <span class="text-success">Approved</span>
                    @else
                      <span class="text-warning">Pending</span>
                    @endif
                  </td>
                  <td style="width: 100px;" data-column="Action">

                    {{-- @if($payment->approve_status == 1)
                    <span class="mr-1 text-muted" title="approved"><i class="fas fa-user-check"></i></span>
                    @else
                    <a class="mr-1" href="#" title="approve" onClick="paymentApprove({{$payment->id}},'{{$payment->name}}')"><i class="fas fa-user-check"></i></a>
                    @endif --}}

                    <a class="payment-detail mr-2" href="{{ route('payments.show',$payment->id)}}" title="detail"><i class="fas fa-globe"></i></a>
                    {{-- <a class="mr-1" href="{{ route('payments.edit',$payment->id)}}"><i class="fa fa-edit text-warning"></i></a> --}}
                    
                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData" data-name="{{$payment->name}}">
                      <form action="{{ route('payments.destroy', $payment->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        <button type="submit"></button>
                      </form>
                    </i>
                    @endcan

                  </td>
                </tr>
                @endforeach
                
              </tbody>
          </table>
      </div>
  </div>
</section>
<!-- /.content -->

@endsection

@push('styles')
<style>
table.table tbody td {
  vertical-align: middle
}
#DataTables_Table_0_filter {
  display: none;
}
.payment-detail, .deleteData {
  font-size: 1.3rem;
}
</style>
@endpush

@push('scripts')
<script>
$(function () {

      var datatable = $('.datatable').DataTable({
				"bInfo" : false,
				"bLengthChange": false,
				"pageLength": 10,
				"ordering": false,
				"autoWidth": false,
				"language": {
					"oPaginate": {
						"sNext": "<i class='fas fa-angle-right'></i>",
						"sPrevious": "<i class='fas fa-angle-left'></i>"
					}
				},
			});

			$('.deleteData').on('click', function(){
          var name = $(this).attr('data-name');
                var result = confirm("Are you sure to delete "+name+" record?");
                if(result) {
                $(this).find('form').submit();
                }
			});

      $("#approve_status").on('change', function() {
        $(".filter-payment").submit();
      });
});

function paymentApprove(id, name)
{
  var result = confirm("Are you sure approve to "+name+" ?");

  if(result) {
    location.href = '/admin/payments/'+id+'/approve';
  }
  
}
      
</script>
@endpush