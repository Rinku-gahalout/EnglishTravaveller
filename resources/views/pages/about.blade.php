@extends('layouts.app')

@section('title', 'About Us - English Traveller')

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

<section class="airlines">
    <div class="airline-container">
        <div class="about-content">

            <div class="airline-left">
                <h1>
                    Explore All Airlines Of The World
                   
                    With Us.
                </h1>

                <p>
                    Englishtraveller is your movement along who designs every one of your
                    movement around the Worldwide with Marathon Flights Arrangements. Be it
                    a latest possible moment flight or an undoubtedly widely gone travel
                    moment, who will let you discover for however many unique flights as
                    possible with your own requirements.
                </p>

                <p>
                    We provide our customers with the option of several packages and offer
                    promotions and discount coupons by availing the ticket changes in our
                    pricing model. It helps in saving a small amount payable by the
                    customer.
                </p>
            </div>

            <div class="airline-right">
                <div class="about-image">
                    <div class="blob">
                        <img src="{{ asset('images/Group 1597884711.png') }}" alt="About Image">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.airlines{
    width:100%;
    padding:31px 8%;
}

.airline-container{
    max-width:1200px;
    margin:0 auto;
    padding:0 15px;
}

.about-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:80px;
}

/* LEFT */

.airline-left{
    width:48%;
}

.airline-left h1{
    font-size:42px;
    color:#6d4023;
    line-height:1.25;
    margin-bottom:25px;
    font-weight:700;
}

.airline-left p{
    color:#666;
    font-size:14px;
    line-height:1.9;
    margin-bottom:18px;
}

/* RIGHT */

.airline-right{
    width:52%;
    display:flex;
    justify-content:center;
}

.blob{
    position:relative;
    height:524px;
    border-radius:
    50% 30% 45% 35% /
    35% 50% 30% 45%;
    overflow:hidden;
}

.blob>img{
    width:100%;
    height:100%;
    object-fit:cover;
}
/* Top Left */

.top{
    width:90px;
    height:90px;
    left:-20px;
    top:85px;
}

/* Middle */

.middle{
    width:105px;
    height:105px;
    left:120px;
    bottom:-20px;
}

/* Right */

.bottom{
    width:105px;
    height:105px;
    right:-15px;
    top:65px;
}

/* Responsive */

@media(max-width:992px){

.about-content{
    flex-direction:column;
    gap:0px;
}

.airline-left,
.airline-right{
    width:100%;
}

.airline-left{
    text-align:center;
}

.blob{
    width:100%;
    max-width:420px;
    height:320px;
}

}
    </style>



<section class="booking-section">
    <div class="container">

        <h2>Incorporate a premium futuristic booking.</h2>

        <div class="booking-wrapper">

            <div class="features left-features">
                <div>Flight Search</div>
                <div>Domestic & International Flights</div>
                <div>Student Discounts</div>
                <div>Last-Minute Deals</div>
                <div>Vacation Packages</div>
                <div>Promo Codes</div>
            </div>

            <div class="plane-area">

                <div class="line line1"></div>
                <div class="line line2"></div>
                <div class="line line3"></div>
                <div class="line line4"></div>

                <img src="{{ asset('images/pla.png') }}" alt="Plane">

            </div>

            <div class="features right-features">
                <div>Discount Coupons</div>
                <div>Best Airfare</div>
                <div>Secure Booking</div>
                <div>24/7 Travel Support</div>
                <div>No Hidden Charges</div>
                <div>Easy Reservations</div>
            </div>

        </div>

    </div>
</section>


<style>
.booking-section{
    background:#fbf5eb;
    padding:80px 0;
}

.booking-section h2{
    text-align:center;
    color:#744326;
    font-size:34px;
    font-weight:700;
    margin-bottom:60px;
}

.booking-wrapper{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.features{
    width:25%;
    display:flex;
    flex-direction:column;
    gap:35px;
}

.left-features{
    text-align:left;
}

.right-features{
    text-align:right;
}

.features div{
    font-size: 20px;
    color: #2E3A2E;
    position:relative;
}

.plane-area{
    width:50%;
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:500px;
}

.plane-area img{
    width:438px;
    position:relative;
    z-index:5;
}

/* Vertical dotted lines */

.line{
    position:absolute;
    top:0;
    bottom:0;
    border-left:2px dashed #e9d8c4;
    z-index:1;
}

.line1{
    left:15%;
}

.line2{
    left:35%;
}

.line3{
    right:35%;
}

.line4{
    right:15%;
}

/* Responsive */

@media(max-width:991px){

.booking-section{
    background:#fbf5eb;
    padding:31px 0;
}

.plane-area img {
     width: 378px!important;
   
     margin-bottom: 34px;
}

.booking-wrapper{
    flex-direction:column;
}

.features,
.plane-area{
    width:100%;
}

.features{
    text-align:center;
    margin-bottom:40px;
}

.right-features{
    text-align:center;
}

.plane-area{
    min-height:350px;
}



.line{
    display:none;
}

}
    </style>


<section class="promise-section">
    <div class="container">

        <h2 class="section-title">Our Promise</h2>

        <div class="promise-row">

            <div class="promise-card">
                <div class="icon-box">
                    <img src="{{ asset('images/Mask group (11).png') }}" alt="">
                </div>
                <p>
                    Objective and independent<br>
                    travel reporting
                </p>
            </div>

            <div class="promise-card">
                <div class="icon-box">
                    <img src="{{ asset('images/Mask group (12).png') }}" alt="">
                </div>
                <p>
                    Immediate publications of airline,<br>
                    airport, and travel policy changes
                </p>
            </div>

            <div class="promise-card">
                <div class="icon-box">
                    <img src="{{ asset('images/Mask group (13).png') }}" alt="">
                </div>
                <p>
                    Specialized and detailed travel<br>
                    features and traveler's guides
                </p>
            </div>

        </div>

    </div>
</section>

<style>
.promise-section{
    padding:80px 0;
    background:#fff;
}

.section-title{
    text-align:center;
    font-size:36px;
    font-weight:600;
    color:#6b3d22;
    margin-bottom:55px;
}

.promise-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:50px;
}

