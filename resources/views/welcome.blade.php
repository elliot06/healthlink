
@extends('layouts.master')
@section('content')
<div id="particles-js"></div>

<div class="container">
    <div class="first-page content-center">
        <div class="row center wow fadeIn" data-wow-delay=".4s">
            @if(Session::has('success'))
            <div class="row">
                <div class="col s12 m6 offset-m3 l6 offset-l3">
                    <div class="card-panel green">
                        <span class="white-text">{{ Session::get('success') }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
            <h3>HealthLink is a Web and Mobile Application that will reinvent the ecosystem of Healthcare in the Philippines.</h3>
            <h4 class="">HealthLink will allow your health records to be securely<br><span class="txt-rotate korra-sub" data-period="2000" data-rotate='[ "stored.", "accessible.", "and shared." ]'></span></h4>
        </div>
        @if(Session::has('errors'))
        <div class="row">
            <div class="col s12 m6 offset-m3 l6 offset-l3">
                <div class="card-panel red">
                    <span class="white-text">{{ Session::get('errors') }}
                    </span>
                </div>
            </div>
        </div>
        @endif
        <div class="row center valign-wrapper">
            <div class="col s12 m6 offset-m3 l6 offset-l3">
                <button type="button" class="btn waves-effect waves-light btn-large wow fadeIn pulse" data-wow-delay=".7s">GET STARTED AS PATIENT</button>
                <button type="button" class="btn waves-effect waves-light btn-large wow black fadeIn" data-wow-delay=".7s">GET STARTED AS DOCTOR</button>
            </div>
        </div>
    </div>
</div>

<div class="second-page white-text" id="howItWorks">
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3 l6 offset-l3">
                <h2 class="center wow fadeIn" data-wow-delay=".4s">How-It-Works</h2>
            </div>
        </div>

        <hr class="wow fadeIn" data-wow-delay=".5s">
        <br>
        <div class="row">
            <div class="col s12 m6 l6 center wow fadeIn" data-wow-delay=".7s">
                <div class="col s12 m6 l6 center">
                    <img src="https://image.flaticon.com/icons/svg/429/429313.svg" class="responsive-img hvr-grow" style="width: 200px">
                </div>
                <div class="col s12 m6 l6 center">
                    <h2 class="center">Create Account</h2>
                    <p>Create an account at HealthLink. You can click the button above to GET STARTED.</p>
                </div>
            </div>
            <div class="col s12 m6 l6 center wow fadeIn" data-wow-delay=".9s">
                <div class="col s12 m6 l6 center">
                    <img src="https://image.flaticon.com/icons/png/512/635/635625.png" class="responsive-img hvr-grow" style="width: 200px">
                </div>
                <div class="col s12 m6 l6 center">
                    <h2 class="center">Store Records</h2>
                    <p>Upload your records to your secret vault. You can upload images as well.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6 center wow fadeIn" data-wow-delay="1.1s">
                <div class="col s12 m6 l6 center">
                    <h2 class="center">Access Records</h2>
                    <p>You can <b>FREELY</b> access your records anytime, anywhere paperless. You don't have to worry if you have the right data in your mind. Your health records is at your fingertips!</p>
                </div>
                <div class="col s12 m6 l6 center">
                    <img src="https://image.flaticon.com/icons/svg/309/309637.svg" class="responsive-img hvr-grow" style="width: 200px">
                </div>
            </div>
            <div class="col s12 m6 l6 center wow fadeIn" data-wow-delay="1.3s">
                <div class="col s12 m6 l6 center">
                    <h2 class="center">Share to Anyone</h2>
                    <p><b>Share</b> your data to anyone you like. Sharing of your records made possible through encrypted keys passed to your desired recipient. These keys are made just to a specific user.</p>
                </div>
                <div class="col s12 m6 l6 center">
                    <img src="https://image.flaticon.com/icons/png/512/284/284612.png" class="responsive-img hvr-grow" style="width: 200px">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="third-page white-text black" id="whyHealthLink">
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3 l6 offset-l3">
                <h2 class="center wow fadeIn" data-wow-delay=".4s">Why Use HealthLink?</h2>
            </div>
        </div>

        <hr class="wow fadeIn" data-wow-delay=".5s">
        <div class="section"></div>
        <div class="row" style="padding-top: 8%">
            <div class="col s12 m6 l6 center wow fadeIn" data-wow-delay=".7s">
                <img src="https://image.freepik.com/free-vector/medical-background-design_1212-116.jpg" class="responsive-img circle hvr-grow" style="width: 70%">
            </div>
            <div class="col s12 m6 l6 wow fadeIn" data-wow-delay=".9s">
                <h4 class="center"><b>HealthLink</b> allows you to securely create, access, and share your health records anytime, anywhere. <br><br>With HealthLink you share you health records to anyone whom you granted the access to. We use encrypted and time-based record sharing to maintain high level security.<br><br>At HealthLink, you own your records.</h4>
            </div>
        </div>

        <div class="row center">
            <div class="section"></div>
            <a data-scroll href="#HealthLink"><button type="button" class="btn waves-effect btn-large waves-light wow fadeIn" data-wow-delay="1.1s">get started with HealthLink</button></a>
        </div>
    </div>
</div>

@endsection


