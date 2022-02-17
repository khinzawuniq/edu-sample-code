@extends('layouts.app')

@section('content')
<div class="container payment-list py-4">

    <div class="row mb-3">
        <div class="col-12 text-right">
            <a href="{{url('/courses/detail/'.$data['course_id'].'?module_id='.$data['module_id'])}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped payment-list-tbl">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Particular</th>
                        <th>Number of Students</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="student-list text-success"> Paid List </td>
                        <td>{{$paid}}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{url('/courses/paid_lists/'.$certificate_id.'?course_id='.$data['course_id'].'&module_id='.$data['module_id'])}}">More Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="student-list text-danger"> Unpaid List </td>
                        <td>{{$unpaid}}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{url('/courses/unpaid_lists/'.$certificate_id.'?course_id='.$data['course_id'].'&module_id='.$data['module_id'])}}">More Detail</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-primary text-white">
                        <td>Total</td>
                        <td>{{$paid+$unpaid}}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .payment-list-tbl th, .payment-list-tbl td {
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endpush