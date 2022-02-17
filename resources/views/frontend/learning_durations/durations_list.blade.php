@extends('layouts.app')

@section('content')
<div class="container enrole-user-page py-4">
    <div class="row mb-2">
        <div class="col-12 text-right">
            @if(auth()->user()->role == "Student" || auth()->user()->switch_role == "Student")
                <a href="{{url('courses/detail/'.$course->slug)}}" class="btn btn-secondary btn-sm">Back</a>
            @else
                <a href="{{url('courses/enrol-users/'.$enrol_user->course_id)}}" class="btn btn-secondary btn-sm">Back</a>
            @endif
            
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-12 font-weight-bold">
            <table class="user-header">
                <tbody>
                    <tr>
                        <td width="120">Student Name</td>
                        <td width="25">:</td>
                        <td>{{$enrol_user->user->name}}</td>
                    </tr>
                    <tr>
                        <td>Course Name</td>
                        <td>:</td>
                        <td>{{$enrol_user->course->course_name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- <input type="hidden" name="course_id" id="course_id" value="{{$enrol_user->course_id}}">
    <input type="hidden" name="user_id" id="user_id" value="{{$enrol_user->user_id}}"> --}}

    <div class="row mb-3">
        <div class="col-12">
            <form action="#" class="form-inline d-flex justify-content-end" id="date_filter">
                
                <input type="text" name="start_time" id="start_time" value="{{isset($data['start_time'])? $data['start_time']:''}}" class="form-control timepicker mr-2" placeholder="Start Time" autocomplete="off">
                <input type="text" name="end_time" id="end_time" value="{{isset($data['end_time'])? $data['end_time']:''}}" class="form-control timepicker mr-2" placeholder="End Time" disabled autocomplete="off">
                <input type="text" name="total_duration" id="total_duration" value="{{$total_hour}}" class="form-control" placeholder="Total Duration" readonly>
                {{-- <input type="text" name="total_duration" id="total_duration" value="{{gmdate('H:i:s', $total_duration)}}" class="form-control" placeholder="Total Duration" readonly> --}}
            </form>
        </div>
    </div>

    <table class="table table-striped datatable enrol-table">
        <thead>
            <tr class="bg-info">
                <th>SN</th>
                <th>Module</th>
                <th>Lesson</th>
                <th>Start Time</th>
                <th>Stop Time</th>
                <th>Durations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($learning_durations as $key=>$duration)
            <tr>
                <td> {{$key+1}} </td>
                <td> {{$duration->module->name}} </td>
                <td> {{$duration->lesson->name}} </td>
                <td> {{date('d/m/Y H:i:s', strtotime($duration->created_at))}} </td>
                <td> {{date('d/m/Y H:i:s', strtotime($duration->updated_at))}} </td>
                <td>  
                    @php
                        $H = floor($duration->playtime_seconds / 3600);
                        $i = ($duration->playtime_seconds / 60) % 60;
                        $s = $duration->playtime_seconds % 60;
                        $lesson_total_hour = sprintf("%02d:%02d:%02d", $H, $i, $s);
                    @endphp
                    {{$lesson_total_hour}}
                </td>
                {{-- <td> {{gmdate('H:i:s', $duration->playtime_seconds)}} </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('styles')
<style>
.user-header td {
    font-size: 16px;
}
#ui-datepicker-div {
    z-index: 1001 !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#start_time').datetimepicker({
        format:'d/m/Y H:i',
        defaultTime:'00:00',
    });

    var start_time = $("#start_time").val();

    if(start_time != '') {
        $("#end_time").removeAttr('disabled');
    }


    $("#start_time").change(function() {
        
        var start_time = $("#start_time").val();
        
        if(start_time != '') {
            $('#end_time').datetimepicker({
                format:'d/m/Y H:i',
                defaultTime:'23:59',
            });

            $("#end_time").removeAttr('disabled');
            
        }else {
            $('#start_time').datetimepicker({
                format:'d/m/Y H:i',
                defaultTime:'00:00',
            });

            $("#end_time").val('');
        }
    });

    $("#end_time").change(function() {
        $("#date_filter").submit();
    });
});
</script>
@endpush