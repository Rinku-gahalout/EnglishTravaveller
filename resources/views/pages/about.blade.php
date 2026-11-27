@extends('layouts.app')

@section('title', 'About Us – Your Trusted Travel Guide at English Traveller')

@section('meta_description', 'English Traveller helps USA travelers plan smarter trips with updated travel information, simple booking guidance and genuine customer care. Know us better.')


@section('content')
<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>About <span>Us</span></h1>

            <p>
                We welcome you to the English Traveler. We are an independent travel information provider. 
            </p>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="banner-breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        About Us
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<style>
.contact-banner {
    background: url("/images/et_about_us_bg_img.webp")
        center center / cover no-repeat;
    width: 100%;
    height: 260px;
    position: relative;
}

.contact-banner .overlay{
    position: absolute;
    inset: 0;
    background: rgb(88 54 36 / 88%); /* Brown transparent overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.banner-breadcrumb {
    margin-top: 20px;
}

.banner-breadcrumb .breadcrumb {
    background: transparent;
    justify-content: center;
}

.banner-breadcrumb .breadcrumb-item,
.banner-breadcrumb .breadcrumb-item.active {
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}

.banner-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #fff;
    padding: 0 10px;
}

.banner-breadcrumb .breadcrumb-item a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.banner-breadcrumb .breadcrumb-item a:hover {
    color: #fff;
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
                <h2>
                   Let’s Discover the World With Us:
                </h2>

                <p>
                 At English Traveler, we think air travel should be affordable, easy, and reachable for everyone. 
                 Whether you are setting up a family vacation, a business trip, or that last minute getaway ,
                 we’re here to help you track cheap flights without losing the convenience part.
                </p>

                <p>
                  Our setup is meant to make booking flights feel uncomplicated. We try to link travelers with
                  solid airfare options across domestic as well as international destinations.
                  From checking fares to browsing airline choices, we focus on keeping each part
                  of your booking flow smooth and, if possible, low stress.
                </p>
                
                <p>Our aim isn’t just to help you snag a ticket. We also want you to travel with confidence, like fully steady in your plans.</p>
            </div>

            <div class="airline-right">
                <div class="about-image">
                    <div class="blob">
                        <img src="{{ asset('images/about_us.webp') }}" alt="About Image">
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

.airline-left h2{
    font-size:42px;
    color:#6d4023;
    line-height:1.25;
    margin-bottom:25px;
    font-weight:700;
}

.airline-left p{
    color:#38312c;
    font-size:17px;
    line-height:1.7;
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




<section class="about-mission-section">
    <div class="about-mission-container">

        <!-- WHO WE ARE -->
        <div class="about-info-card">

            <div class="about-card-heading">
                <div class="about-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="3"/>
                        <path d="M5 20v-1a7 7 0 0 1 14 0v1"/>
                        <path d="M5 11a3 3 0 0 0-3 3v2h3"/>
                        <path d="M19 11a3 3 0 0 1 3 3v2h-3"/>
                        <path d="M5 8a2 2 0 1 1 0 4"/>
                        <path d="M19 8a2 2 0 1 0 0 4"/>
                    </svg>
                </div>

                <div class="about-heading-content">
                    <h2>Who We Are</h2>
                    <span class="heading-line"></span>
                </div>
            </div>

            <div class="about-card-content">
                <p>
                    English Traveler is this kind of airline focused travel
                    platform that helps people uncover more budget-friendly
                    flight choices. We know that no trip is truly the same,
                    and honestly, the needs of each traveler don’t line up
                    either. Because of that, we try to keep things flexible,
                    so you can book in different ways, get competitive fares,
                    and still have travel details that actually matter all
                    in one place.
                </p>

                <p>
                    Our crew is really into travel and we care about, fixing
                    up the entire reservation stuff in a smooth kind of way.
                    We watch airfare trends and the latest travel news, almost
                    like a steady pulse all the time, so our customers can
                    notice better deals earlier, and also make more thoughtful
                    choices before they even board.
                </p>

                <p>
                    No matter if you’re traveling for work, vacation, study,
                    or just to go see family and close friends, English
                    Traveler is here to help make your whole journey
                    more affordable.
                </p>
            </div>

            <div class="card-corner-decoration"></div>
        </div>


        <!-- OUR MISSION -->
        <div class="about-info-card">

            <div class="about-card-heading">
                <div class="about-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <circle cx="12" cy="12" r="5"/>
                        <circle cx="12" cy="12" r="1.5"/>
                        <path d="m13.5 10.5 7-7"/>
                        <path d="M16 3.5h4v4"/>
                    </svg>
                </div>

                <div class="about-heading-content">
                    <h2>Our Mission</h2>
                    <span class="heading-line"></span>
                </div>
            </div>

            <div class="about-card-content">
                <p>
                    Our mission is kind of simple I guess— we aim to make
                    air travel more accessible, by assisting travelers in
                    locating affordable flights with less friction.
                </p>

                <p>
                    We spend our time on delivering a smooth booking flow
                    while also sharing dependable travel information that
                    helps customers plan, feel steady, and move forward
                    with confidence. Honestly, we think every person should
                    have the chance to wander toward fresh horizons without
                    paying extra than they really need.
                </p>

                <p>
                    So by bringing together competitive flight choices and
                    a user-friendly experience, we want to turn into a trusted
                    travel companion for everyone who’s traveling, even if
                    the plans are spontaneous.
                </p>
            </div>

            <div class="card-corner-decoration"></div>
        </div>

    </div>
</section>


<style>



/* ==========================================
   ABOUT & MISSION SECTION
========================================== */

.about-mission-section {
    padding: 85px 20px;
    background: #faf7f3;
    position: relative;
    overflow: hidden;
}

.about-mission-container {
    max-width: 1320px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 35px;
    align-items: stretch;
}

/* ==========================================
   MAIN CARDS
========================================== */

.about-info-card {
    position: relative;
    background: #fffdfb;
    padding: 40px 38px 45px;
    border: 1px solid #dfcbbb;
    border-radius: 24px;
    box-shadow: 0 8px 28px rgba(91, 53, 29, 0.08);
    overflow: hidden;
    transition: all 0.35s ease;
    z-index: 1;
}

.about-info-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 15px 35px rgba(91, 53, 29, 0.13);
    border-color: #98633f;
}

