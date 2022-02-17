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
            Grading Edit
          </div>
      </div>
      <div class="card-body" >
        <form action="{{url('/admin/gradings/update/'.$ref_no)}}" method="post" id="grade_form">
        @csrf
        @foreach($gradings as $key=>$grade)
        @if($key == 0)
        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="awarding_body">Awarding Body *</label>
              {!! Form::text('awarding_body', $grade->awarding_body, ['class'=>'form-control','id'=>'awarding_body', 'placeholder'=>'Awarding Body', 'required'=>true, 'autocomplete'=>'off']) !!}
            </div>    
          </div>
        </div>

        <div class="row">
          {{-- <div class="col-md-6 col-sm-6 col-6">
            <div class="form-group">
              <label for="number_grading">Number of Grading *</label>
              {!! Form::number('number_grading', $grade->number_grading, ['class'=>'form-control','id'=>'number_grading', 'placeholder'=>'Number of Grading', 'required'=>true, 'autocomplete'=>'off']) !!}
            </div>
          </div> --}}
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="passing_mark">Passing Mark *</label>
              {!! Form::text('passing_mark', $grade->passing_mark, ['class'=>'form-control','id'=>'passing_mark', 'placeholder'=>'Passing Mark', 'required'=>true, 'autocomplete'=>'off']) !!}
            </div>    
          </div>
        </div>
        @endif
        @endforeach
        
        <div class="multi-wrapper">
          <input type="hidden" name="count_row" id="count_row" value="{{count($gradings)}}">

          @foreach($gradings as $key=>$grade)
          <input type="hidden" name="grading_id[]" id="grading_id_{{$key+1}}" value="{{$grade->id}}">
          <div class="row row_{{$key+1}}">
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                @if($key == 0)
                <label for="grading_from_{{$key+1}}">From</label>
                @endif
                {!! Form::number('grading_from[]', $grade->grading_from, ['class'=>'form-control','id'=>'grading_from_{{$key+1}}', 'placeholder'=>'Grading From', 'autocompalte'=>'off']) !!}
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-6">
              <div class="form-group">
                @if($key == 0)
                <label for="grading_to_{{$key+1}}">To</label>
                @endif
                {!! Form::number('grading_to[]', $grade->grading_to, ['class'=>'form-control','id'=>'grading_to_{{$key+1}}', 'placeholder'=>'Grading To', 'autocompalte'=>'off']) !!}
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
              <div class="form-group">
                @if($key == 0)
                <label for="grading_description_{{$key+1}}">Description</label>
                @endif
                {!! Form::text('grading_description[]', $grade->grading_description, ['class'=>'form-control','id'=>'grading_description_{{$key+1}}', 'placeholder'=>'Grading Description', 'autocomplete'=>'off']) !!}
              </div>
            </div>
          </div>
          
          @endforeach
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-success btn-sm" id="add_row" onClick="addRow()">Add Row</button>
        </div>
        
        <div class="form-group mt-3 text-right">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            <a href="{{route('gradings.index')}}" class="btn btn-default"> Cancel </a>
        </div>

        </form>
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

var countAdditional = {{count($gradings)}};
    var countRow = 0;

    function addRow()
    {
        countRow = countAdditional + 1;
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