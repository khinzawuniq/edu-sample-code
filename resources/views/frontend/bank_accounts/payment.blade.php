@extends('layouts.app')

@section('title'){!! "Payments -" !!} @stop

@push('styles')
<style>
    .btn-copy {
        border: none;
        background: none;
        box-shadow: none;
    }
    /* .btn-copy:focus, .btn-copy:active {
        outline: none;
    } */
    .row-price {
        border-bottom: 2px solid #ccc;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .img-wrapper {
        border: 2px solid #ccc;
        padding: 5px;
        border-radius: 10px;
        background: url('/assets/images/bank-logo-bg.jpg') no-repeat center;
        height: 80px;
        width: 90px;
        position: relative;
    }
    .img-wrapper img {
        margin: 0 auto;
        left: 0;
        right: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }
    .copy-guide p {
        color: #0101d1;
    }
    .additional-note {
        color: #0101d1;
    }
    .btn-payment-upload {
        background-color: #021f63;
    }
    .dropify-wrapper {
        height: 100px;
        width: 300px;
        margin: 0 auto;
        background: #021f63;
        color: #fff;
        line-height: 1.8;
    }
    .dropify-wrapper .file-icon {
        display: none;
    }
    .dropify-wrapper .dropify-message i {
        font-size: 1.2rem;
    }
    .bg-psm {
        background-color: #021f63;
    }
    #successModal .modal-dialog {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #successModal .modal-body {
        width: 300px;
    }
    .toast-top-center {
        top: 50%;
        transform: translate(0, -50%);
    }
</style>
@endpush
@section('content')

<div class="container payment-page py-4">

    @can('create')
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addBankAccount">Add New</button>
        </div>
    </div>
    @endcan

    @foreach($bankAccounts as $bank)
    <div class="row row-price row-{{$bank->id}}">
        <div class="col-4 col-sm-2">
            <div class="img-wrapper text-center">
                <img src="{{asset($bank->bank_logo)}}" alt="PSM Payment" width="75px">
            </div>
        </div>
        <div class="col-8 col-sm-7">
            <div class="bank-name"> {{$bank->bank_name}} </div>
            <div class="bank-account"> {{$bank->bank_account}} </div>
            @if($bank->bank_user)
            <div class="bank-user"> {{$bank->bank_user}} </div>
            @endif
            @if($bank->additional_note)
            <div class="additional-note"> {{$bank->additional_note}} </div>
            @endif
        </div>
        <div class="col-12 col-sm-3 pt-4 text-right">

            <button class="btn-copy"> <img onClick="copyAccount('{{$bank->bank_account}}')" src="{{asset('/assets/images/copybankaccount.jpg')}}" alt="Copy Bank Account" width="30px"> </button>
            @can('edit')
            <button class="btn btn-warning btn-sm" onClick="editBank({{$bank->id}})"><i class="fas fa-pencil-alt"></i></button>
            @endcan
            @can('delete')
            <button class="btn btn-danger btn-sm" onClick="deleteBank({{$bank->id}}, '{{$bank->bank_name}}')"><i class="fas fa-times"></i></button>
            @endcan
        </div>
    </div>
    @endforeach

    @if(count($bankAccounts) == 0)
        <h3 class="text-center">Empty Bank Account</h3>
    @endif

    <div class="copy-guide text-center">
        <p> ဒီ <img onClick="copyAccount('{{$bank->bank_account}}')" src="{{asset('/assets/images/copybankaccount.jpg')}}" alt="Copy Bank Account" width="30px"> ခလုပ်လေးကိုနှိပ်ပြီး ဘဏ်နံပါတ်ကို ကူးယူနိုင်ပါသည်။ </p>
    </div>

    <form action="#">
    <div class="row mt-5 mb-4">
        <div class="col-12 text-center">
            <div class="form-group">
                <input type="file" name="screenshot" id="screenshot" accept="image/*;capture=camera" data-allowed-file-extensions="jpg jpeg png"/>
            </div>
        </div>
    </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="form-group text-center">
                <button class="btn btn-primary btn-payment-upload" id="payment_upload" style="width:120px;" >Continue</button>
                {{-- <button class="btn btn-primary btn-payment-upload" id="payment_upload" style="width:120px;" data-toggle="modal" data-target="#paymentUploadModal">Continue</button> --}}
            </div>
        </div>
    </div>

    @if(Auth::check())
    @if(!auth()->user()->hasRole(['Student','Teacher']))
    <hr>

    <div class="row mt-5">
        <div class="col-sm-8 col-12">
            <div class="card">
                <div class="card-header bg-psm">
                    <h4 class="text-center text-white">Payment Description</h4>
                </div>
                <div class="card-body">
                    <div class="add-description-wrapper text-right">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPayTypeModal">Add New</button>
                    </div>
                    <table class="table">
                        <tbody>
                            @foreach($pay_types as $key=>$pay)
                            <tr class="pay-row-{{$pay->id}}">
                                <td> {{$key+1}} </td>
                                <td> {{$pay->pay_name}} </td>
                                <td class="text-right">
                                    @can('edit')
                                        <button class="btn btn-warning btn-sm" onClick="editPay({{$pay->id}})"><i class="fas fa-pencil-alt"></i></button>
                                    @endcan
                                    @can('delete')
                                        <button class="btn btn-danger btn-sm" onClick="deletePay({{$pay->id}}, '{{$pay->pay_name}}')"><i class="fas fa-times"></i></button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
        
                            @if(count($pay_types) == 0) 
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Empty Payment Description
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            
        </div>
    </div>
    @endif
    @endif