/* ==========================================
   CARD HEADING
========================================== */

.about-card-heading {
    display: flex;
    align-items: center;
    gap: 22px;
    margin-bottom: 28px;
}

.about-icon {
    width: 78px;
    height: 78px;
    min-width: 78px;
    border-radius: 50%;
    background: #70401f;
    color: #fffaf5;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 15px rgba(112, 64, 31, 0.20);
    transition: all 0.35s ease;
}

.about-icon svg {
    width: 39px;
    height: 39px;
}

.about-info-card:hover .about-icon {
    background: #93613e;
    transform: rotate(-5deg);
}

.about-heading-content {
    flex: 1;
    min-width: 0;
}

.about-heading-content h2 {
    color: #70401f;
   
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
    white-space: nowrap;
}

.heading-line {
    display: block;
    height: 2px;
    width: 100%;
    max-width: 190px;
    background: linear-gradient(
        to right,
        #70401f,
        #c49a79
    );
    margin-top: 13px;
    transition: max-width 0.35s ease;
}

.about-info-card:hover .heading-line {
    max-width: 100%;
}

/* ==========================================
   CARD PARAGRAPHS
========================================== */

.about-card-content {
    position: relative;
    z-index: 2;
}

.about-card-content p {
    color: #38312c;
    font-family: Arial, sans-serif;
    font-size: 17px;
    line-height: 1.8;
    margin: 0 0 17px;
    text-align: left;
}

.about-card-content p:last-child {
    margin-bottom: 0;
}

/* ==========================================
   DECORATIVE CORNER
========================================== */

