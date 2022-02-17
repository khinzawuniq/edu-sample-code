@extends('layouts.admin-app')
@push('styles')
<link rel="stylesheet" href="{{asset('assets/css/jquery.datetimepicker.css')}}">
@endpush
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Course</h1>
      </div>
    </div>
  </div>
</div>
<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
              Course Create
            </div>
        </div>
        <div class="card-body" >
            {!! Form::open(array('route' => 'courses.store','method'=>'POST', 'enctype'=>'multipart/form-data', 'files'=>true)) !!}
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="course_name">Course Name:</label>
                        {!! Form::text('course_name', null, ['placeholder' => 'Course Name','class' => 'form-control', 'required'=>true]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="course_code">Course Code:</label>
                        {!! Form::text('course_code', null, ['placeholder' => 'Course Code','class' => 'form-control', 'required'=>true]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="course_category_id">Course Category:</label>
                        {!! Form::select('course_category_id', $categories,null, array('class' => 'form-control', 'placeholder'=>'Select Course Category','required'=>true)) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-6">
                            <div class="form-group">
                                <label for="fees">Fees:</label>
                                {!! Form::text('fees', 0, ['placeholder' => 'Fees', 'id'=>'fees','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-6">
                            <div class="form-group">
                                <label for="fees_type">Currency</label>
                                {{ Form::select('fees_type', ['MMK'=>'MMK','USD'=>'USD'], null, ['class'=>'form-control','id'=>'fees_type', 'placeholder'=>'Fees Type']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <label for="image">Course Image</label>
                    <div class="form-group">
                        {{-- <input type="file" name="image" class="dropify" id="image" accept="image/*;capture=camera,.jpg,.jpeg,.png,.pdf" data-allowed-file-extensions="jpg jpeg png pdf"/> --}}
                        <div class="input-group">
                           <span class="input-group-btn">
                           <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                            <i class="far fa-image"></i> Choose
                           </a>
                           </span>
                           <input id="thumbnail" class="form-control" type="text" name="image">
                        </div>
                    </div>
                </div>
            </div>
           <!-- image -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        {!! Form::textarea('description', null, ['placeholder' => 'Description','class' => 'form-control psmeditor']) !!}
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="enable_enrol_no" class="mb-0">
                        {!! Form::checkbox('enable_enrol_no', 1, false,['id'=>'enable_enrol_no']) !!} Custom Enrol Number
                    </label>
                    </div>
                </div>
            </div>

            <div class="row enrol-no d-none">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="enrol_no"> Enrol Number:</label>
                        {!! Form::number('enrol_no', 0, ['placeholder' => 'Enrol Number', 'id'=>'enrol_no','class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="is_limited">
                            <input type="checkbox" name="is_limited" id="is_limited"> Time Limit
                        </label>
                    </div>
                </div>
            </div>
            <div class="dateGroup d-none">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="start_date">Start Date Time:</label>
                            {!! Form::text('start_date', null, ['placeholder' => 'Start Date','class' => 'form-control psmdatetimepicker1','autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="time_limit">Time limit</label>
                            <div class="d-flex">
                                <input type="number" style="width:40%;" min="0" name="time_limit" value="" placeholder="Time Limit" id="time_limit" class="form-control mr-2">
                                <select name="time_type" style="width:30%;" id="time_type" class="form-control">
                                    @foreach (config('time_type.type') as $timekey =>  $timetype)
                                        <option value="{{$timekey}}">{{$timetype}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="end_date">End Date Time:</label>
                            {!! Form::text('end_date', null, ['placeholder' => 'End Date','class' => 'form-control end_date_time', 'readonly'=>true, 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="is_active" class="mb-0">
                            {!! Form::checkbox('is_active', 0, false,['id'=>'is_active']) !!} Suspend ?
                        </label>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="/admin/category-course-management" class="btn btn-default"> Cancel </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{asset('assets/js/jquerydatetimepickerfull.js')}}"></script>
    <script>
        $(function(){
            $('.psmdatetimepicker1').datetimepicker();
            // $('.psmdatetimepicker2').datetimepicker();
        });
        $('.psmeditor').summernote({
            height: 200,
            width:'100%',
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
        ]
        });
        $('.psmdatetime').datetimepicker({
            inline:true
        });

        // $('#is_limited').click(function(){
        //     if($(this).prop('checked')){
        //         $('.dateGroup').removeClass('d-none');
        //         $('.psmdatetimepicker1').attr("required", true);
        //         $('.psmdatetimepicker2').attr("required", true);
        //         $('.psmdatetimepicker1').val("");
        //         $('.psmdatetimepicker2').val("");
        //     }else{
        //         $('.dateGroup').addClass('d-none');
        //         $('.psmdatetimepicker1').attr("required", false);
        //         $('.psmdatetimepicker2').attr("required", false);
        //     }
        // })
        
        $("#enable_enrol_no").click(function() {
            if($(this).prop('checked')) {
                $(".enrol-no").removeClass('d-none');
            }else {
                $(".enrol-no").addClass('d-none');
            }
        });

        $('#is_limited').click(function(){
            if($(this).prop('checked')){
                $('.dateGroup').removeClass('d-none');
                $('.psmdatetimepicker1').attr("required", true);
                $('.end_date_time').attr("required", true);
                $('#time_limit').attr("required", true);
                $('#time_type').attr("required", true);
                $('.psmdatetimepicker1').val("");
                $('.end_date_time').val("");
                $('#time_limit').val("");
            }else{
                $('.dateGroup').addClass('d-none');
                $('.psmdatetimepicker1').attr("required", false);
                $('.end_date_time').attr("required", false);
                $('#time_limit').attr("required", false);
                $('#time_type').attr("required", false);
                $('#time_limit').val("");
            }
        })

        $('#time_limit').on("input",function(){
            const start_date = $('.psmdatetimepicker1').val();
            const val = $(this).val();
            const type = $('#time_type option:selected').text();
            const timetype = $('#time_type').val();
            
            if(val && start_date && timetype != ''){
                $.ajax({
                    type:'get',
                    url:'/get-end-date',
                    data:{start_date:start_date,time_limit:val,time_type:type},
                    success:function(response){
                        $('.end_date_time').val(response.end_date);
                    }
                })
            }
        })
        $('#time_type').change(function(){
            const start_date = $('.psmdatetimepicker1').val();
            const val = $('#time_limit').val();
            const type = $('#time_type option:selected').text();
            console.log(type);
            if(val && start_date){
                $.ajax({
                    type:'get',
                    url:'/get-end-date',
                    data:{start_date:start_date,time_limit:val,time_type:type},
                    success:function(response){
                        $('.end_date_time').val(response.end_date);
                    }
                })
            }
        })

        $('#fees').keyup(function(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    </script>
@endpush