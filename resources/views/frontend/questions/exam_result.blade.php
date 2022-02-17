@extends('layouts.app')
@push('styles')
<style>
    
</style>
@endpush
@section('content')
<div class="container exam-result-page py-4">
    <h3 class="mb-4 mt-3" style="padding-left: 13px;">NOTICE OF EXAM RESULTS (ONLINE)</h3>
    <table class="table table-striped" id="exam_result">
        <tbody>
            <tr>
                <td>Student Name</td>
                <td> {{$student_exam->examBy->name}} </td>
            </tr>
            <tr>
                <td>Programme Name</td>
                <td> {{$student_exam->course->course_name}} </td>
            </tr>
            <tr>
                <td>Exam Name</td>
                <td> {{$exam->exam_name}} </td>
            </tr>
            <tr>
                <td>Started On</td>
                <td> {{date('l, d F Y, H:i A' ,strtotime($student_exam->start_exam))}} </td>
            </tr>
            <tr>
                <td>Completed On</td>
                <td> {{date('l, d F Y, H:i A' ,strtotime($student_exam->stop_exam))}} </td>
            </tr>
            <tr>
                <td>Time Taken</td>
                <td> {{$data['time_taken']}} </td>
            </tr>
            <tr>
                <td>Passing Mark</td>
                <td> {{$exam->passing_mark}} </td>
            </tr>
            <tr>
                <td>Your Mark</td>
                <td> {{$student_exam->total_mark}} </td>
            </tr>
            <tr>
                <td>Grade</td>
                <td> {{$student_exam->grade}} </td>
            </tr>
            <tr>
                <td>Feedback</td>
                <td> 
                @if($exam->passing_mark < $student_exam->total_mark)
                    Congratulations, you have passed the exam!
                @else
                    You have failed the exam!
                @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-12 text-right">
            {{-- <a href="{{url('/exam_result/download/'.$student_exam->id)}}" class="btn btn-primary" id="print_result">Print the result</a> --}}
            {{-- <a href="{{url('/courses/detail/'.$exam->course_id.'?module_id='.$exam->module_id)}}" class="btn btn-secondary" id="return_course">Return to the course page</a> --}}
            <a href="#" class="btn btn-secondary" id="return_course">Return to the course page</a>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script>

    var slug = "{{$exam->course->slug}}";
    var moduleId = {{$exam->module_id}};

    document.getElementById("return_course").addEventListener("click", function() {
        window.onbeforeunload = "";
        location.href = "/courses/detail/"+slug+"?module_id="+moduleId;
    });



    (function(window, location) {
        history.replaceState(null, document.title, location.pathname+"#!/history");
        history.pushState(null, document.title, location.pathname);
        
        window.addEventListener("popstate", function() {
        if(location.hash === "#!/history") {
            history.replaceState(null, document.title, location.pathname);
            setTimeout(function(){
                var result = confirm("Are you sure leave now?");
                if(result) {
                    location.replace("/courses/detail/"+slug+"?module_id="+moduleId);
                }
            
            },10);
        }
        }, false);
    }(window, location));

    function disableBack() { 
        window.history.forward(); 
    }
    setTimeout("disableBack()", 0);
    window.onunload = function () { null };

</script>
@endpush