.card-corner-decoration {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 105px;
    height: 8px;
    background: #70401f;
    border-top-left-radius: 30px;
}

.card-corner-decoration::before {
    content: "";
    position: absolute;
    right: 110px;
    bottom: 0;
    width: 35px;
    height: 8px;
    background: #c9a78e;
    transform: skewX(-35deg);
}

.card-corner-decoration::after {
    content: "";
    position: absolute;
    right: 155px;
    bottom: 0;
    width: 15px;
    height: 8px;
    background: #e9d9ca;
    transform: skewX(-35deg);
}

/* ==========================================
   RESPONSIVE DESIGN
========================================== */

@media (max-width: 991px) {

    .about-mission-section {
        padding: 65px 20px;
    }

    .about-mission-container {
        gap: 25px;
    }

    .about-info-card {
        padding: 30px 25px 38px;
    }

    .about-heading-content h2 {
        font-size: 27px;
    }

    .about-icon {
        width: 65px;
        height: 65px;
        min-width: 65px;
    }

    .about-icon svg {
        width: 32px;
        height: 32px;
    }

    .about-card-content p {
        font-size: 17px;
    }
}

@media (max-width: 767px) {

    .about-mission-section {
        padding: 45px 16px;
    }

    .about-mission-container {
        grid-template-columns: 1fr;
        gap: 22px;
    }

    .about-info-card {
        padding: 27px 22px 35px;
        border-radius: 18px;
    }

    .about-card-heading {
        gap: 16px;
        margin-bottom: 22px;
    }

    .about-heading-content h2 {
        font-size: 25px;
    }

    .about-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
    }

    .about-icon svg {
        width: 29px;
        height: 29px;
    }

    .heading-line {
        max-width: 130px;
        margin-top: 9px;
    }

    .about-card-content p {
        font-size: 17px;
        line-height: 1.75;
        margin-bottom: 15px;
    }
}

@media (max-width: 380px) {

    .about-info-card {
        padding: 23px 17px 32px;
    }

    .about-heading-content h2 {
        font-size: 22px;
    }

    .about-card-heading {
        gap: 12px;
    }
}

    </style>


<section class="et-offer-section">
    <div class="et-offer-container">

        <!-- Left Image Section -->
        <div class="et-offer-image-wrapper">
            <div class="et-image-decoration"></div>

          <div class="et-main-image">
    <img
        src="{{ asset('images/Rectangle 34627277.png') }}"
        alt="English Traveller flight booking assistance at airport"
        loading="eager"
        width="650"
        height="750"
        style="width: 100%; height: auto; display: block;"
    >