</div>

<!-- Modal -->
<div class="modal fade" id="addBankAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Bank Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {!! Form::open(array('route' => 'frontend.payments.store','method'=>'POST', 'enctype'=>'multipart/form-data', 'files'=>true)) !!}

            <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bank_account">Bank Account *</label>
                <input type="text" name="bank_account" id="bank_account" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bank_user">Bank User</label>
                <input type="text" name="bank_user" id="bank_user" class="form-control">
            </div>
            <div class="form-group">
                <label for="additional_note">Additional Note</label>
                <input type="text" name="additional_note" id="additional_note" class="form-control">
            </div>
            <div class="form-group">
                <label for="bank_logo">Bank Logo *</label>
                <div class="input-group">
                    <span class="input-group-btn">
                    <a id="lfm" data-input="bank_logo" data-preview="holder" class="btn btn-primary text-white">
                     <i class="far fa-image"></i> Choose
                    </a>
                    </span>
                    <input id="bank_logo" class="form-control" type="text" name="bank_logo" required>
                </div>
            </div>

            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>

            {!! Form::close() !!}
          </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="editBankAccount" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Bank Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="dataSubmitForm" action="{{url('/payments/update')}}" method="post" id="editFrom">
            {{csrf_field()}}

            <input type="hidden" name="bank_id" id="edit_bank_id">
            <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" name="bank_name" id="edit_bank_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bank_account">Bank Account *</label>
                <input type="text" name="bank_account" id="edit_bank_account" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bank_user">Bank User</label>
                <input type="text" name="bank_user" id="edit_bank_user" class="form-control">
            </div>
            <div class="form-group">
                <label for="additional_note">Additional Note</label>
                <input type="text" name="additional_note" id="edit_additional_note" class="form-control">
            </div>
            <div class="form-group">
                <label for="bank_logo">Bank Logo *</label>
                <div class="input-group">
                    <span class="input-group-btn">
                    <a id="edit_lfm" data-input="edit_bank_logo" data-preview="holder" class="btn btn-primary text-white">
                     <i class="far fa-image"></i> Choose
                    </a>
                    </span>
                    <input id="edit_bank_logo" class="form-control" type="text" name="bank_logo" required>
                </div>
            </div>

            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>

            </form>
          </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="paymentUploadModal" role="dialog" aria-labelledby="paymentUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentUploadModalLabel">Payment Slip Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {!! Form::open(array('route' => 'frontend.payments.payment_upload','method'=>'POST', 'id'=>'payment_upload_form','enctype'=>'multipart/form-data', 'files'=>true)) !!}

            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" value="{{($user != '')? $user->name:''}}" placeholder="Name *" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" id="phone" class="form-control" value="{{($user != '')? $user->phone:''}}" placeholder="Phone *" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" value="{{($user != '')? $user->email:''}}" placeholder="Email *" required>
            </div>
            <div class="form-group">
                {!! Form::select('course_id', $courses, (!empty($course_id))?$course_id:old('course_id'), array('placeholder' => 'Course *','class' => 'form-control', 'id'=>'course_id','required'=>true)) !!}
            </div>
            
            <div class="form-group">
                {!! Form::select('payment_type', $banks, old('payment_type'), array('placeholder' => 'Payment Method *','class' => 'form-control', 'id'=>'payment_type','required'=>true)) !!}
            </div>
            
            <div class="form-group">
                {!! Form::select('payment_description', $pays, old('payment_description'), array('placeholder' => 'Payment Description *','class' => 'form-control', 'id'=>'payment_description','required'=>true)) !!}
            </div>

            <div class="form-group installment-time-group d-none">
                <input type="text" name="installment_time" id="installment_time" class="form-control" placeholder="Installment for (1st, 2nd installment, etc.) *">
            </div>
            
            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-payment-upload" id="slip_upload_btn" >Finish</button>
                {{-- <button type="submit" class="btn btn-primary btn-payment-upload" id="slip_upload_btn" data-dismiss="modal">Finish</button> --}}
            </div>
            
            {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>


{{-- Payment Description --}}
<div class="modal fade" id="addPayTypeModal" tabindex="-1" role="dialog" aria-labelledby="addPayTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPayTypeModalLabel">Add New Payment Description</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {!! Form::open(array('route' => 'payment_descriptions.store','method'=>'POST')) !!}

            <div class="form-group">
                <label for="pay_name">Pay Name *</label>
                <input type="text" name="pay_name" id="pay_name" class="form-control" required>
            </div>

            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>

            {!! Form::close() !!}
          </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="editPayTypeModal" tabindex="-1" role="dialog" aria-labelledby="editPayTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPayTypeModalLabel">Edit Payment Description</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="dataSubmitForm" action="{{url('/payment_descriptions/update')}}" method="post" id="editPayFrom">
            {{csrf_field()}}
            <input type="hidden" name="pay_id" id="edit_pay_id">

            <div class="form-group">
                <label for="edit_pay_name">Pay Name *</label>
                <input type="text" name="pay_name" id="edit_pay_name" class="form-control" required>
            </div>

            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>

            </form>
          </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <p class="mb-4">
            We received your payment slip. <br> We will contact you soon.
          </p>

          <button type="button" class="btn btn-secondary btn-sm" id="close_success_box" data-dismiss="modal" style="width:60px;">OK</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<script>
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "1500",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

$('#lfm').filemanager('file');
$('#edit_lfm').filemanager('file');

$('#screenshot').dropify({
    messages: {
        'default': 'ငွေလွှဲ Slip/Screenshot ပုံထည့်ရန် <br> ဒီနေရာကို နှိပ်ပေးပါ။ <br> <span><i class="fas fa-cloud-upload-alt"></i></span>',
        'replace': 'Your file here',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }    
});

$("#course_id").select2({
    theme: 'bootstrap4',
    placeholder: "Course *"
});
$("#payment_type").select2({
    theme: 'bootstrap4',
    placeholder: "Payment Method *"
});
$("#payment_description").select2({
    theme: 'bootstrap4',
    placeholder: "Payment Description *"
});

$("#payment_upload").click(function() {
    var uploadForm = $(this);
    var slipImage = $("#screenshot").val();
    
    if(slipImage) {
        $(uploadForm).attr('data-toggle','modal');
        $(uploadForm).attr('data-target','#paymentUploadModal');
    }else {
        $(uploadForm).removeAttr('data-toggle','modal');
        $(uploadForm).removeAttr('data-target','#paymentUploadModal');
        alert('Please select your slip screenshot image!');
    }
});

function copyAccount(bankAccount)
{
    // if (window.isSecureContext) {
        navigator.clipboard.writeText(bankAccount).then(function() {
            // console.log(bankAccount);
            toastr.success('Copied to clipboard!');

        }, function(e) {
            console.log(e);
        });
    // }
    
}

function editBank(id)
{
    $.ajax({
        type:'get',
        url:'payments/edit/'+id,
        success:function(response){
            $("#edit_bank_id").val(response.id);
            $("#edit_bank_name").val(response.bank_name);
            $("#edit_bank_account").val(response.bank_account);
            $("#edit_bank_user").val(response.bank_user);
            $("#edit_additional_note").val(response.additional_note);
            $("#edit_bank_logo").val(response.bank_logo);
            jQuery.noConflict();
            $('#editBankAccount').modal('show');
        }
    });
}

function deleteBank(id, name) {

    var data = {
        id : id,
        _token : '{{csrf_token()}}'
    };

    var deleteBank = confirm("Are you sure to "+name+" delete?");

    if(deleteBank) {
        $.post('{{url("payments/delete")}}', data, (result)=>{

            // console.log(result);
            $('.row-'+id).remove();

        }).catch((err)=>{
            console.log(err);
            $.alert('Warning! Invalid request.');       
        });
    }
}

function editPay(id)
{
    $.ajax({
        type:'get',
        url:'payment_descriptions/edit/'+id,
        success:function(response){
            $("#edit_pay_id").val(response.id);
            $("#edit_pay_name").val(response.pay_name);
            jQuery.noConflict();
            $('#editPayTypeModal').modal('show');
        }
    });
}

function deletePay(id, name) {

    var data = {
        id : id,
        _token : '{{csrf_token()}}'
    };

    var deletePayName = confirm("Are you sure to "+name+" delete?");

    if(deletePayName) {
        $.post('{{url("payment_descriptions/delete")}}', data, (result)=>{

            // console.log(result);
            $('.pay-row-'+id).remove();

        }).catch((err)=>{
            console.log(err);
            $.alert('Warning! Invalid request.');       
        });
    }
}

var passData = false;

$("#slip_upload_btn").click(function() {

    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var course_id = $("#course_id").val();
    var payment_type = $("#payment_type").val();
    var payment_description = $("#payment_description").val();
    if(name == '' || email=='' || phone=='' || course_id=='' || payment_type=='' || payment_description=='') {
        passData = false;
        console.log('false');
    }else {
        passData = true;
        console.log('true');
    }
});

$("#payment_upload_form").submit(function(e) {
    e.preventDefault();
    jQuery.noConflict();
    $("#paymentUploadModal").modal('hide');

        let formData = new FormData(this);
    
        if ($('#screenshot')[0].files.length > 0) {
            for (var i = 0; i < $('#screenshot')[0].files.length; i++)
            formData.append('payment_screenshot', $('#screenshot')[0].files[i]);
        }

        $.ajax({
            type:'POST',
            url: "{{route('frontend.payments.payment_upload')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                console.log(response);
                if (response) {
                    this.reset();
                    // alert('We received your payment slip.\n We will contact you soon.');
                    $(".dropify-clear").trigger("click");
                    $("#successModal").modal('show');
                }
            },
                error: function(response){
                alert('Error! '+response.responseJSON.errors);
                $(".dropify-clear").trigger("click");
            }
        });

});

$("#close_success_box").click(function() {
    location.href = "{{url('/courses')}}";
});

$("#payment_description").on("change", function() {
    var pay_id = $(this).val();

    $.ajax({
        type:'get',
        url:'payment_descriptions/edit/'+pay_id,
        success:function(response){
            if(response.pay_name == "Installment") {
                // console.log(response);
                $(".installment-time-group").removeClass("d-none");
                $("#installment_time").attr("required",true);
            }else {
                $(".installment-time-group").addClass("d-none");
                $("#installment_time").val('');
                $("#installment_time").removeAttr("required");
            }
        }
    });
});
</script>
@endpush