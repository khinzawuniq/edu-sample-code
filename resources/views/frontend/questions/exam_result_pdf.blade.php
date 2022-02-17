<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .notice-title {
            text-align: center;
            margin-bottom: 40px;
        }
        table {
            width: 100%;
        }
        table tr {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h3 class="notice-title">NOTICE OF EXAM RESULTS (ONLINE)</h3>
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
</body>
</html>