</div>

 <div class="et-image-bottom-shape"></div>
        </div>

        <!-- Right Content Section -->
        <div class="et-offer-content">

            <div class="et-section-label">
                <span>WHAT WE OFFER</span>
                <div></div>
            </div>

            <h2>
                Make Your Journey
                <span>Hassle-Free</span>
            </h2>

            <div class="et-heading-underline"></div>

            <p class="et-offer-description">
              We make sure that our customers get the best services while traveling.
               With English Traveller, you will get affordable flight tickets for both
                domestic and international destinations. You will also get easy flight booking option, best and most competitive airfare deals.
               Everything on a single platform is the way of making everything smoother for you.
            </p>

            <p class="et-offer-description">
              The complete process is simple, fast, and secure. If you get confused, then you do not need to worry.
               Our customer support team is there to help you. We aim to make your traveling experience a memorable 
               one by saving your time and money.
            </p>

            <!-- Services Grid -->
            <div class="et-services-grid">

                <div class="et-service-card">
                    <div class="et-service-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M2 16L22 5M8 13L4 21L11 17M12 10L18 3L22 5L16 12M8 13L2 16"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h4>Board Range</h4>
                        <p>For Flight Options</p>
                    </div>
                </div>

                <div class="et-service-card">
                    <div class="et-service-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 22S20 18 20 11V5L12 2L4 5V11C4 18 12 22 12 22Z"
                                stroke="currentColor" stroke-width="1.7"/>
                            <path d="M8 12L11 15L16 9"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h4>Safe Booking</h4>
                        <p>Secure for booking</p>
                    </div>
                </div>

                <div class="et-service-card">
                    <div class="et-service-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="5" width="18" height="16" rx="2"
                                stroke="currentColor" stroke-width="1.7"/>
                            <path d="M7 2V7M17 2V7M3 10H21M8 14H8.01M12 14H12.01M16 14H16.01M8 17H8.01M12 17H12.01"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h4>Calendar</h4>
                        <p>Last-Minute Deals</p>
                    </div>
                </div>

                <div class="et-service-card">
                    <div class="et-service-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M3 13V11C3 6.03 7.03 2 12 2S21 6.03 21 11V13"
                                stroke="currentColor" stroke-width="1.7"/>
                            <rect x="2" y="11" width="4" height="7" rx="2"
                                stroke="currentColor" stroke-width="1.7"/>
                            <rect x="18" y="11" width="4" height="7" rx="2"
                                stroke="currentColor" stroke-width="1.7"/>
                            <path d="M21 18C21 20 19 21 16 21H13"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <h4>Customer Support</h4>
                        <p>Headset Care</p>
                    </div>
                </div>

                <div class="et-service-card">
                    <div class="et-service-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="6" width="18" height="14" rx="2"
                                stroke="currentColor" stroke-width="1.7"/>
                            <path d="M16 14H21M7 6V4C7 2.9 7.9 2 9 2H15"
                                stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round"/>
                            <circle cx="16" cy="14" r="1"
                                fill="currentColor"/>
                        </svg>
                    </div>
                    <div>
                        <h4>Time and Money</h4>
                        <p>Saving on flight tickets</p>
                    </div>
                </div>

               
<div class="et-service-card">
    <div class="et-service-icon">
        <svg viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M2.5 9L6.5 5.5L10 7L13 6L17.5 5.5L21.5 9"
                  stroke="currentColor"
                  stroke-width="1.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>

            <path d="M2.5 9L7.5 16L10 14.5L12 17L14 15L16 16L21.5 9"
                  stroke="currentColor"
                  stroke-width="1.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>

            <path d="M7.5 16L6 17.5L8 19L10 17.5"
                  stroke="currentColor"
                  stroke-width="1.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>

            <path d="M10 14.5L13 17.5L15 15.5"
                  stroke="currentColor"
                  stroke-width="1.7"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
    </div>

    <div>
        <h4>Reliable Services</h4>
        <p>You can trust us </p>
    </div>
</div>


            </div>

            <!-- CTA Button -->
            <div class="et-offer-bottom">
                <a href="{{ url('/contact') }}" class="et-offer-button">
                    Start Your Journey
                    <span>→</span>
                </a>
                <div class="et-button-line"></div>
            </div>

        </div>
    </div>

</section>


<style>



/* ==========================================
   ENGLISH TRAVELLER - WHAT WE OFFER
   Premium Brown Theme
========================================== */

.et-offer-section {
    position: relative;
    width: 100%;
    padding: 40px 5%;
    background: #fff8ef;
    overflow: hidden;
    isolation: isolate;
}

.et-offer-container {
    max-width: 1400px;
    margin: auto;
    display: grid;
    grid-template-columns: 0.9fr 1.1fr;
    align-items: center;
    gap: 75px;
    position: relative;
    z-index: 2;
}

/* LEFT IMAGE */

.et-offer-image-wrapper {
    position: relative;
    padding: 25px 20px 35px 0;
}

.et-image-decoration {
    position: absolute;
    left: -25px;
    width: 85%;
    height: 90%;
    background: #75421f;
    border-radius: 35px 80px 35px 80px;
    transform: rotate(-5deg);
    z-index: -1;
}

.et-main-image {
    position: relative;
    width:  587px;
    height: 570px;
    border: 5px solid #fff;
    border-radius: 25px 65px 25px 65px;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(74, 40, 24, 0.2);
}

