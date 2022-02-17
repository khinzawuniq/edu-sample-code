@if($lesson->is_active == 1)
    @if ($lesson->lesson_type == 4 )
    @php $display_exam = true; @endphp
    @foreach($lesson->exam as $exam)
        @php 
        $currentDate = date('Y-m-d H:i:s');
        
        if($exam->time_limit == 1) {
            $display_exam = false;
            if($currentDate >= $exam->start_date && $currentDate <= $exam->end_date) {
                $display_exam = true;
            }
        }
        @endphp
    @endforeach
    @endif

<div class="card mb-2 border-0 student-view @if($lesson->lesson_type == 4 ) {{($display_exam)?'':'hide'}} @endif">
<div class="card-header student-view" id="heading{{$lesson->id}}" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="true" aria-controls="collapse{{$lesson->id}}">
     <div class="lesson{{$lesson->id}}">
         <div class="row">
             <div class="col-md-8" style="align-self:center">
             <span id="lessonTitle{{$lesson->id}}">{{$lesson->name}}</span>
             </div>
             <div class="col-md-4 text-right">
                 <button class="showMore btn btn-transparent" type="button" data-toggle="collapse" data-target="#collapse{{$lesson->id}}" aria-expanded="true" aria-controls="collapse{{$lesson->id}}">
                     <i class="fas fa-chevron-down"></i>
                 </button>
             </div>
         </div>
     </div>
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
         @php
             $submit = $lesson->checkSubmitted(auth()->user()->id);
         @endphp
         <table class="table table-bordered table-sm">
             <tr>
                 <th style="width:50%">Attempt number</th>
                 <td>1 time</td>
             </tr>
             <tr>
                 <th>Submission Status</th>
                 <td>
                     @if ($submit)
                     <strong style="color:green">Submitted</strong>
                     @else
                     <strong>Not submitted</strong>
                     @endif
                 </td>
             </tr>
             <tr>
                 <th>Grading Status</th>
                 <td>
                     @if ($submit)
                         @if ($submit->mark)
                         <strong>Graded</strong>
                         @else
                         <strong>Not graded</strong>
                         @endif
                     @else 
                     <strong>Not submitted</strong>
                     @endif
                 </td>
             </tr>
             <tr>
                 <th>Submission Deadline</th>
                 <td><strong>{{date("d F Y,h:i A",strtotime($lesson->assingment_due_date))}}</strong></td>
             </tr>
             <tr>
                 <th>Time Remaining</th>
                 @if ($submit)
                     @if ($submit->submission_date > $lesson->assingment_due_date)
                     <td><strong style="color:red">{{$submit->getSubmittedTime($lesson->assingment_due_date)}}</strong></td>
                     @else 
                     <td><strong style="color:green">{{$submit->getSubmittedTime($lesson->assingment_due_date)}}</strong></td>
                     @endif
                  @else 
                  <td><strong style="color:{{$lesson->remaining_time == 0 ? 'red' :''}}">{{$lesson->remaining_time}}</strong></td>
                  @endif
             </tr>
             @if ($submit)
             <tr>
                 <th>Last modified</th>
                 <td><strong>{{date('d M Y, h:i A',strtotime($submit->submission_date))}}</strong></td>
             </tr>
             @endif

             <form action="/upload-assignment" method="post" enctype="multipart/form-data">
             <tr>
                 <th>File submission</th>
                 <td>
                     @if ($submit)
                    <a style="text-decoration:underline;color:blue" download href="{{asset('assignments/'.$submit->assignment_file)}}">Your Assignment File</a>
                     @endif
                         @csrf
                         <div style="align-items:center;display:flex" class="fileUpload{{$lesson->id}} {{$submit ? ' d-none' : ''}}">
                             <input type="file" class="assignment_upload{{$lesson->id}}" name="assignment_file" id="assignment_file" required>
                             <i onclick="fileRemove({{$lesson->id}})" class="ml-2 mr-2 text-danger fas fa-times" style="cursor:pointer"></i>
                         </div>
                         
                         <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                 </td>
             </tr>
             <tr>
                 <td colspan="2">
                     <div>
                         @if ($submit)
                           @if ($submit->submission_date < $lesson->assingment_due_date)
                           <button type="button" onclick="showUpload({{$lesson->id}})" class="btn btn-dark  mt-2">Edit my submission</button>
                           @endif
                         @endif
                         <button type="button" onclick="cancelUpload({{$lesson->id}})" class="btn btn-dark  mt-2 d-none">Cancel editing submission</button>
                         <button type="submit" class="btn btn-success  mt-2">Submit assignment</button>
                     </div>
                 </td>
             </tr>
         </form>
         </table>
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

       @if ($lesson->lesson_type == 6 )
          @php
            $pass_lesson = false;
            $pass_grade = false;
            $pass_payment = false;
            $final_pass_certificate = false;
            $get_certificate  = App\Models\StudentExam::where('exam_id', $lesson->certificate_exam_id)->where('exam_by', Auth::Id())->first();
            $check_payment = App\Models\StudentPayment::where('student_id', Auth::Id())->where('course_id', $course->id)->where('approve_status', 1)->first();

            if($lesson->activity_restriction == 1) {
                $pass_lesson = true;
            }else {
                if($duration_percent <= $student_lesson_duration) {
                    $pass_lesson = true;
                }
            }
            if($lesson->grade_restriction == 1) {
                $pass_grade = true;
            }else {
                if(isset($get_certificate->grade)) {
                    $pass_grade = true;
                }
            }
            if($lesson->payment_restriction == 1) {
                $pass_payment = true;
            }else {
                if($check_payment) {
                    $pass_payment = true;
                }
            }

            if($pass_lesson == true && $pass_grade == true && $pass_payment == true) {
                $final_pass_certificate = true;
            }
            
          @endphp

          @if($final_pass_certificate == true)
            <a href="{{url('/courses/download_certificate/'.$course->id.'/'.$lesson->id)}}" class="btn btn-info btn-sm" id="download_certificate">Download Certificate</a>
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

       @if($lesson->lesson_type == 4 )
        @foreach($lesson->exam as $exam)

            <div class="text-right btngroup">
                <a href="{{url('exams/'.$exam->id)}}" class="btn btn-primary btn-sm float-left" id="student_exam" >Exam Room</a>
            </div>
        @endforeach
       @endif
     </div>
</div>
@endif