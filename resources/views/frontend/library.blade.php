@extends('layouts.app')

@section('title'){!! "Library -" !!} @stop

@section('content')
<div class="container library-page py-5 ">
    <div class="row justify-content-center text-center">
        <div class="col-6 col-sm-3 mb-5">
            <div class="icon-wrapper"><i class="fas fa-balance-scale"></i></div>
            <div class="library-title">Labor Law</div>
        </div>
        <div class="col-6 col-sm-3 mb-5">
            <div class="icon-wrapper"><i class="fas fa-book"></i></div>
            <div class="library-title">Management Book</div>
        </div>
        <div class="col-6 col-sm-3 mb-5">
            <div class="icon-wrapper"><i class="fab fa-searchengin"></i></div>
            <div class="library-title">Research</div>
        </div>
        <div class="col-6 col-sm-3 mb-5">
            <div class="icon-wrapper"><i class="fas fa-headphones-alt"></i></div>
            <div class="library-title">Audio Books</div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-wrapper {
        width: 120px;
        height: 120px;
        background: #021f63;
        border-radius: 50%;
        margin: 0 auto 30px;
        justify-content: center;
    }
    .icon-wrapper i {
        color: #fff;
        font-size: 4rem;
        margin: 0;
        position: absolute;
        top: 25%;
        left: 0;
        right: 0;
        margin: 0 auto;
        -ms-transform: translateY(-25%);
        transform: translateY(-25%);
    }
    .library-title {
        font-size: 18px;
        font-weight: 500;
    }
</style>
@endpush