.et-main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.7s ease;
}

.et-main-image:hover img {
    transform: scale(1.05);
}

/* IMAGE BADGE */

.et-travel-badge {
    position: absolute;
    bottom: 15px;
    right: -10px;
    width: 175px;
    height: 175px;
    border-radius: 50%;
    background: #172b43;
    border: 5px solid #d8b58a;
    outline: 5px solid #fff8ef;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    z-index: 3;
}

.et-travel-badge h3 {
    color: #fff;
    font-family: Georgia, serif;
    font-size: 26px;
    line-height: 1.05;
    margin: 5px 0;
}

.et-travel-badge p {
    color: #e2bd8d;
    font-size: 13px;
    font-style: italic;
    margin: 2px 0;
}

.et-travel-badge strong {
    color: #e7bd87;
    font-family: Georgia, serif;
    font-size: 14px;
    font-style: italic;
}

.et-badge-star {
    color: #e7bd87;
    font-size: 18px;
}

.et-badge-line {
    width: 65px;
    height: 1px;
    background: #d8b58a;
    margin: 3px 0;
}

/* RIGHT CONTENT */

.et-offer-content {
    position: relative;
    z-index: 2;
}

.et-section-label {
    display: flex;
    align-items: center;
    gap: 28px;
    margin-bottom: 22px;
}

.et-section-label span {
    background: #75421f;
    color: #fff;
    padding: 12px 25px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 3px;
}

.et-section-label div {
    flex: 1;
    height: 1px;
    background: #a77b54;
}

.et-offer-content h2 {
    color: #172b43;
  font-size: 42px;
    font-weight: 700;
    line-height: 1.25;
    margin: 0 0 15px;
}

.et-offer-content h2 span {
    display: block;
    color: #75421f;
   
    font-size: 1.12em;
}

.et-heading-underline {
    width: 110px;
    height: 5px;
    border-radius: 10px;
    background: #75421f;
    margin-bottom: 25px;
}

.et-offer-description {
    color: #26364a;
    font-size: 17px;
    line-height: 1.8;
    margin: 0 0 17px;
}

/* SERVICES GRID */

.et-services-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 32px;
}

.et-service-card {
    min-height: 100px;
    padding: 15px 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.55);
    border: 1px solid #e5c9a9;
    border-radius: 20px;
    transition: all 0.35s ease;
}

.et-service-card:hover {
    background: #75421f;
    border-color: #75421f;
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(117,66,31,0.18);
}

.et-service-icon {
    flex: 0 0 52px;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #75421f;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.35s ease;
}

.et-service-icon svg {
    width: 27px;
    height: 27px;
}

.et-service-card:hover .et-service-icon {
    background: #fff;
    color: #75421f;
}

.et-service-card h4 {
    color: #172b43;
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 5px;
    transition: color 0.35s ease;
}

.et-service-card p {
    color: #26364a;
    font-size: 13px;
    margin: 0;
    line-height: 1.4;
    transition: color 0.35s ease;
}

.et-service-card:hover h4,
.et-service-card:hover p {
    color: #fff;
}

/* BUTTON */

.et-offer-bottom {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-top: 32px;
}

