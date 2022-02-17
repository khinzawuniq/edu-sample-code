<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page { margin: 0px; padding: 5px;}
        body { 
            margin: 0px; 
            padding: 5px; 
            position: relative; 
            text-align: center;
        }
        /* .content-wrapper {
            position: absolute;
            top: 40%;
            left: 40%;
            z-index: 9999;
        } */
        .bg-img {
            width: 98.9%;
            margin:0 auto;
            vertical-align: middle;
        }
        .student-name {
            font-family: "Times New Roman";
            font-weight: 600;
            font-size: 65px;
            letter-spacing: 3.5px;
            position: absolute;
            top: 40%;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        .course-name {
            font-family: "Times New Roman";
            font-weight: 600;
            font-size: 34px;
            position: absolute;
            top: 59%;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        .date {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 3px;
            position: absolute;
            bottom: 22%;
            left: 16.5%;
        }
        .sn {
            font-weight: bold;
            font-size: 15px;
            position: absolute;
            bottom: 9.6%;
            left: 50.5%;
            /* bottom: 9.7%;
            left: 48.2%; */
        }
    </style>
</head>
<body>
    <img class="bg-img" src="{{ public_path().$background_img }}">
    {{-- <img class="bg-img" src="{{ $data["background_img"] }}"> --}}

    <div class="student-name">
        {{$enrol_course->user->name}}
        {{-- {{$data["enrol_course"]->user->name}} <br> --}}
    </div>
    <div class="course-name">
        {{$enrol_course->course->course_name}}
        {{-- {{$data["enrol_course"]->course->course_name}} --}}
    </div>
    <div class="date">
        {{$date}}
        {{-- {{$data["date"]}} --}}
    </div>
    <div class="sn">
        {{$sn}}
        {{-- {{$data["sn"]}} --}}
    </div>

    {{-- <div class="content-wrapper">
        {{$enrol_course->course->course_name}} <br>
        {{$date}} <br>
        {{$sn}}
    </div> --}}
        
</body>
</html>