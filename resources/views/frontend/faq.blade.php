@extends('layouts.app')

@section('title'){!! "FAQ -" !!} @stop

@section('content')
<div class="container main-content-bg faq-page">

    <div class="row justify-content-center">
        <div class="col-md-12">
          @can('create')
          <div class="row mt-3">
            <div class="col-12 text-right">
              
              <a href="#" target="_blank" class="btn btn-sm btn-success mr-3" data-toggle="modal" data-target="#createModal" style="border-radius:50px;">Add FAQ</a>
              
            </div>
          </div>
          @endcan

          @php
            $faq_count = count($faqs);
            $half = $faq_count/2;
          @endphp

            <div class="card faq-wrapper border-0">
                <div class="card-body">
                  <div class="accordion" id="accordion">
                    <div class="row">
                        <div class="col-md-6">
                            
                              @foreach($faqs as $k=>$f)
                              @if($half > $k)
                                <div class="card mb-4 row-{{$f->id}}">
                                  <div class="card-header" id="heading_{{$f->id}}">
                                    <h5 class="mb-0">
                                      <button type="button" class="btn btn-link {{($k != 0)?'collapsed':''}}" data-toggle="collapse" data-target="#collapse_{{$f->id}}" aria-expanded="true" aria-controls="collapse_{{$f->id}}" >
                                        <i class="fas fa-plus-circle"></i><i class="fas fa-minus-circle"></i> <span>{{$f->question}}</span>
                                      </button>
                                    </h5>
                                  </div>
                              
                                  <div id="collapse_{{$f->id}}" class="question collapse {{($k==0)? 'show':''}}" aria-labelledby="heading_{{$f->id}}" data-parent="#accordion">
                                    <div class="card-body text-justify">
                                      {!! $f->answer !!}

                                      <div class="d-block text-right">
                                        @can('edit')
                                        <button class="btn btn-warning btn-sm" onClick="getFAQ({{$f->id}})" data-toggle="modal" data-target="#editModal" ><i class="far fa-edit"></i></button>
                                        @endcan

                                        @can('delete')
                                        <button class="btn btn-danger btn-sm" onClick="deleteFAQ({{$f->id}})"><i class="far fa-trash-alt"></i></button>
                                        @endcan
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>
                                @endif
                              @endforeach

                        </div>
                        <div class="col-md-6">

                                @foreach($faqs as $k=>$f)
                                @if($half <= $k)
                                  <div class="card mb-4 row-{{$f->id}}">
                                    <div class="card-header" id="heading_{{$f->id}}">
                                      <h5 class="mb-0">
                                        <button type="button" class="btn btn-link {{($k != 0)?'collapsed':''}}" data-toggle="collapse" data-target="#collapse_{{$f->id}}" aria-expanded="true" aria-controls="collapse_{{$f->id}}">
                                          <i class="fas fa-plus-circle"></i><i class="fas fa-minus-circle"></i> <span>{{$f->question}}</span>
                                        </button>
                                        {{-- <i class="fas fa-minus-circle d-none"></i> --}}
                                      </h5>
                                    </div>
                                
                                    <div id="collapse_{{$f->id}}" class="question collapse {{($k==0)? 'show':''}}" aria-labelledby="heading_{{$f->id}}" data-parent="#accordion">
                                      <div class="card-body text-justify">
                                        {!! $f->answer !!}

                                        <div class="d-block text-right">
                                          @can('edit')
                                          <button class="btn btn-warning btn-sm" onClick="getFAQ({{$f->id}})" data-toggle="modal" data-target="#editModal"><i class="far fa-edit"></i></button>
                                          @endcan

                                          @can('delete')
                                          <button class="btn btn-danger btn-sm" onClick="deleteFAQ({{$f->id}})"><i class="far fa-trash-alt"></i></button>
                                          @endcan

                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>
                                @endif
                                @endforeach

                        </div>
                    </div>
                    
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Create FAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route' => 'faqs.store','method'=>'POST')) !!}

        <div class="form-group">
            <label for="question">Question *</label>
            <input type="text" name="question" id="question" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="answer">Answer *</label>
            <textarea name="answer" id="answer" class="form-control psmeditor" rows="5" required></textarea>
        </div>

        <div class="form-group text-right">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
        </div>

        {!! Form::close() !!}
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit FAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('/admin/faqs/update_faq')}}" method="post" id="editForm">
        {{csrf_field()}}

        <input type="hidden" name="faq_id" id="edit_faq_id">

        <div class="form-group">
            <label for="question">Question *</label>
            <input type="text" name="question" id="edit_question" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="answer">Answer *</label>
            <textarea name="answer" id="edit_answer" class="form-control psmeditor" rows="5" required></textarea>
        </div>

        <div class="form-group text-right">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
        </div>

        </form>
      </div>
      
    </div>
  </div>
</div>

@endsection

@push('scripts')
{{-- <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<script>

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


function getFAQ(id)
{
  $.ajax({
        type:'get',
        url:'admin/faqs/get/'+id,
        success:function(response){
            // console.log(response);
            $("#edit_faq_id").val(response.id);
            $("#edit_question").val(response.question);
            // $("#edit_answer").val(response.answer);
            $("#edit_answer").summernote("code", response.answer);
            
        }
  });
}

function deleteFAQ(id)
{
  var result = confirm("Are you sure delete record?");
  if(result) {
    $.ajax({
        type:'get',
        url:'admin/faqs/delete_faq/'+id,
        success:function(response){
            // console.log(response);
            $(".row-"+id).remove();
            
        }
    });
  }
  

}

</script>
@endpush