.et-offer-button {
    min-width: 280px;
    padding: 17px 30px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    background: linear-gradient(135deg, #75421f, #4a2818);
    color: #fff !important;
    text-decoration: none !important;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    transition: all 0.35s ease;
    box-shadow: 0 8px 20px rgba(74,40,24,0.2);
}

.et-offer-button span {
    font-size: 27px;
    line-height: 1;
    transition: transform 0.3s ease;
}

.et-offer-button:hover {
    background: #172b43;
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(23,43,67,0.2);
}

.et-offer-button:hover span {
    transform: translateX(6px);
}

.et-button-line {
    flex: 1;
    height: 1px;
    background: #c8a17a;
}

/* DECORATIVE ELEMENTS */

.et-plane-decoration {
    position: absolute;
    top: 25px;
    left: 43%;
    color: #75421f;
    font-size: 55px;
    transform: rotate(-15deg);
    opacity: 0.8;
    z-index: 1;
    pointer-events: none;
}

.et-bottom-decoration {
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 350px;
    height: 180px;
    background: #172b43;
    border-top: 12px solid #75421f;
    border-radius: 50%;
    transform: rotate(-10deg);
    opacity: 0.95;
    z-index: 0;
    pointer-events: none;
}


/* ==========================================
   RESPONSIVE DESIGN - WHAT WE OFFER
   Premium Brown Theme
========================================== */

/* Tablet: 1024px */
@media (max-width: 1024px) {

    .et-offer-section {
        padding: 50px 4%;
    }

    .et-offer-container {
        grid-template-columns: 0.9fr 1.1fr;
        gap: 35px;
    }

    .et-main-image {
        width: 100%;
        height: 480px;
    }

    .et-travel-badge {
        width: 145px;
        height: 145px;
        right: -5px;
    }

    .et-travel-badge h3 {
        font-size: 22px;
    }

    .et-offer-content h2 {
        font-size: 34px;
    }

    .et-services-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .et-service-card {
        min-height: 90px;
    }

    .et-offer-button {
        min-width: 230px;
        font-size: 16px;
    }
}


/* ==========================================
   TABLET: 768px
========================================== */

@media (max-width: 768px) {

    .et-offer-section {
        padding: 55px 25px;
    }

    .et-offer-container {
        grid-template-columns: 1fr;
        gap: 45px;
    }

    /* IMAGE */

    .et-offer-image-wrapper {
        width: 100%;
        max-width: 550px;
        margin: auto;
        padding: 15px 15px 25px 0;
    }

    .et-image-decoration {
        left: -10px;
        width: 85%;
        height: 90%;
    }

    .et-main-image {
        width: 100%;
        height: 480px;
        border-radius: 25px 55px 25px 55px;
    }

    .et-main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .et-travel-badge {
        width: 140px;
        height: 140px;
        right: 0;
        bottom: 5px;
    }

    .et-travel-badge h3 {
        font-size: 21px;
    }

    .et-travel-badge p {
        font-size: 12px;
    }

    /* CONTENT */

    .et-offer-content {
        width: 100%;
    }

    .et-section-label {
        gap: 15px;
        margin-bottom: 18px;
    }

    .et-section-label span {
        padding: 10px 20px;
        font-size: 12px;
        letter-spacing: 2px;
    }

    .et-offer-content h2 {
        font-size: 36px;
        line-height: 1.25;
    }

    .et-offer-content h2 span {
        font-size: 1.08em;
    }

    .et-offer-description {
        font-size: 17px;
        line-height: 1.8;
    }

    /* SERVICES */

    .et-services-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
        margin-top: 25px;
    }

    .et-service-card {
        min-height: 95px;
        padding: 13px 12px;
        gap: 10px;
    }

    .et-service-icon {
        flex: 0 0 45px;
        width: 45px;
        height: 45px;
    }

    .et-service-icon svg {
        width: 23px;
        height: 23px;
    }

    .et-service-card h4 {
        font-size: 14px;
    }

    .et-service-card p {
        font-size: 12px;
    }

    /* BUTTON */

    .et-offer-bottom {
        gap: 15px;
        margin-top: 28px;
    }

    .et-offer-button {
        min-width: 220px;
        padding: 15px 22px;
        font-size: 16px;
        gap: 15px;
    }

    .et-offer-button span {
        font-size: 23px;
    }

    .et-plane-decoration {
        top: 15px;
        left: auto;
        right: 25px;
        font-size: 40px;
    }

    .et-bottom-decoration {
        width: 250px;
        height: 130px;
    }
}


/* ==========================================
   MOBILE: 576px
========================================== */

