<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page { margin: 0px; padding: 5px;}
        html {
            height: 100%;
            width: 100%;
        }
        body { 
            margin: 0px; 
            padding: 0; 
            position: relative; 
            text-align: center;
            width: 100%;
            height: 100%;
        }
        
        .bg-img {
            width: 99.5%;
            margin:0 auto;
            vertical-align: middle;
        }
        .student-name {
            font-family: "Times New Roman";
            font-weight: 600;
            font-size: 58px;
            letter-spacing: 3.5px;
            position: absolute;
            top: 36.7%;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        .course-name {
            font-family: "Times New Roman";
            font-weight: 600;
            font-size: 30px;
            position: absolute;
            top: 52.3%;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        .date {
            font-family: "Arial";
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
            position: absolute;
            top: 62.5%;
            margin: 0 auto;
            left: 0;
            right: 0;
        }
        .sn {
            font-family: "Arial";
            font-weight: bold;
            font-size: 14px;
            position: absolute;
            bottom: 12.8%;
            left: 50%;
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
        {!!$date!!}
        {{-- {{$data["date"]}} --}}
    </div>
    <div class="sn">
        {{$enrol_course->serial_no}}
        {{-- {{$data["enrol_course"]->serial_no}} --}}
    </div>
    
</body>
</html>