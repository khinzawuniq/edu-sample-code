@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Knowledge Blogs</h3>
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
            <a href="{{route('knowledge-blogs.create')}}" class="btn btn-success btn-create"> New Knowledge Blog</a>
            @endcan
          </div>
        </div>

          <table class="table table-striped table-hover datatable w-100">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Image</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($blogs as $blog)
                <tr class="row-{{$blog->id}}">
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Title">{{ $blog->title }}</td>
                  <td data-column="Description">{!! Str::limit($blog->description, 80, $end='.....') !!}</td>
                  <td data-column="Image"> <img src="{{ $blog->image? $blog->image : asset('/assets/images/default_square.png') }}" alt="Knowledge Blog Image" style="width:50px;"> </td>

                  <td align="center" data-column="Action" class="action-wrapper-{{$blog->id}}">
                    @if($blog->is_active == true)
                      <a href="#" onClick="inactive({{$blog->id}})" id="inactive_{{$blog->id}}"><i class="fa fa-eye"></i></a>
                    @else
                      <a href="#" onClick="active({{$blog->id}})" id="active_{{$blog->id}}"><i class="fas fa-eye-slash text-muted"></i></a>
                    @endif
                    
                    @can('edit')
                    <a href="{{ route('knowledge-blogs.edit',$blog->id)}}" class="ml-1"><i class="fa fa-edit text-warning"></i></a>
                    @endcan

                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData ml-1" onClick="deleteBlogs({{$blog->id}})">
                      <form id="blog_form_{{$blog->id}}" action="{{ route('knowledge-blogs.destroy', $blog->id) }}" method="post" style="display: none;" class="deleteDataForm">
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

</section>
<!-- /.content -->

@endsection

@push('styles')
<style>
#DataTables_Table_0_filter {
  display: none;
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
        //     var result = confirm("Confirm delete record?");
        //     if(result) {
        //     $(this).find('form').submit();
        //     }
		// });

});

    function deleteBlogs(id)
    {
        var result = confirm("Confirm delete record?");
        if(result) {
          $("#blog_form_"+id).submit();
        }
    }

      function inactive(id)
      {
        $.ajax({
          url: '/admin/knowledge-blogs/inactive/'+id,
          type: 'get',
          success: function (data) {
            
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
          url: '/admin/knowledge-blogs/active/'+id,
          type: 'get',
          success: function (data) {
            
            if(data.code == 200) {
                $("#active_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="inactive('+id+')" id="inactive_'+id+'"><i class="fa fa-eye"></i></a>');
            }
          }
        });
      }

</script>
@endpush