@media (max-width: 576px) {

    .et-offer-section {
        padding: 40px 18px;
    }

    .et-offer-container {
        gap: 35px;
    }

    .et-offer-image-wrapper {
        max-width: 100%;
        padding: 12px 10px 20px 0;
    }

    .et-main-image {
        height: 380px;
        border-width: 4px;
        border-radius: 20px 45px 20px 45px;
    }

    .et-travel-badge {
        width: 115px;
        height: 115px;
        border-width: 3px;
        outline-width: 3px;
        bottom: 0;
        right: 0;
    }

    .et-travel-badge h3 {
        font-size: 18px;
        margin: 3px 0;
    }

    .et-travel-badge p {
        font-size: 10px;
    }

    .et-travel-badge strong {
        font-size: 11px;
    }

    .et-badge-star {
        font-size: 14px;
    }

    .et-badge-line {
        width: 45px;
    }

    .et-section-label {
        gap: 10px;
    }

    .et-section-label span {
        padding: 9px 16px;
        font-size: 11px;
        letter-spacing: 1.5px;
    }

    .et-offer-content h2 {
        font-size: 29px;
    }

    .et-heading-underline {
        width: 85px;
        height: 4px;
        margin-bottom: 18px;
    }

    .et-offer-description {
        font-size: 17px;
        line-height: 1.7;
    }

    .et-services-grid {
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 22px;
    }

    .et-service-card {
        min-height: 82px;
        padding: 12px 15px;
    }

    .et-service-icon {
        flex: 0 0 45px;
        width: 45px;
        height: 45px;
    }

    .et-service-card h4 {
        font-size: 15px;
    }

    .et-service-card p {
        font-size: 12px;
    }

    .et-offer-bottom {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        margin-top: 25px;
    }

    .et-offer-button {
        width: 100%;
        min-width: unset;
        padding: 15px 20px;
        font-size: 15px;
    }

    .et-button-line {
        display: none;
    }

    .et-plane-decoration {
        font-size: 30px;
        right: 15px;
        top: 10px;
    }

    .et-bottom-decoration {
        width: 180px;
        height: 100px;
        bottom: -65px;
        left: -70px;
    }
}


/* ==========================================
   SMALL MOBILE: 375px
========================================== */

@media (max-width: 375px) {

    .et-offer-section {
        padding: 35px 14px;
    }

    .et-main-image {
        height: 320px;
    }

    .et-travel-badge {
        width: 100px;
        height: 100px;
    }

    .et-travel-badge h3 {
        font-size: 16px;
    }

    .et-travel-badge p {
        font-size: 9px;
    }

    .et-offer-content h2 {
        font-size: 26px;
    }

    .et-section-label span {
        font-size: 10px;
        padding: 8px 13px;
    }

    .et-service-card {
        padding: 10px;
    }

    .et-offer-button {
        font-size: 14px;
    }
}

    </style>



<section class="journey">

    <div class="journey-container">

        <h2>Why Choose English Traveler?</h2>

        <p class="journey-para">
            Picking the proper travel platform really can make all the difference,
            like in a not so obvious way.<br>
            At English Traveler, we’re all about value,
            convenience and, honestly, customer satisfaction too.
        </p>

        <!-- Connector Image -->
        <img src="{{ asset('images/Vector 1 (1).png') }}"
             alt=""
             class="path-image">

        <!-- Row 1 -->
        <div class="journey-row">

            <div class="image">
                <img src="{{ asset('images/journey_matter_1.webp') }}" alt="">
            </div>

            <div class="journey-content">
                <h3>Affordable Flight Deals</h3>
                <p>
                    We help you find budget-friendly airfare options,
                    so you can go further and see more while spending less
                    which is kinda the whole point.
                </p>
            </div>

        </div>

        <!-- Row 2 -->
        <div class="journey-row journey-row-reverse">

            <div class="image">
                <img src="{{ asset('images/journey_matter_3.webp') }}" alt="">
            </div>

            <div class="journey-content">
                <h3>Simple Booking Experience</h3>
                <p>
                    Our platform is built so you can search, compare,
                    and then reserve your flights quickly. No extra hurdles,
                    no needless complexity.
                </p>
            </div>

        </div>

        <!-- Row 3 -->
        <div class="journey-row">

            <div class="image">
                <img src="{{ asset('images/journey_matter_3.webp') }}" alt="">
            </div>

            <div class="journey-content">
                <h3>Reliable Travel Information</h3>
                <p>
                    We share useful travel info that stays current and practical.
                    That way, your trip planning feels a bit smarter,
                    and your booking choices are informed, not guesswork.
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
    padding-bottom: 8px;
}

