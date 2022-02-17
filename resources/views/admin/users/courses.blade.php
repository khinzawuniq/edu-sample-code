@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Users</h3>
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
                <h4> {{$user->name}} </h4>
            </div>

            <div class="float-right">
                <div class="input-group">
                <form action="" method="get" class="filter-user form-inline">
                    <input type="text" class="form-control mr-2" placeholder="Search ..." id="searchDatatable">
                    {!! Form::select('course', $courses, ($course)?$course:null, ['class'=>'form-control mr-2', 'id'=>'course', 'placeholder'=>'Select Course','style'=>'width:250px;']) !!}
                </form>
                </div>
            </div>
        </div>
          <table class="table table-striped table-hover datatable w-100">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Course</th>
                      <th>Serial No.</th>
                      <th>Start Activity</th>
                      <th>Last Activity</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($enrolcourses as $key => $enrol)
                <tr class="row-{{$enrol->id}}">
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Course">{{ $enrol->course->course_name }}</td>
                  <td data-column="Serial No.">{{ $enrol->serial_no }}</td>
                  <td data-column="Start Activity">{{ $enrol->start_activity ? date('d/m/Y H:i:s', strtotime($enrol->start_activity)) : '-' }}</td>
                  <td data-column="Last Activity">{{ $enrol->last_activity ? date('d/m/Y H:i:s', strtotime($enrol->last_activity)) : '-' }}</td>
                </tr>
                @endforeach
                
              </tbody>
          </table>
      </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="userImport" tabindex="-1" role="dialog" aria-labelledby="userImportLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userImportLabel">Users Import</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        {!! Form::open(['route' => 'users.import', 'method'=>'POST', 'enctype'=>'multipart/form-data', 'id'=>'import_form','files'=>true]) !!}
        
        <div class="form-group import-file">
          {!! Form::file('import_file', ['id' => 'import_file', 'class'=>'text-center']); !!}
        </div>
  
        <div class="form-group text-center">
          <a href="{{url('/assets/sample/sample_import_users.xlsx')}}"> <i class="fas fa-download"></i> Download sample file </a>
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
{{-- End Modal --}}
</section>
<!-- /.content -->

@endsection

@push('styles')
<style>
#DataTables_Table_0_filter {
  display: none;
}
.select2 {
  margin-right: 10px;
}
</style>
@endpush

@push('scripts')
<script>
$(function () {

      var datatable = $('.datatable').DataTable({
				"bInfo" : false,
				"bLengthChange": false,
				"paging":   false,
				"ordering": false,
				"autoWidth": false,
				
			});

      $("#course").select2({
        theme: 'bootstrap4',
        placeholder: "Select Course"
      });

      $('#searchDatatable').on('keyup', function () {
			    datatable.search(this.value).draw();
		});

      $("#course").on('change', function() {
        $(".filter-user").submit();
      });
});

</script>
@endpush