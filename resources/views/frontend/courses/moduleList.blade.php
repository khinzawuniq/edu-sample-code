<div class="col-md-12 rightSection">
    @foreach ($modules as $module)
    
    <div id="moduleTab{{$module->id}}" class="tabcontent" style="display:{{Request::get('module_id') == $module->id ? 'block' : 'none'}}">
        @can('list')
        <div class="text-right mb-2">
            <button class="btn btn-success" onclick="setModuleId({{$module->id}})" data-toggle="modal" data-target="#lessonModal"><i class="fas fa-plus"></i>Add and activity or resource</button>
        </div>
        @endcan
            <div  style="max-height: 100vh;overflow-y: scroll;" >
            <div class="accordion lessonSortable" data-id="{{$module->id}}" id="accordionExample">
            @foreach ($module->lessons->sortBy('order_no') as $lesson)
            {{-- Student --}}
            @if(auth()->user()->role == "Student" || auth()->user()->switch_role == "Student")
               @include('frontend.courses.studentView')
            @else
            @if(auth()->user()->switch_role != "Student")
                @include('frontend.courses.adminView')
            @endif
            @endif
            @endforeach
            </div>
        
            
            {{-- <div class="accordion mb-3" id="accordionExam">
            
            @foreach($module->exams as $exam)
            @if(auth()->user()->role == "Student" || auth()->user()->switch_role == "Student")
            @if($exam->is_active == 1)

            
            @php 
                $currentDate = date('Y-m-d H:i:s');
                $display_exam = true;
                if($exam->time_limit == 1) {
                    $display_exam = false;
                    if($currentDate >= $exam->start_date && $currentDate <= $exam->end_date) {
                        $display_exam = true;
                    }
                }
            @endphp

            <div class="card mb-2 exam_wrapper student-view {{($display_exam)? '':'hide'}}" style="border-bottom:1px solid #ccc;">
            <div class="card-header showMore student-view" id="examHeading{{$exam->id}}" data-toggle="collapse" data-target="#examcollapse{{$exam->id}}" aria-expanded="true" aria-controls="examcollapse{{$exam->id}}">
                <div class="row">
                    <div class="col-md-8" style="align-self:center">
                        <span id="origin_exam_name_{{$module->id}}">{{$exam->exam_name}}</span>
                    </div>
                    <div class="col-md-4 text-right">
                        <button class="showMore btn btn-transparent" type="button" data-toggle="collapse" data-target="#examcollapse{{$exam->id}}" aria-expanded="true" aria-controls="examcollapse{{$exam->id}}">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                </div>
                <div class="card-body collapse" id="examcollapse{{$exam->id}}"  aria-labelledby="examHeading{{$exam->id}}" data-parent="#accordionExam">

                     <div> {!! $exam->description !!}</div>

                     <div class="text-right btngroup">
                        <a href="{{url('exams/'.$exam->id)}}" class="btn btn-primary btn-sm float-left" id="student_exam" >Exam Room</a>
                        
                     </div>
                </div>
            </div>

            @endif
            @else
            @if(auth()->user()->switch_role != "Student")
            <div class="card">
                <div class="card-header">
                    <div class="exam_{{$exam->id}}">
                        <span id="origin_exam_name_{{$module->id}}">{{$exam->exam_name}}</span>
                        @can('list')
                        <span class="clickevent" onclick="chnageExamEditMode({{$exam->id}})"><i class="fas fa-pencil-alt"></i></span>
                        @endcan
                    </div>
                    <div class="exam-edit-{{$exam->id}} d-none">
                        <input type="text" autocomplete="off" class="exam-input" value="{{$exam->exam_name}}" name="exam_name" id="exam_name_{{$exam->id}}" onkeypress="saveLessonByEnter({{$exam->id}})">
                        <span class="clickevent" onclick="saveExam({{$exam->id}})"><i class="fas fa-save"></i></span>
                        <span class="clickevent" onclick="cancelExamEdit({{$exam->id}})"><i class="fas fa-times"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    
                     <div> {!! $exam->description !!}</div>

                     @can('list')
                     <div class="exam-btn-wrapper">
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    {!! Form::select('question_group_id', $question_groups, old('question_group_id'), array('class' => 'form-control', 'onChange'=>'selectQuestionGroup(this.value,'.$course->id.','.$module->id.','.$exam->id.')','id'=>'question_group_id')) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <a href="{{url('/exams/question_list/'.$exam->id.'?course_id='.$course->id.'&module_id='.$module->id)}}" class="btn btn-primary float-left ml-2" >Confirmed Questions</a>
                            </div>
                        </div>

                        <div class="text-right btngroup float-right">
                            <a onclick="hideExam({{$exam->id}})" id="active-exam-control{{$exam->id}}" class="btn btn-sm btn-light"><i class="{{$exam->is_active ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a>
                            <a href="/admin/exams/{{$exam->id}}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            
                            <a onclick="deleteExam({{$exam->id}})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                            <form action="{{ route('exams.destroy', $exam->id) }}" method="post" style="display: none;" class="deleteExamDataForm{{$exam->id}}">
                               @csrf
                               @method('DELETE')
                           </form>
                        </div>

                     </div>
                     @endcan
                </div>
            </div>
            @endif
            @endif
            @endforeach
            </div> --}}

            </div>
        @can('list')
        <div class="text-right">
            <button class="btn btn-success" onclick="setModuleId({{$module->id}})" data-toggle="modal" data-target="#lessonModal"><i class="fas fa-plus"></i>Add and activity or resource</button>
        </div>
        @endcan
    </div>
    
    @endforeach
    
</div>