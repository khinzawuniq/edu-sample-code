<div class="card mb-3 border-0" style="border:1px solid #ccc;border-radius:5px">
    <div class="card-header" id="heading{{$lesson->id}}" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="true" aria-controls="collapse{{$lesson->id}}">
        @if ($lesson->lesson_type == 4 )
            {{-- @foreach($lesson->exam as $exam) --}}
                <div class="lesson{{$lesson->id}}">
                    <div class="row">
                        <div class="col-md-10">
                            @can('list')
                            <i class="fas fa-arrows-alt lessondragIcon"></i>
                            @endcan
                            <input type="hidden" name="lesson_order{{$module->id}}[]" value="{{$lesson->id}}">
                            <span id="origin_lesson_name{{$module->id}}">{{$lesson->name}}</span>
                            @can('list')
                            {{-- <span class="clickevent" onclick="chnageExamEditMode({{$exam->id}})"><i class="fas fa-pencil-alt"></i></span> --}}
                            <span class="clickevent" onclick="chnageLessonEditMode({{$lesson->id}})"><i class="fas fa-pencil-alt"></i></span>
                            @endcan
                        </div>

                        <div class="col-md-2 text-right">
                            <button class="showMore btn btn-transparent" type="button" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="true" aria-controls="collapse{{$lesson->id}}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                    
                </div>

                <div class="lesson-edit{{$lesson->id}} d-none">
                    <input type="text" autocomplete="off" class="lesson-input" value="{{$lesson->name}}" name="lesson" id="lesson_name{{$lesson->id}}" onkeypress="saveLessonByEnter({{$lesson->id}})">
                    <span class="clickevent" onclick="saveLesson({{$lesson->id}})"><i class="fas fa-save"></i></span>
                    <span class="clickevent" onclick="cancelLessonEdit({{$lesson->id}})"><i class="fas fa-times"></i></span>
                </div>
            {{-- @endforeach --}}
        @else
            <div class="lesson{{$lesson->id}}">
                <div class="row">
                    <div class="col-md-10">
                        @can('list')
                        <i class="fas fa-arrows-alt lessondragIcon"></i>
                        @endcan
                    <input type="hidden" name="lesson_order{{$module->id}}[]" value="{{$lesson->id}}">
                        <span id="origin_lesson_name{{$module->id}}" class="lesson_title{{$lesson->id}}">{{$lesson->name}}</span>
                        @can('list')
                        <span class="clickevent" onclick="chnageLessonEditMode({{$lesson->id}})"><i class="fas fa-pencil-alt"></i></span>
                        @endcan
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="showMore btn btn-transparent" type="button" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="true" aria-controls="collapse{{$lesson->id}}">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
        
        
            </div>
            <div class="lesson-edit{{$lesson->id}} d-none">
                <input type="text" autocomplete="off" class="lesson-input" value="{{$lesson->name}}" name="lesson" id="lesson_name{{$lesson->id}}" onkeypress="saveLessonByEnter({{$lesson->id}})">
                    <span class="clickevent" onclick="saveLesson({{$lesson->id}})"><i class="fas fa-save"></i></span>
                    <span class="clickevent" onclick="cancelLessonEdit({{$lesson->id}})"><i class="fas fa-times"></i></span>
            </div>
        @endif
    </div>
     <div class="card-body collapse" id="collapse{{$lesson->id}}"  aria-labelledby="heading{{$lesson->id}}" data-parent="#accordionExample">
         @if ($lesson->file_path && $lesson->lesson_type == 3 )
         <div class="player-container" onmouseout="hideControls({{$lesson->id}})" onmouseover="showControls({{$lesson->id}})">
            <div class="controlGroup{{$lesson->id}} d-none controls-group w-100 pl-2 pr-2" style="display:flex;justify-content: space-between;" onclick="setPlayPause({{$lesson->id}})">
                <button onclick="previousVideo({{$lesson->course_module_id}},{{$lesson->id}})" class="btn btn-transparent text-white"><i class="controlIcon fas fa-step-backward"></i></button>
                <button onclick="nextVideo({{$lesson->course_module_id}},{{$lesson->id}})" class="btn btn-transparent text-white"><i class="controlIcon fas fa-step-forward"></i></button>
           </div>
            <input type="hidden" value="{{asset($lesson->file_path)}}" id="lessonVideo{{$lesson->id}}">
            <input type="hidden" name="videoids[]" value="{{$lesson->id}}">

            <input type="hidden" name="videoUrl{{$lesson->course_module_id}}[]" value="{{asset($lesson->file_path)}}">
            <input type="hidden" name="videoTitle{{$lesson->course_module_id}}[]" value="{{$lesson->name}}">
            <input type="hidden" name="videoDescription{{$lesson->course_module_id}}[]" value="{{$lesson->description}}">
            
            @php
                $extension = pathinfo(storage_path($lesson->file_path), PATHINFO_EXTENSION);
            @endphp
            @if($extension == 'mp3')
                <video onplay="startPlay({{$course->id}},{{$lesson->course_module_id}},{{$lesson->id}},'audio')" id="myPlayer{{$lesson->id}}" class="video-js vjs-default-skin vjs-big-play-centered audiowave w-100" controls preload="none" 
                width="100%" height="300" poster="{{asset('/assets/images/vr.gif')}}" data-setup='{}'>
                <source id="videoSource{{$lesson->id}}" src="{{asset($lesson->file_path)}}" type='audio/mp3'/>
                </video>
            @else
                <video onplay="startPlay({{$course->id}},{{$lesson->course_module_id}},{{$lesson->id}},'video')" id="myPlayer{{$lesson->id}}" class="video-js vjs-default-skin vjs-big-play-centered w-100" preload="none" width="100%" height="300" controls disablepictureinpicture controlslist="nodownload" data-setup='{"fluid": true}'>
                <source id="videoSource{{$lesson->id}}" src="{{asset($lesson->file_path)}}" type="video/mp4">
                </video>
            @endif
         </div>
         
         @endif

        
         <div id="lessonDescription{{$lesson->id}}"> {!! $lesson->description !!}</div>

         @if ($lesson->lesson_type == 1 )
         <div>Submission Deadline: <strong>{{date("d M Y,h:i A",strtotime($lesson->assingment_due_date))}}</strong></div> <br>
         <div>Time Remaining: <strong style="color:{{$lesson->remaining_time == 0 ? 'red' :''}}">{{$lesson->remaining_time}}</strong></div>
        
        <a href="/admin/assignment-list?lesson_id={{$lesson->id}}" class="btn btn-sm btn-primary mt-2">View Assignment List</a>
         @endif
         @if ($lesson->file_path && $lesson->lesson_type == 2 )
         <div>
            @php
            $downloadFiles = explode(',',$lesson->file_path);
            @endphp
            @foreach ($downloadFiles as $downloadFile)
            <div>
            <a href="{{asset($downloadFile)}}" download style="text-decoration: underline;color:#0000ff">
                @if (strpos($downloadFile, '.pdf') !== false)
                   <i class="fileIcon fas fa-file-pdf"></i>
                @endif
                @if (strpos($downloadFile, '.txt') !== false)
                   <i class="fileIcon fas fa-file-alt"></i>
                @endif

                @if ((strpos($downloadFile, '.doc') !== false) || (strpos($downloadFile, '.docx') !== false))
                <i class="fileIcon fas fa-file-word"></i>
                @endif

                @if ((strpos($downloadFile, '.xls') !== false) || (strpos($downloadFile, '.xlsx') !== false))
                <i class="fileIcon fas fa-file-excel"></i>
                @endif

                @if ((strpos($downloadFile, '.ppt') !== false) || (strpos($downloadFile, '.pptx') !== false))
                <i class="fileIcon fas fa-file-powerpoint"></i>
                @endif
              
                
                {{basename($downloadFile)}}
            </a>
            </div>
            @endforeach
         </div>
         @endif

         @if ($lesson->lesson_type == 5 )
            @if (strpos($lesson->url, 'youtube') > 0)
              <div>
                {!! $lesson->url !!}
              </div>
            @else
            <div>
                <a href="{{$lesson->url}}" target="_blank" style="text-decoration: underline;color:#0000ff">{{$lesson->url}}</a>
            </div>
            @endif
        @endif


         @if ($lesson->lesson_type == 8 )
         @if ($lesson->file_path)
            <div class="mb-3">
                <img src="{{asset($lesson->file_path)}}" class="w-100">
            </div>
         @endif
         @endif

         @if ($lesson->lesson_type == 7 )
         <div>
            Zoom Meeting Link :<a href="{{$lesson->url}}" style="text-decoration: underline;color:#0000ff">{{$lesson->url}}</a> <br>
            Zoom Meeting ID        : <strong>{{$lesson->zoom_id}}</strong> <br>
            Zoom Meeting Passowrd  : <strong>{{$lesson->zoom_id}}</strong> <br>
         </div>
         @endif

         @can('list')
            @if ($lesson->lesson_type == 4 )
                @foreach($lesson->exam as $exam)
                <div class="exam-btn-wrapper">
                            
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                {!! Form::select('question_group_id', $question_groups, count($exam->questionAssign) > 0 ? $exam->questionAssign[0]->group_id : old('question_group_id'), array('class' => 'form-control', 'onChange'=>'selectQuestionGroup(this.value,'.$course->id.','.$module->id.','.$exam->id.')','id'=>'question_group_id','style'=>'height:35px;')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <a href="{{url('/exams/question_list/'.$exam->id.'?course_id='.$course->id.'&module_id='.$module->id)}}" class="btn btn-primary btn-sm float-left" >Confirmed Questions</a>
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
                @endforeach
            @else
                <div class="text-right btngroup">
                    <a onclick="hideLesson({{$lesson->id}})" id="active-lesson-control{{$lesson->id}}" class="btn btn-sm btn-light"><i class="{{$lesson->is_active ? 'fas fa-eye' : 'fas fa-eye-slash text-muted' }}"></i></a>
                    <a href="/admin/lessons/{{$lesson->id}}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                    <a onclick="copyLesson({{$lesson->id}})" class="btn btn-sm btn-info"><i class="far fa-copy"></i></a>
                    <a onclick="deleteLesson({{$lesson->id}})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                    <form action="{{ route('lessons.destroy', $lesson->id) }}" method="post" style="display: none;" class="deleteLessonDataForm{{$lesson->id}}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
         @endcan
     </div>
</div>

{{-- @if ($lesson->lesson_type == 6 )
            <a href="{{url('/courses/certificate-payment/'.$lesson->id.'?course_id='.$course->id.'&module_id='.$module->id)}}" class="btn btn-warning btn-sm certificate-payment-btn">Payment</a>
            <button class="btn btn-info btn-sm">Download Certificate</button>
            <button class="btn btn-warning btn-sm">Download Certificate</button>
            <button class="btn btn-primary btn-sm">Print Certificate</button>
         @endif --}}