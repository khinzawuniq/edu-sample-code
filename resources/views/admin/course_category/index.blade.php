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
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Course Categories</h3>
      </div>
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Courses</h3>
      </div>
    </div>
  </div>
</div>

<div class="container">
<div class="row mt-2">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        @can('create')
        <div class="text-left mb-2">
          <a href="{{route('course_categories.create')}}" class="btn btn-success btn-sm btn-create"> New Course Category</a>
        </div>
        @endcan
        <table class="table table-striped table-hover datatable">
          <thead>
              <tr class="wfh-table-bg text-center">
               <th></th>
               <th>ID</th>
               <th>Name</th>
               <th>Parent Category</th>
               <th>Actions</th>
            </tr>
          </thead>
          <tbody id="sortable">
            @foreach($categories as $key => $category)
            <tr>
              <input type="hidden" name="category_order[]" value="{{$category->id}}">
              <th>
              <input type="checkbox" name="checkbox" onclick="checkToMoveCategory({{$category->id}})">
              </th>
              <td data-column="ID">#{{$key+1}}</td>
              <td data-column="Name">
                <span class="filter-courses" data-categoryname="{{$category->name}}" data-categoryid="{{$category->id}}"> 
                  {{$category->name}} 
                  <input type="hidden" name="filter_courses" id="filter_courses_{{$category->id}}">
                </span> 
              </td>
              <td data-column="Employee Name">{{$category->parent_id ? $category->parent->name : '-' }}</td>
              <td data-column="Actions">

                <a onclick="changeCategoryStatus({{$category->id}})"><span class="active-control text-primary" id="active-category-control{{$category->id}}"><i class="{{$category->is_active ? 'fa fa-eye' : 'fas fa-eye-slash text-muted'}}"></i></span></a>
                @can('edit')
                <a href="{{ route('course_categories.edit',$category->id)}}"><i class="fa fa-edit text-warning"></i></a>
                @endcan
                @can('delete')
                <i class="fa fa-trash text-danger deleteCategoryData">
                  <form action="{{ route('course_categories.destroy', $category->id) }}" method="post" style="display: none;" class="deleteCategoryDataForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit"></button>
                  </form>
                </i>
                @endcan
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <form action="/admin/move-categories" method="post">
          @csrf
        <div class="row mt-2">
          <div class="col-md-5">
              <label for="move_to">Move selected categories to</label>
              <input type="hidden" name="category_ids" id="category_ids" value="">
          </div>
          <div class="col-md-5">
             <select name="parent_id" id="" class="form-control" required>
                <option value="">Choose ...</option>
                @foreach ($categories as $cat)
             <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
             </select>
          </div>
          <div class="col-md-2">
              <button  disabled class="btn btn-sm btn-success w-100 btn-category-submit">Move</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
    
        <div class="card-body">
          <div class="header-action-wrapper float-left w-100 mb-2">
            <div class="float-left">
              @can('create')
              <a href="{{route('courses.create')}}" class="btn btn-success btn-sm btn-create"> New Course</a>
              @endcan
            </div>

            <div class="float-right">
              <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-filter"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" id="import_courses" data-toggle="modal" data-target="#courseImport">Import</a>
                  <a class="dropdown-item" href="#" id="export_courses">Export</a>
                  <form action="{{route('courses.export')}}" method="get" id="export_form" style="display:none;">
                    @csrf
                    <input type="hidden" name="course_category_id" id="course_category_id">
                    <input type="submit" value="Export">
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="table-wrapper float-left w-100">
            <table class="table table-striped table-hover datatablecourse">
              <thead>
                  <tr class="wfh-table-bg text-center">
                   <th></th>
                   <th>ID</th>
                   <th>Category</th>
                   <th>Name</th>
                   {{-- <th>Start Date</th>
                   <th>End Date</th> --}}
                   <th width="90px">Actions</th>
                </tr>
              </thead>
              <tbody id="coursesortable">
                @foreach($courses as $key => $course)
                <tr>
                  <input type="hidden" name="course_order[]" value="{{$course->id}}">
                  <th>
                    <input type="checkbox" name="checkbox" onclick="checkToMoveCourse({{$course->id}})">
                  </th>
                  <td data-column="ID">#{{$key+1}}</td>
                  <td data-column="Category">{{$course->category->name}}</td>
                  <td data-column="Name">{{$course->course_name}}</td>
                  {{-- <td data-column="Start Date">{{$course->start_date}}</td>
                  <td data-column="End Date">{{$course->end_date}}</td> --}}
                  <td data-column="Actions">
                    <a onclick="changeCourseStatus({{$course->id}})"><span class="active-control text-primary" id="active-course-control{{$course->id}}"><i class="{{$course->is_active ? 'fa fa-eye' : 'fas fa-eye-slash text-muted'}}"></i></span></a>
                    @can('edit')
                    <a href="{{ route('courses.edit',$course->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    @endcan
                    <a href="#" onclick="copyCourse({{$course->id}})" data-toggle="modal" data-target="#courseCopy"><i class="far fa-copy"></i></a>
                    @can('delete')
                    <i class="fa fa-trash text-danger deleteCourseData">
                      <form action="{{ route('courses.destroy', $course->id) }}" method="post" style="display: none;" class="deleteCourseDataForm">
                        @csrf
                        @method('DELETE')
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
          
          <form action="/admin/move-courses" method="post">
            @csrf
            <div class="row mt-2">
              <div class="col-md-5">
                  <label for="move_to">Move selected courses to...</label>
                  <input type="hidden" name="course_ids" id="course_ids" value="">
              </div>
              <div class="col-md-5">
                 <select name="category_id" id="" class="form-control" required>
                    <option value="">Choose ...</option>
                    @foreach ($categories as $cat)
                     <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                 </select>
              </div>
              <div class="col-md-2">
                  <button  disabled class="btn btn-sm btn-success w-100 btn-course-submit">Move</button>
              </div>
            </div>
            </form>
        </div>
      </div>
  </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="courseImport" tabindex="-1" role="dialog" aria-labelledby="courseImportLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseImportLabel">Courses Import</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        {!! Form::open(['route' => 'courses.import', 'method'=>'POST', 'enctype'=>'multipart/form-data', 'id'=>'import_form','files'=>true]) !!}
        
        <div class="form-group import-file">
          {!! Form::file('import_file', ['id' => 'import_file', 'class'=>'text-center']); !!}
        </div>
  
        <div class="form-group text-center">
          <a href="{{url('/assets/sample/sample_import_courses.xlsx')}}"> <i class="fas fa-download"></i> Download sample file </a>
        </div>
  
        <div class="form-group text-center">
          <p>
            You can import up to 1000 records through an .xls, .xlsx or .csv file.
            To import more than 1000 records at a time, use a .csv file.
          </p>
        </div>
        
        <div class="form-group">
          <button class="btn btn-block btn-primary">Import</button>
        </div>

        {!! Form::close() !!}
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="courseCopy" tabindex="-1" role="dialog" aria-labelledby="courseCopyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseImportLabel">Copy Course -<span class="course-name"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        {!! Form::open(array('route' => 'courses.copy_save','method'=>'POST', 'enctype'=>'multipart/form-data', 'files'=>true)) !!}
        
          <input type="hidden" name="copy_course" value="copy">
          <input type="hidden" name="old_course_id" id="old_course_id">

          <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    {!! Form::text('course_name', null, ['placeholder' => 'Course Name','id'=>'course_name','class' => 'form-control', 'required'=>true]) !!}
                </div>
            </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <div class="form-group">
                      <label for="course_category">Course Category:</label>
                      {!! Form::select('course_category_id', $copycategories,null, array('class' => 'form-control', 'id'=>'course_category', 'placeholder'=>'Select Course Category','required'=>true)) !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-12">
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
              <div class="col-12">
                  <label for="image">Course Image</label>
                  <div class="form-group">
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
              <div class="col-12">
                  <div class="form-group">
                      <label for="description">Description:</label>
                      {!! Form::textarea('description', null, ['placeholder' => 'Description','id'=>'description','class' => 'form-control psmeditor']) !!}
                  </div>
              </div>
          </div>
          
          <div class="row">
              <div class="col-12">
                  <div class="form-group">
                    <label for="enable_enrol_no" class="mb-0">
                      {!! Form::checkbox('enable_enrol_no', 1, false,['id'=>'enable_enrol_no']) !!} Custom Enrol Number
                  </label>
                  </div>
              </div>
          </div>

          <div class="row enrol-no d-none">
              <div class="col-12">
                  <div class="form-group">
                      <label for="enrol_no"> Enrol Number:</label>
                      {!! Form::number('enrol_no', 0, ['placeholder' => 'Enrol Number', 'id'=>'enrol_no','class' => 'form-control']) !!}
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <div class="form-group">
                      <label for="is_limited">
                          <input type="checkbox" name="is_limited" id="is_limited"> Time Limit
                      </label>
                  </div>
              </div>
          </div>
          <div class="dateGroup d-none">
              <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <label for="start_date">Start Date Time:</label>
                          {!! Form::text('start_date', null, ['placeholder' => 'Start Date','id'=>'start_date','class' => 'form-control psmdatetimepicker1','autocomplete' => 'off']) !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
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
                  <div class="col-12">
                      <div class="form-group">
                          <label for="end_date">End Date Time:</label>
                          {!! Form::text('end_date', null, ['placeholder' => 'End Date','id'=>'end_date','class' => 'form-control end_date_time', 'readonly'=>true, 'autocomplete' => 'off']) !!}
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="row">
              <div class="col-12">
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">Save</button>
                      <a href="#" class="btn btn-default" data-dismiss="modal" aria-label="Close"> Cancel </a>
                  </div>
              </div>
          </div>

        {!! Form::close() !!}
      </div>
      
    </div>
  </div>
</div>
{{-- End Modal --}}

@endsection

@push('scripts')
<script>
$(function () {

    $( "#sortable" ).sortable();
    $( "#coursesortable" ).sortable();
    $( "#sortable" ).disableSelection();
    $( "#coursesortable" ).disableSelection();

    $('#sortable').sortable({
    axis: 'y',
    update: function (event, ui) {
        let values = [];
        $("input[name='category_order[]']").each(function() {
            values.push($(this).val());
        });
        $.ajax({
            type:"get",
            url:"/save-category-order",
            data:{list:values},
            success:function(response){
                if (response.success) {
                    
                }
            }
        })
    }
});
    $('#coursesortable').sortable({
    axis: 'y',
    update: function (event, ui) {
        let values = [];
        $("input[name='course_order[]']").each(function() {
            values.push($(this).val());
        });
        $.ajax({
            type:"get",
            url:"/save-course-order",
            data:{list:values},
            success:function(response){
                if (response.success) {
                    
                }
            }
        })
    }
});



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
      var datatableCourse = $('.datatablecourse').DataTable({
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

      $(".filter-courses").on('click', function() {
        var cat_name  = $(this).attr('data-categoryname');
        var cat_id    = $(this).attr('data-categoryid');
        $("#course_category_id").val(cat_id);
        datatableCourse
            .column( 2 )
            .search( cat_name )
            .draw();
      });

      $("#export_courses").on('click', function() {
        $("#export_form").submit();
      });
});

      $('.psmeditor').summernote({
            height: 200,
            width:'100%',
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
        ]
      });

      var checkList = [];
      var checkCourseList = [];
      $('.deleteCategoryData').on('click', function(){
        var result = confirm("Confirm delete record?");
        if(result) {
          $(this).find('.deleteCategoryDataForm').submit();
        }
			});
			$('.deleteCourseData').on('click', function(){
        var result = confirm("Confirm delete record?");
        if(result) {
          $(this).find('.deleteCourseDataForm').submit();
        }
			});

      function changeCategoryStatus(id){
        $.ajax({
          url:`category-active/${id}`,
          type:'GET',
          success: function(response){
            if (response.code == 200) {
              const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
              const activeHtml = "<i class='fa fa-eye'></i>";
              $('#active-category-control'+id).html("");
              if(response.status){
                $('#active-category-control'+id).html(activeHtml);
              }else{
                $('#active-category-control'+id).html(inactiveHtml);
              }
              // alert(response.message);
            }
          }
        })
      }
      function changeCourseStatus(id){
        $.ajax({
          url:`course-active/${id}`,
          type:'GET',
          success: function(response){
            if (response.code == 200) {
              const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
              const activeHtml = "<i class='fa fa-eye'></i>";
              $('#active-course-control'+id).html("");
              if(response.status){
                $('#active-course-control'+id).html(activeHtml);
              }else{
                $('#active-course-control'+id).html(inactiveHtml);
              }
              // alert(response.message);
             
            }
          }
        })
      }

      function checkToMoveCategory(id){
         const findIndex = checkList.findIndex(function (element) { 
              return element == id;
          }); 
          if (findIndex >= 0) {
            checkList.splice(findIndex,1);
          }else{
            checkList.push(id);
          }

          if (checkList.length > 0) {
            $('.btn-category-submit').removeAttr("disabled");
            $('#category_ids').val(JSON.stringify(checkList));
          }else{
            $('.btn-category-submit').attr("disabled", true);
          }
      }

      function checkToMoveCourse(id){
         const findIndex = checkCourseList.findIndex(function (element) { 
              return element == id;
          }); 
          if (findIndex >= 0) {
            checkCourseList.splice(findIndex,1);
          }else{
            checkCourseList.push(id);
          }

          if (checkCourseList.length > 0) {
            $('.btn-course-submit').removeAttr("disabled");
            $('#course_ids').val(JSON.stringify(checkCourseList));
          }else{
            $('.btn-course-submit').attr("disabled", true);
          }
      }

      function copyCourse(id) {
        $.ajax({
          url:`/admin/courses/copy/${id}`,
          type:'GET',
          success: function(response){
            $("#old_course_id").val(response.id);
            $(".course-name").text(response.course_name);
            $("#course_name").focus();
            $("#course_category").val(response.course_category_id);
            $("#fees").val(response.fees);
            $("#fees_type").val(response.fees_type);
            $("#thumbnail").val(response.image);
            $("#description").summernote("code", response.description);

            if(response.enable_enrol_no == 1) {
              $("#enable_enrol_no").prop('checked',true);
              $(".enrol-no").removeClass('d-none');
            }
            if(response.start_date != null) {
              $("#is_limited").prop('checked', true);
              $(".dateGroup").removeClass('d-none');
            }

            $("#enrol_no").val(response.enrol_no);
            $("#start_date").val(response.start_date);
            $("#time_limit").val(response.time_limit);
            $("#time_type").val(response.time_type);
            $("#end_date").val(response.end_date);
          }
        })
      }

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