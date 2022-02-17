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
            @can('create')
            <a href="{{route('users.create')}}" class="btn btn-success btn-create"> New User</a>
            @endcan
          </div>
          
          <div class="float-right">
            <div class="input-group">
              <form action="" method="get" class="filter-user form-inline">
                <input type="text" class="form-control mr-2" placeholder="Search ..." id="searchDatatable">
                {!! Form::select('course', $courses, ($course)?$course:null, ['class'=>'form-control mr-2', 'id'=>'course', 'placeholder'=>'Select Course','style'=>'width:250px;']) !!}
                {!! Form::select('role', $roles, ($role)?$role:null, ['class'=>'form-control mr-2', 'id'=>'role', 'placeholder'=>'Select Role','style'=>'width:200px;']) !!}
              </form>
              <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-filter"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" id="import_users" data-toggle="modal" data-target="#userImport">Import</a>
                  <a class="dropdown-item" href="{{url('/admin/users/export/data?course='.$course.'&role='.$role)}}" id="export_user">Export</a>
                </div>
              </div>
            </div>
          </div>
        </div>
          <table class="table table-striped table-hover datatable w-100">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Web Device</th>
                      <th>Mobile Device</th>
                      <th width="15%">Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($users as $key => $user)
                <tr class="row-{{$user->id}}">
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Name">{{ $user->name }}</td>
                  <td data-column="Email">{{ $user->email }}</td>
                  <td data-column="Role">
                    @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                        {{ $v }}
                      @endforeach
                    @endif
                  </td>

                  <td data-column="Web Device" class="device-info">
                    @php
                    $last_seen = ($user->last_seen)? Carbon\Carbon::parse($user->last_seen)->diffForHumans():'';
                    @endphp
                    {{($user->platform_web)?$user->platform_web.' ,':''}} {{($user->device_name_web)? $user->device_name_web.' ,':''}} {{($user->location)?$user->location:''}} <br>
                    {{($user->browser)?$user->browser.' ,':''}} {{ (Cache::has('user-is-online-' . $user->id))? 'Active now': $last_seen }}
                  </td>
                   <td data-column="Mobile Device" class="mobile-info">
                      {{$user->mobile_device}}
                   </td>

                  <td align="center" data-column="Action" class="action-wrapper-{{$user->id}}">
                    
                    <a href="{{route('users.courses', $user->id)}}" class="mr-1" title="Enrol Courses"><i class="fas fa-book"></i></a>

                    @if($user->is_active == true)
                      <a href="#" onClick="inactive({{$user->id}})" id="inactive_{{$user->id}}"><i class="fa fa-eye"></i></a>
                    @else
                      <a href="#" onClick="active({{$user->id}})" id="active_{{$user->id}}"><i class="fas fa-eye-slash text-muted"></i></a>
                    @endif

                    <a href="#" class="reset-device ml-1" onClick="resetDevice({{$user->id}},'web')"><i class="fa fa-desktop" aria-hidden="true"></i></a>
                    <a href="#" class="reset-device ml-1" onClick="resetDevice({{$user->id}},'mobile')"><i class="fa fa-mobile" aria-hidden="true"></i></a>
                    <input type="hidden" value="{{$user->mobile_id}}">
                    
                    @can('edit')
                    <a href="{{ route('users.edit',$user->id)}}" class="ml-1"><i class="fa fa-edit text-warning"></i></a>
                    @endcan

                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData ml-1" onClick="deleteUser({{$user->id}})">
                      <form id="user_form_{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="post" style="display: none;" class="deleteDataForm">
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

			// $('.deleteData').on('click', function(){
      //   var result = confirm("Confirm delete record?");
      //   if(result) {
      //     $(this).find('form').submit();
      //   }
			// });

      $("#role").select2({
        theme: 'bootstrap4',
        placeholder: "Select Role"
      });
      $("#course").select2({
        theme: 'bootstrap4',
        placeholder: "Select Course"
      });

      $('#searchDatatable').on('keyup', function () {
			    datatable.search(this.value).draw();
			});

      $("#role").on('change', function() {
        $(".filter-user").submit();
      });
      $("#course").on('change', function() {
        $(".filter-user").submit();
      });
});

  function deleteUser(id)
  {
    var result = confirm("Confirm delete record?");
    if(result) {
      $("#user_form_"+id).submit();
    }
  }

      function inactive(id)
      {
        $.ajax({
          url: '/admin/users/inactive/'+id,
          type: 'get',
          success: function (data) {
            console.log(data);
              if(data.code == 200) {
                $("#inactive_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="active('+id+')" id="active_'+id+'"><i class="fas fa-eye-slash text-muted"></i></a>');
              }
          }
        });
      }
      
      function active(id)
      {
        $.ajax({
          url: '/admin/users/active/'+id,
          type: 'get',
          success: function (data) {
            console.log(data);
            if(data.code == 200) {
                $("#active_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="inactive('+id+')" id="inactive_'+id+'"><i class="fa fa-eye"></i></a>');
            }
          }
        });
      }

      function resetDevice(id,type)
      {
        var result = confirm("Are you sure reset "+type+" device?");

        if(result) {
          $.ajax({
            url: '/admin/users/reset_web_device/'+id+"?type="+type,
            type: 'get',
            success: function (data) {
              
              if(data.code == 200) {
                console.log("Successful reset device!");
                if(type == "web"){
                  $(".row-"+id+" .device-info").text('-');
                }else{
                  $(".row-"+id+" .mobile-info").text('-');
                }
                
              }else {
                alert("Cannot reset device!");
              }
            }
          });
        }
      }

</script>
@endpush