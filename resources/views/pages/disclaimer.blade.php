@extends('layouts.app')

@section('title', 'Disclaimer')

@section('content')
<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>About <span>Us</span></h1>

            <p>
                We welcome to the English Traveller. We are an independent travel-related
                information provider site.
            </p>
        </div>
    </div>
</section>

<style>
.contact-banner{
    background: url("{{ asset('images/christmas.png') }}") center center/cover no-repeat;
    height: 260px;
    position: relative;
}

.contact-banner .overlay{
    position: absolute;
    inset: 0;
    background: rgba(88, 54, 36, 0.65); /* Brown transparent overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.contact-banner .container{
    max-width: 1200px;
    width: 100%;
    padding: 0 20px;
}

.contact-banner h1{
    font-size: 46px;
    color: #fff;
    font-weight: 500;
    margin-bottom: 12px;
    line-height: 1;
}

.contact-banner h1 span{
    color: #d39a45;
    font-weight: 600;
}

.contact-banner p{
    color: #fff;
    font-size: 14px;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.6;
    opacity: .95;
}
    </style>

@endsection