.journey-para{
  font-size: 17px;
    color: #2E3A2E;
    line-height: 1.7;
    margin-bottom: 37px;
        text-align: center;
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

.journey-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 90px;
    position: relative;
    z-index: 2;
}

.journey-row-reverse {
    flex-direction: row-reverse;
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
    font-size:17px;
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

  .journey-row,
    .journey-row-reverse {
        flex-direction: column;
        gap: 25px;
        text-align: center;
        margin-bottom: 60px;
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


<section class="commitment-section">

    <div class="commitment-container">

        <div class="commitment-box">

            <h2>Our Commitment</h2>

            <p>
             At English Traveler, we try to make every trip feel a bit easier , more affordable, 
             and also more enjoyable. We keep improving our services, broaden our travel options,
             and aim to deliver better value to our customers, day after day.
            </p>

            <p>
              Whether you are planning for your first flight or you are a regular
              traveler who is looking for the best airfare. This website will help you a lot. 
              English Traveller is your trusted guide for finding budget-friendly flights and 
              turning your everyday plan into an unforgettable trip. 
            </p>

        </div>

    </div>

</section>

<style>
/* =========================================
   OUR COMMITMENT SECTION
========================================= */

.commitment-section {
    position: relative;

    width: 100%;
    height: 492px;

    background-image: url("../images/Rectangle 34627278.png");
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;

    display: flex;
    align-items: center;
    margin-bottom: 77px;
    overflow: hidden;
}


/* =========================================
   CONTAINER
========================================= */

.commitment-container {
    width: 100%;
    max-width: 1200px;

    margin: 0 auto;

    padding: 0 35px;
}


/* =========================================
   BROWN CONTENT BOX
========================================= */

.commitment-box {
    width: 612px;

    padding: 25px 28px;

    background: rgba(166, 112, 48, 0.88);

    color: #ffffff;

    box-sizing: border-box;
}


/* =========================================
   HEADING
========================================= */

.commitment-box h2 {
    margin: 0 0 10px;

    font-family: Arial, sans-serif;

    font-size: 36px;
    font-weight: 700;

    line-height: 1.2;

    color: #ffffff;
}


/* =========================================
   PARAGRAPHS
========================================= */

.commitment-box p {
    margin: 0 0 8px;

  

        font-size: 17px;
    font-weight: 400;

    line-height: 1.45;

    color: #ffffff;

    text-align: left;
}

.commitment-box p:last-child {
    margin-bottom: 0;
}


/* =========================================
   TABLET
========================================= */

@media (max-width: 991px) {

    .commitment-section {
        min-height: 360px;
    }

    .commitment-container {
        padding: 0 25px;
    }

    .commitment-box {
        width: 470px;

        padding: 24px 25px;
    }

    .commitment-box h2 {
        font-size: 22px;
    }

    .commitment-box p {
        font-size: 11px;
    }
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767px) {

    .commitment-section {
        min-height: auto;

        padding: 45px 0;

        background-position: center center;
    }

    .commitment-container {
        padding: 0 20px;
    }

    .commitment-box {
        width: 100%;

        padding: 22px 20px;

        background: rgba(166, 112, 48, 0.90);
    }

    .commitment-box h2 {
        font-size: 21px;

        margin-bottom: 12px;
    }

    .commitment-box p {
        font-size: 12px;

        line-height: 1.55;

        margin-bottom: 10px;
    }
}
    </style>
@endsection