@extends('layouts.app')

@section('title', 'Contact Us – Get Travel Booking Help at English Traveller')

@section('meta_description', 'Need help with flights, hotels or tour bookings? Our friendly team is one call away to answer your queries and guide you to the right travel option today.')


@section('content')
<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>Contact <span>Us</span></h1>

            <p>
               We welcome you warm-heartedly to the English Traveller. We are an independent travel related information provider.

            </p>
            
             <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="banner-breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                       contact Us
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<style>
.contact-banner {
    background: url("/images/et_contact_us_bg.webp") center center / cover no-repeat;
    height: 260px;
    position: relative;
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
    color: #ffffff;
    padding: 0 10px;
}

.banner-breadcrumb .breadcrumb-item a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.banner-breadcrumb .breadcrumb-item a:hover {
    color: #fff;
}

.contact-banner .overlay{
    position: absolute;
    inset: 0;
    background: rgb(88 54 36 / 95%); /* Brown transparent overlay */
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

    <section class="contact-section">
    <div class="contact-container">

        <div class="contact-wrapper">

            <!-- Left Image -->
            <div class="contact-image">
                <img src="{{ asset('images/image 2296.png') }}" alt="Contact">
            </div>

            <!-- Right Form -->
            <div class="contact-form">
                <form>

                    <input type="text" placeholder="Your Name">

                    <input type="email" placeholder="Email ID">

                    <input type="text" placeholder="Project Name">

                    <textarea placeholder="Message"></textarea>

                    <button type="submit">
                        Send Message
                    </button>

                </form>
            </div>

        </div>

    </div>
</section>

<style>
.contact-section{
    background:#f6efe2;
    padding:70px 0;
    position:relative;
    margin-top: 55px;
}

/* Optional background illustration */
.contact-section::before{
    content:"";
    position:absolute;
    inset:0;
    background:url('{{ asset("images/travel-bg.png") }}') center center no-repeat;
    background-size:cover;
    opacity:.08;
}

.contact-container{
    max-width:1200px;
    margin:auto;
    padding:0 20px;
    position:relative;
    z-index:2;
}

.contact-wrapper{
     background: #FFF2DA url("images/image 2274.png") no-repeat center center;
    /* background-size: cover; */
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 60px;
    /* width: 967px; */
    height: 609px;
    border-radius: 20px;
}

/* Left Image */

.contact-image{
    background:#fff;
    padding:8px;
    border-radius:8px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.contact-image img{
      width: 488px;
    height: 524px;
    object-fit:cover;
    border-radius:5px;
    display:block;
}

/* Right Form */

.contact-form{
    width:380px;

    padding:18px;
}

.contact-form input,
.contact-form textarea{

    width: 448px;
  
    border: 1px solid #C68542;
    padding: 18px 5px;
    margin-bottom: 42px;
    outline: none;
    font-size: 14px;
    background: #fff;
    border-radius: 7px;
}

.contact-form textarea{
    resize:none;
    height:118px;
}

.contact-form button{

    width:448px;
    height:45px;
    border:none;
    background:#9b6234;
    color:#fff;
    font-size:15px;
    font-weight:600;
    border-radius:30px;
    cursor:pointer;
    transition:.3s;
}

.contact-form button:hover{
    background:#7f4d25;
}

/* Mobile (up to 767px) */
@media (max-width: 767px) {

    .contact-section{
        padding: 40px 15px;
    }

    .contact-wrapper{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
        width: 100%;
        height: auto;
        padding: 30px 20px;
        background-size: cover;
    }

    .contact-form input,
.contact-form textarea{

    width: 279px;
  
    border: 1px solid #C68542;
    padding: 18px 5px;
    margin-bottom: 42px;
    outline: none;
    font-size: 14px;
    background: #fff;
    border-radius: 7px;
}

    .contact-image{
        width: 100%;
        order: 1;
    }

    .contact-image img{
        width: 100%;
        height: auto;
        display: block;
        border-radius: 10px;
    }

    .contact-form{
        width: 100%;
        order: 2;
        padding: 0;
    }

    .contact-form input,
    .contact-form textarea{
        padding: 16px;
        margin-bottom: 20px;
    }

  .contact-form button {
    width: 200px;
    height: 50px;
    display: block;
    margin: 0 auto;

    }
}
</style>


<section class="map-section">
    <div class="map-container">

        <!-- Left -->
        <div class="map-info">

            <h2>For any Query, get in Touch with us</h2>

            <p class="map-desc">
                <span>Get In Touch</span><br>
                You can contact us anytime regarding any airline-related issue and the different travel inquiries. Our team is here to help you out. 
                <a href="tel:+18444263848">Call Now.</a>
            </p>

            <div class="map-boxes">
                <div class="mapicon">
                    <i class="fa-solid fa-phone"></i>
                </div>

       <div>
    <h4>Phone No.</h4>
    <p>
        <a href="tel:+18444263848" class="phone-link">
            +1-844-426-3848
        </a>
    </p>
</div>
            </div>

            <div class="divider"></div>

            <div class="map-boxes">
                <div class="mapicon">
                    <i class="fa-solid fa-envelope"></i>
                </div>

             <div>
    <h4>E-mail</h4>
    <p>
        <a href="mailto:info@englishtraveller.us" class="email-link">
            info@englishtraveller.us
        </a>
    </p>
</div>
            </div>

            <div class="map-divider"></div>

            <div class="map-boxes">
                <div class="mapicon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div>
                    <h4>Location</h4>
                    <p>273 Park St, NY</p>
                </div>
            </div>

            <div class="mapsocial-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>

        </div>

        <!-- Right -->
        <div class="map-box">
           <div class="map">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799142145!2d-74.25986768746338!3d40.69767006368105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c250b0fcb7c2cf%3A0x6d8d4b5b8a6b2b4!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1710000000000"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
        </div>

    </div>
</section>

<style>
.map-section{
    padding:60px 0;
}

.map-container{
    width:1150px;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:70px;
}

.map-info{
    width:45%;
}

.map-info h2{
    font-size:34px;
    color:#6d3b1f;
    font-weight:600;
    margin-bottom:18px;
}

.map iframe{
   width: 532px;
    height: 500px;
    border: none;
    border-radius: 20px;
    margin-left: 19px
}

.map-desc{
    color:#777;
    font-size:14px;
    line-height:1.7;
    margin-bottom:28px;
}

.map-desc span{
    color:#d6a548;
    font-weight:600;
}

.map-desc a{
    color:#8a5b2f;
    text-decoration:none;
    font-weight:600;
}

.map-box{
    /* display:flex; */
    align-items:flex-start;
    gap:18px;
    padding:12px 0;
        background: #FFF2DA;
            border-radius: 20px;
}

.map-boxes{
    display:flex;
    align-items:flex-start;
    gap:18px;
    padding:12px 0;
   
}


.mapicon{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#e8c188;
    color:#7d5225;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:15px;
    flex-shrink:0;
}

.map-box h4{
    font-size:15px;
    color:#555;
    margin-bottom:3px;
}

.map-box p{
    color:#777;
    font-size:14px;
}

.map-divider{
    height:1px;
    background:#ececec;
    margin-left:58px;
}

.mapsocial-icons{
    display:flex;
    gap:18px;
    margin-top:22px;
}

.mapsocial-icons a{
 width: 38px;
    height: 38px;
    border: 1px solid #b07b38;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    color: #2E3A2E;
    margin-right: 8px;
    transition: .3s;
        text-decoration: none;
}

.mapsocial-icons a:hover{
    color:#b9833d;
}

.map-box{
    width:50%;
}

.map-box img{
    width:100%;
    border-radius:18px;
    display:block;
}

.phone-link {
    color: inherit;
    text-decoration: none;
}

.phone-link:hover {
    text-decoration: none;
}

.email-link {
    color: inherit;
    text-decoration: none;
}

.email-link:hover {
    text-decoration: none;
}

/* ==========================
   Responsive (768px)
========================== */
@media (max-width: 768px) {

    .map-section{
        padding:40px 15px;
    }

    .map-container{
        width:100%;
        flex-direction:column;
        gap:30px;
    }

    .map-info,
    .map-box{
        width:100%;
    }

    .map-info h2{
        font-size:28px;
        margin-bottom:15px;
    }

    .map-desc{
        font-size:15px;
        margin-bottom:20px;
    }

    .map-boxes{
        gap:15px;
        padding:10px 0;
    }

    .mapicon{
        width:38px;
        height:38px;
        font-size:14px;
    }

    .map-divider{
        margin-left:55px;
    }

    .map iframe{
        width:100%;
        height:400px;
        margin-left:0;
        border-radius:20px;
    }

    .mapsocial-icons{
        justify-content:flex-start;
        flex-wrap:wrap;
        gap:12px;
    }

    .mapsocial-icons a{
        width:38px;
        height:38px;
        margin-right:0;
    }
}

    </style>
@endsection