.promise-card{
    flex:1;
    text-align:center;
}

.icon-box{
    width:140px;
    height:140px;
    margin:0 auto 22px;
    background:#f7f0e7;
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    transition:.3s;
}

.icon-box img{
    width:90px;
    height:90px;
    object-fit:contain;
}

.promise-card p{
    font-size:20px;
    color:#333;
    line-height:1.7;
    margin:0;
}

.promise-card:hover .icon-box{
    transform:translateY(-5px);
    box-shadow:0 12px 30px rgba(0,0,0,.08);
}

@media(max-width:768px){

.promise-section{
    padding:27px 0;
    background:#fff;
}

.promise-row{
    flex-direction:column;
    gap:40px;
    align-items:center;
}

.icon-box{
    width:120px;
    height:120px;
}

.section-title{
    font-size: 34px;
        font-weight: 700
}

}
    </style>


<section class="journey">

    <div class="journey-container">

        <h2>Your journey matters</h2>

        <!-- Connector Image -->
        <img src="{{ asset('images/Vector 1 (1).png') }}" alt="" class="path-image">

        <!-- Row 1 -->
        <div class="row">
            <div class="image">
                <img src="{{ asset('images/journey matter 1.png') }}" alt="">
            </div>

            <div class="journey-content">
                <p>
                    AirlineTravelNews isn't a bulletin board—it's a front-row seat to
                    aviation's living story. Obtain the facts, appreciate the analysis,
                    and feel as if you have journeyed without leaving your seat.
                </p>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row reverse">
            <div class="image">
                <img src="{{ asset('images/journey matter 2.png') }}" alt="">
            </div>

            <div class="journey-content">
                <p>
                    AirlineTravelNews isn't a bulletin board—it's a front-row seat to
                    aviation's living story. Obtain the facts, appreciate the analysis,
                    and feel as if you have journeyed without leaving your seat.
                </p>
            </div>
        </div>

        <!-- Row 3 -->
        <div class="row">
            <div class="image">
                <img src="{{ asset('images/journey matter 3.png') }}" alt="">
            </div>

            <div class="journey-content">
                <p>
                    Be it a business trip or leisure journey, or if you admire travelling,
                    AirlineTravelNews is the branded magazine that covers every aspect
                    of flying and travel.
                </p>
            </div>
        </div>

    </div>

</section>

<style>

.journey{
    padding:80px 0;
    position:relative;
    overflow:hidden;
    background:linear-gradient(
        90deg,
        rgba(240,230,210,.3) 0%,
        rgba(235,223,201,.3) 50%,
        rgba(240,230,210,.3) 100%
    );
}

.journey-container{
    max-width:1200px;
    width:100%;
    margin:auto;
    padding:0 15px;
    position:relative;
}

.journey h2{
    text-align:center;
    color:#6b3d22;
    font-size:36px;
    margin-bottom:70px;
    font-weight:600;
}

/* Connector */

.path-image{
position: absolute;
    top: 331px;
    left: 604px;
    transform: translateX(-50%);
    /* width: 100%; */
    max-width: 1200px;
    height: 590px;
    z-index: 0;
    pointer-events: none;
}

/* Rows */

.row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:90px;
    position:relative;
    z-index:2;
}

.row.reverse{
    flex-direction:row-reverse;
}

/* Images */

.image{
    width:387px;
}

.image img{
    width:100%;
    height:280px;
    object-fit:cover;
    border-radius:15px;
    display:block;
}

/* Content */

.journey-content{
    width:361px;
}

.journey-content p{
    font-size:20px;
    color:#2E3A2E;
    line-height:1.7;
}

/* Tablet */

@media (max-width:1024px){

    .journey-container{
        max-width:900px;
    }

    .image{
        width:320px;
    }

    .image img{
        height:230px;
    }

    .journey-content{
        width:320px;
    }

    .journey-content p{
        font-size:18px;
    }

    .path-image{
        top:130px;
        width:95%;
    }

}

/* Mobile */

@media (max-width:768px){

    .path-image{
        display:none;
    }

    .row,
    .row.reverse{
        flex-direction:column;
        gap:25px;
        text-align:center;
        margin-bottom:60px;
    }

    .image,
    .journey-content{
        width:100%;
    }

    .image img{
        width:100%;
        height:auto;
    }

    .journey h2{
        font-size:28px;
        margin-bottom:50px;
    }

    .journey-content p{
        width:100%;
        font-size:17px;
    }

}

</style>
@endsection