@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Gradings</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-header">
          <div class="card-title">
            Grading Create
          </div>
      </div>
      <div class="card-body" >
        {!! Form::open(array('route' => 'gradings.store','method'=>'POST')) !!}

        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="awarding_body">Awarding Body *</label>
              {!! Form::text('awarding_body', null, ['class'=>'form-control','id'=>'awarding_body', 'placeholder'=>'Awarding Body', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
        </div>
        
        <div class="row">
          {{-- <div class="col-md-6 col-sm-6 col-6">
            <div class="form-group">
              <label for="number_grading">Number of Grading *</label>
              {!! Form::number('number_grading', null, ['class'=>'form-control','id'=>'number_grading', 'placeholder'=>'Number of Grading', 'required'=>true]) !!}
            </div>
          </div> --}}
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="passing_mark">Passing Mark *</label>
              {!! Form::text('passing_mark', null, ['class'=>'form-control','id'=>'passing_mark', 'placeholder'=>'Passing Mark', 'required'=>true]) !!}
            </div>    
          </div>
        </div>
        
        <div class="multi-wrapper">
          <input type="hidden" name="count_row" id="count_row">

          <div class="row row_1">
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                <label for="grading_from_1">From</label>
                {!! Form::number('grading_from[]', null, ['class'=>'form-control','id'=>'grading_from_1', 'placeholder'=>'Grading From', 'required'=>true]) !!}
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                <label for="grading_to_1">To</label>
                {!! Form::number('grading_to[]', null, ['class'=>'form-control','id'=>'grading_to_1', 'placeholder'=>'Grading To', 'required'=>true]) !!}
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
              <div class="form-group">
                <label for="grading_description_1">Description</label>
                {!! Form::text('grading_description[]', null, ['class'=>'form-control','id'=>'grading_description_1', 'placeholder'=>'Grading Description', 'required'=>true]) !!}
              </div>
            </div>
          </div>
          
          <div class="row row_2">
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_from[]', null, ['class'=>'form-control','id'=>'grading_from_2', 'placeholder'=>'Grading From']) !!}
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_to[]', null, ['class'=>'form-control','id'=>'grading_to_2', 'placeholder'=>'Grading To']) !!}
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
              <div class="form-group">
                
                {!! Form::text('grading_description[]', null, ['class'=>'form-control','id'=>'grading_description_2', 'placeholder'=>'Grading Description']) !!}
              </div>
            </div>
          </div>
          
          <div class="row row_3">
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_from[]', null, ['class'=>'form-control','id'=>'grading_from_3', 'placeholder'=>'Grading From']) !!}
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_to[]', null, ['class'=>'form-control','id'=>'grading_to_3', 'placeholder'=>'Grading To']) !!}
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
              <div class="form-group">
                
                {!! Form::text('grading_description[]', null, ['class'=>'form-control','id'=>'grading_description_3', 'placeholder'=>'Grading Description']) !!}
              </div>
            </div>
          </div>
          
          <div class="row row_4">
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_from[]', null, ['class'=>'form-control','id'=>'grading_from_4', 'placeholder'=>'Grading From']) !!}
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                
                {!! Form::number('grading_to[]', null, ['class'=>'form-control','id'=>'grading_to_4', 'placeholder'=>'Grading To']) !!}
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
              <div class="form-group">
                
                {!! Form::text('grading_description[]', null, ['class'=>'form-control','id'=>'grading_description_4', 'placeholder'=>'Grading Description', 'autocomplate'=>'off']) !!}
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-success btn-sm" id="add_row" onClick="addRow()">Add Row</button>
        </div>
        
        <div class="form-group mt-3 text-right">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            <a href="{{route('gradings.index')}}" class="btn btn-default"> Cancel </a>
        </div>

        {!! Form::close() !!}
      </div>
  </div>

</section>
<!-- /.content -->

@endsection

@push('styles')
<style>

</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() { 

});

    var countAdditional = 1;
    var countRow = 0;

    function addRow()
    {
        countRow = countAdditional + 4;
        $('#count_row').val(countRow);
        countAdditional++;

        $(".multi-wrapper").append(
          '<div class="row row_'+countRow+'">'+
            '<div class="col-md-3 col-sm-3 col-6">'+
              '<div class="form-group">'+
                '<input type="number" name="grading_from[]" id="grading_from_'+countRow+'" class="form-control" placeholder="Grading From">'+
              '</div>'+
            '</div>'+
            '<div class="col-md-3 col-sm-3 col-6">'+
              '<div class="form-group">'+
                '<input type="number" name="grading_to[]" id="grading_to_'+countRow+'" class="form-control" placeholder="Grading To">'+
              '</div>'+
            '</div>'+
            '<div class="col-md-4 col-sm-4 col-9">'+
              '<div class="form-group">'+
                '<input type="text" name="grading_description[]" id="grading_description_'+countRow+'" class="form-control" placeholder="Grading Description" autocomplete="off">'+
              '</div>'+
            '</div>'+
            '<div class="col-md-2 col-sm-2 col-3">'+
              '<button type="button" class="btn btn-danger btn-sm" onClick="removeRow('+countRow+')">x</button>'+
            '</div>'+
          '</div>'
        );
    }

    function removeRow(row)
    {
        if(countAdditional == 4)
        {
            alert('There has to be at least');
            return false;
        }
        else
        {
            $('.row_'+row).remove();
            countAdditional--;
        }
    }
</script>
@endpush