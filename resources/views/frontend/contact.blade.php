@extends('layouts.app')

@section('title'){!! "Contact -" !!} @stop

@push('styles')
    <style>
        .contactCard{
            width: 70%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            background: #fff;
            padding: 3em 1em;
            margin-left: auto;
            border-radius: 10px;
        }
        .contactEmailCard{
            width: 70%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            background: #fff;
            padding: 3em 1em;
            margin-right: auto;
            border-radius: 10px;
        }
        .phone-list{
            border: 1px solid #ccc;
            color: #123760;
            padding: 5px 0px;
            font-weight: bold;
        }
        .contactIcon{
            font-size: 2.5em;
            margin-bottom: 5%;
        }
        .enquiry-section{
            padding: 0em 1em;;
        }
        .nameInput{
            border-radius: 10px;
            background: #bec7d1;
            padding: 10px;

        }
        .textInput:focus{
            border: none;
            outline: none;
            box-shadow: none;
        }
        .email-phone{
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 5px;
        }
        .submitBtn{
            background: #fbb700;
            width: 100%;
            border-radius: 100px;
        }
        .cImage{
            border-radius: 20px;
        }
        .contactTitle{
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .enquiry-section{
            padding: 2em 1em;
        }
        #map-wrapper iframe {
            width: 100%;
        }
    </style>
@endpush

@section('content')
<div class="container px-0 pb-4">
    <div class="main-slide p-0">
        <div class="row justify-content-center m-0">
            <div class="col-md-12 p-0">
                <div id="map-wrapper">
                    {!! $setting->map !!}
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3818.8663436275056!2d96.12731861417987!3d16.832985422989225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c195f3222026dd%3A0x2b5f0c4cf82bbdfd!2sPSM%20International%20College!5e0!3m2!1smy!2smm!4v1639339282584!5m2!1smy!2smm" width="600" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe> --}}
                    {{-- <div id="map"></div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="section contact-section pt-3 pb-3" style="background-repeat: round;background-image:url('assets/images/contactbg.jpg');">
            <div class="container" style="background-color:transparent;">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="contactCard">
                            <i class="fas fa-phone-alt contactIcon"></i>
                            <div class="phone-list">
                                {{-- 0912334525 | 09789789345 --}}
                                {{$setting->first_phone}} | {{$setting->second_phone}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="contactEmailCard">
                            <i class="fas fa-envelope contactIcon"></i>
                            <div class="phone-list">
                                {{-- paingsoemanagement.psm@gmail.com --}}
                                {{$setting->email}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="section enquiry-section" style="background-repeat: round;background-image:url('assets/images/wavebg.jpg')">
        <div class="container" style="background-color:transparent;">
            <div class="row mb-2">
                <div class="col-md-8 text-center">
                    <div class="contactTitle">
                        <h3 class="text-white">CONTACT US</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-right">
                        <img src="{{asset('/assets/images/psm-logo-1.png')}}" alt="PSM" width="90px">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <form action="{{route('contact-mail')}}" method="post">
                    {{csrf_field()}}

                    <input type="hidden" name="mycheck">
                    <div class="nameInput mb-2">
                        <label for="">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" autocomplete="off" placeholder="Enter Your Name" class="textInput form-control" required>
                        @if ($errors->has('name'))
                            <span class="text-danger validate-message">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="email-phone mb-2">
                        <div class="nameInput">
                            <label for="">Email <span class="text-danger">*</span></label> 
                            <input type="email" name="email" autocomplete="off" placeholder="Enter Your Email" class="textInput form-control" required>
                            @if ($errors->has('email'))
                                <span class="text-danger validate-message">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="nameInput">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" autocomplete="off" placeholder="09 xxx xxx xxx" class="textInput form-control" required>
                            @if ($errors->has('phone'))
                                <span class="text-danger validate-message">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="nameInput mb-2">
                        <label for="">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" autocomplete="off" placeholder="Enter Your Subject" class="textInput form-control" required>
                        @if ($errors->has('subject'))
                            <span class="text-danger validate-message">{{ $errors->first('subject') }}</span>
                        @endif
                         {{-- <select name="subject" id="" class="form-control textInput">
                             <option value="">Please Choose</option>
                         </select> --}}
                    </div>
                    <div class="nameInput mb-2">
                        <label for="">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control textInput" id="" cols="30" rows="10" placeholder="Your message here" required></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger validate-message">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                     <div class="mb-2">
                        <button type="submit" class="btn submitBtn">Submit</button>
                     </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="c1-c2">
                        <div class="c1 mb-2">
                        <img src="{{asset('/assets/images/c1.jpg')}}" alt="PSM" class="cImage w-100">
                        </div>
                        <div class="c1 mb-2">
                        <img src="{{asset('/assets/images/c2.jpg')}}" alt="PSM" class="cImage w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa8eUckBXQyRfslPyRwnUy6esm--pwwzQ&libraries=places&callback=initMap"
    async defer></script>
<script>
    $(document).ready(function() {
        // 16.833052183222254, 96.12950998198588
    });
    // function initMap() {
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //             center: {lat: 16.833052, lng: 96.129509},
    //             zoom: 13,
    //             mapTypeId: 'roadmap'
    //     });
    // }
</script>
@endpush