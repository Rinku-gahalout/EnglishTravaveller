@extends('layouts.app')

@section('title', 'Cheap Flights & Exclusive Deals - Book with EnglishTraveller')

@section('meta_description', 'Book affordable domestic and international flights with EnglishTraveller. Explore competitive fares, special offers and convenient booking with travel support.')

@section('meta_keywords', 'Book Flights Ticket, Flight Booking, online flight ticket booking, Flights, airlines tickets')

@section('canonical', url('/'))

@section('og_type', 'website')

@section('og_url', url('/'))

@section('og_title', 'Cheap Flights & Exclusive Deals - Book with EnglishTraveller')

@section('og_description', 'Book affordable domestic and international flights with EnglishTraveller. Explore competitive fares, special offers and convenient booking with travel support.')

{{-- LCP FIX #1: preload the hero image (responsive) so the browser fetches it immediately.
     Requires `@stack('head')` inside <head> in layouts/app.blade.php --}}
@push('head')
    <link rel="preload" as="image" fetchpriority="high"
          href="/images/hero-1920.webp"
          imagesrcset="/images/hero-640.webp 640w, /images/hero-1024.webp 1024w, /images/hero-1920.webp 1920w"
          imagesizes="100vw">
@endpush

@section('content')

    {{-- =============================================================
     HTML
============================================================== --}}

    {{-- =============================== --}}
    {{-- BOOKING SECTION                 --}}
    {{-- =============================== --}}
    <section class="booking-section">

        {{-- LCP FIX #2: responsive srcset, fetchpriority=high, async decode, descriptive alt --}}
       <img
    src="/images/image.webp"
    srcset="
        /images/image-640.webp 640w,
        /images/image-1024.webp 1024w,
        /images/image.webp 1920w
    "
    sizes="100vw"
    class="booking-hero"
    width="1920"
    height="800"
    fetchpriority="high"
    loading="eager"
    decoding="async"
    alt="Airplane flying above the clouds at sunset">

        <div class="booking-content">

            <div class="booking-text">
                <h1>Make Your Flight Booking Easy</h1>
                <p>
                   Fly with Confidence, soar beyond expectations. Your trusted path to every destination.
                </p>
            </div>

            <div class="booking-form">
                <div class="trip-type">
                    <label>
                        <input type="radio" name="trip" value="return" checked>
                        Return
                    </label>

                    <label>
                        <input type="radio" name="trip" value="oneway">
                        One-way
                    </label>
                </div>

                <form>
                    {{-- Above-the-fold icons: no loading="lazy", explicit size --}}
                    <div class="input-box form-field">
                        <input type="text" class="floating-input" id="cityField" required>
                        <label class="floating-label" for="cityField" data-text="Enter city or airport"></label>
                        <img src="{{ asset('images/airplane.png') }}" width="25" height="25" alt="airplane">
                    </div>

                    <div class="input-box form-field">
                        <input type="text" class="floating-input" id="destField" required>
                        <label class="floating-label" for="destField" data-text="Enter destination"></label>
                        <img src="{{ asset('images/plane.png') }}" width="25" height="25" alt="plane">
                    </div>

                    <div class="input-box">
                        <label for="passengers" class="visually-hidden">
                            Passengers
                        </label>

                        <select id="passengers" name="passengers">
                            <option value="">Passenger</option>
                            <option value="1">1 Adult</option>
                            <option value="2">2 Adults</option>
                            <option value="3">3 Adults</option>
                        </select>

                        <img src="{{ asset('images/profile.png') }}" width="25" height="25" alt="profile" aria-hidden="true">
                    </div>

                    <div class="date-group">

                        <div class="input-box">
                            <label for="departDate" class="visually-hidden">
                                Departure Date
                            </label>

                            <input
                                type="date"
                                id="departDate"
                                name="departDate"
                                aria-label="Departure Date"
                            >

                            <img src="{{ asset('images/calendar.png') }}" width="25" height="25" alt="calendar" aria-hidden="true">
                        </div>

                        <div class="input-box" id="returnDateBox">
                            <label for="returnDate" class="visually-hidden">
                                Return Date
                            </label>

                            <input
                                type="date"
                                id="returnDate"
                                name="returnDate"
                                aria-label="Return Date"
                            >

                            <img src="{{ asset('images/calendar.png') }}" width="25" height="25" alt="calendar" aria-hidden="true">
                        </div>

                    </div>

                    <button type="submit">
                        Search Now
                        <img
                            src="{{ asset('images/search-normal.png') }}"
                            width="25"
                            height="25"
                            alt=""
                            aria-hidden="true"
                        >
                    </button>
                </form>
            </div>

        </div>
    </section>

    {{-- =============================== --}}
    {{-- ABOUT SECTION                   --}}
    {{-- =============================== --}}
    <section class="about" id="aboutSection">
        <div class="about-container">

            <!-- Left -->
            <div class="about-image">
                <div class="blob">
                    <img src="{{ asset('images/about_us.webp') }}" loading="lazy" alt="About Image">
                </div>

                <div class="circle circle1">
                    <img src="{{ asset('images/about_us_ellipse_1.webp') }}" loading="lazy" alt="Destination highlight 1">
                </div>

                <div class="circle circle2">
                    <img src="{{ asset('images/about_us_ellipse_2.webp') }}" loading="lazy" alt="Destination highlight 2">
                </div>

                <div class="circle circle3">
                    <img src="{{ asset('images/about_us_ellipse_3.webp') }}" loading="lazy" alt="Destination highlight 3">
                </div>
            </div>

            <!-- Right -->
            <div class="about-contents">

                <span class="about-subtitle reveal-item">About Us</span><br>

                <h2 class="reveal-item">
                    Discover the World With Us
                </h2>

                <p class="reveal-item">
                 In English Traveller, we built a journey that makes your every moment memorable. 
                 We built that into every traveler thinks about before flying: a price that you can trust,
                 and a person whom you can call when your schedule changes.
                </p>

                <a href="{{ route('about') }}" class="btn reveal-item" aria-label="Read more about English Traveller">
                    Read more
                    <span>→</span>
                </a>

            </div>

        </div>

        <div class="dots"></div>
    </section>

    {{-- ============================= --}}
    {{-- STACKING SCROLL CARDS SECTION --}}
    {{-- ============================= --}}
    <section class="stack-section">
        <div class="swiper mobileSwiper">
            <div class="swiper-wrapper">

                <!-- CARD 1 -->
                <div class="stack-card card1 swiper-slide" data-stack-card>
                    <div class="stack-container">
                        <div class="international-container">

                            <div class="image-box reveal-left">
                                <img src="{{ asset('images/flights_to_sanfransico.webp') }}" loading="lazy" alt="San Francisco">
                            </div>

                            <div class="stack-content reveal-right">
                                <div class="number" data-number="01">01</div>

                                <span class="sub-title">
                                    Explore Different Destinations
                                </span>

                                <h2>Fly to San Francisco</h2>

                                <p>
                                    Explore the world-famous Golden Gate Bridge, the historic federal prison, 
                                    and winding block of Lombard Street through our flights to San Francisco.
                                    Book your best flight at a low cost.
                                </p>

                                <a href="#" class="btn" aria-label="Read more about flights to San Francisco">
                                    Read more <span>↗</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="stack-card card2 swiper-slide" data-stack-card>
                    <div class="stack-container">
                        <div class="international-container">

                            <div class="image-box reveal-left">
                                <img src="{{ asset('images/flights_to_paris.webp') }}" loading="lazy" alt="Paris">
                            </div>

                            <div class="stack-content reveal-right">
                                <div class="number" data-number="02">02</div>

                                <span class="sub-title">
                                    Explore destination
                                </span>

                                <h2>Flights to Paris</h2>

                                <p>
                                   Get best rates on flights to Paris.
                                   Explore the best places to be visited in Paris.
                                   And also different ways to book the affordable flight tickets.
                                </p>

                                <a href="#" class="btn" aria-label="Read more about flights to Paris">
                                    Read more <span>↗</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="stack-card card3 swiper-slide" data-stack-card>
                    <div class="stack-container">
                        <div class="international-container">

                            <div class="image-box reveal-left">
                                <img src="{{ asset('images/flights_to_tokyo.webp') }}" loading="lazy" alt="Tokyo">
                            </div>

                            <div class="stack-content reveal-right">
                                <div class="number" data-number="03">03</div>

                                <span class="sub-title">
                                    Explore destination
                                </span>

                                <h2>Flights to Tokyo</h2>

                                <p>
                                    Get Budget-Friendly prices on the flights to Tokyo. 
                                    Get to know morew about the best places, and cheap booking options.
                                </p>

                                <a href="#" class="btn" aria-label="Read more about flights to Tokyo">
                                    Read more <span>↗</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>
        </div>
    </section>

    {{-- =============================== --}}
    {{-- DESTINATION SLIDER              --}}
    {{-- =============================== --}}
    <section class="destination" id="destinationSection">
        <div class="destination-container">

            <span class="sub-title reveal-item">Explore destination</span>

            <h2 class="reveal-item">Book Affordable Flights to Ohio</h2>

            <p class="description reveal-item">
                Discover the Cedar Point, museums, and wildlife sanctuary of Ohio with us. 
                By booking the affordable flights, passengers can enjoy the beauty of this great city.
            </p>

            <div class="swiper destination-swiper reveal-item">

                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/australia.webp') }}" loading="lazy" alt="Columbus">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/australia.webp') }}" loading="lazy" alt="Columbus">
                                    <div class="flip-card-caption">
                                        <h3>Columbus</h3>
                                        <p>Explore the city</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/brazil.webp') }}" loading="lazy" alt="Cleveland">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/brazil.webp') }}" loading="lazy" alt="Cleveland">
                                    <div class="flip-card-caption">
                                        <h3>Cleveland</h3>
                                        <p>Lakefront views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/new_york.webp') }}" loading="lazy" alt="Cincinnati">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/new_york.webp') }}" loading="lazy" alt="Cincinnati">
                                    <div class="flip-card-caption">
                                        <h3>Cincinnati</h3>
                                        <p>Historic charm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/australia.webp') }}" loading="lazy" alt="Dayton">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/australia.webp') }}" loading="lazy" alt="Dayton">
                                    <div class="flip-card-caption">
                                        <h3>Dayton</h3>
                                        <p>Aviation heritage</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/brazil.webp') }}" loading="lazy" alt="Toledo">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/brazil.webp') }}" loading="lazy" alt="Toledo">
                                    <div class="flip-card-caption">
                                        <h3>Toledo</h3>
                                        <p>Glass City views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ asset('images/new_york.webp') }}" loading="lazy" alt="Akron">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('images/new_york.webp') }}" loading="lazy" alt="Akron">
                                    <div class="flip-card-caption">
                                        <h3>Akron</h3>
                                        <p>Rubber capital</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Optional Pagination -->
                <div class="swiper-pagination"></div>

            </div>

            <a href="#" class="view-btn reveal-item" aria-label="View all Ohio destinations">
                View all
                <span>↗</span>
            </a>

        </div>
    </section>

    {{-- =============================== --}}
    {{-- BLOGS SECTION                   --}}
    {{-- =============================== --}}
    <section class="blogs-section" id="blogsSection">
        <div class="blogs-container">

            <p class="sub-heading reveal-item">Explore blogs</p>

            <h2 class="reveal-item">Our Blogs</h2>

            <p class="description reveal-item">
               Whether you are traveling to Ohio, San Francisco, or Paris, 
               explore the best destinations to travel through our blogs. 
               Know the various flight options to book the best. 
            </p>

<div class="blogs-grid reveal-item">

    @forelse($blogs as $blog)

        @php
            $categorySlug = $blog->subcategory?->slug ?? $blog->category?->slug;

            // Priority 1: blog_url
            // Priority 2: slug generated from blog_heading
            $blogSlug = !empty($blog->blog_url)
                ? $blog->blog_url
                : \Illuminate\Support\Str::slug($blog->blog_heading);
        @endphp

        {{-- Skip blog if category or blog slug is unavailable --}}
        @continue(empty($categorySlug) || empty($blogSlug))

        <a href="{{ route('blogdetails', [
            'cate_subcate' => $categorySlug,
            'blog_slug'    => $blogSlug,
        ]) }}"
           class="blogs-card">

            <div class="blogs-img-wrap">
                <img
                    src="{{ asset($blog->image) }}"
                    loading="lazy"
                    alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
                >
            </div>

            <div class="blog-content">
                <h3>{{ $blog->blog_heading }}</h3>

                <span class="blog-read-more">
                    Read more <i>↗</i>
                </span>
            </div>

        </a>

    @empty

        <p>No blogs found.</p>

    @endforelse

</div>

            @if ($blogs->isNotEmpty())
                <div class="blogs-btn reveal-item">
                    <a href="{{ route('categoryblogs', ['cate_subcate' => $blogs->first()->category->slug]) }}" aria-label="View all blogs">
                        View all
                        <span>↗</span>
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- =============================== --}}
    {{-- TESTIMONIAL SECTION             --}}
    {{-- =============================== --}}
    <section class="testimonial-section" id="testimonialSection">
    <div class="testimonial-container">

        <!-- Left Content -->
        <div class="left">

            <span class="subtitle reveal-item">Client says</span>

            <h2 class="reveal-item">Our Client Saying!</h2>

            <p class="reveal-item">
                Unlock the affordable flight rates to travel all over the US.
                Learn about more places to discover.
            </p>

            <h3 class="reveal-item">Trusted by 400K Customers</h3>

            <div class="rating reveal-item">
                <span class="stars-row">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </span>
                <span class="rating-text">4.8 (450 Reviews)</span>
            </div>

            <div class="arrow reveal-item">
                <img src="{{ asset('images/Vector 1.png') }}" loading="lazy" alt="Curved Arrow">
            </div>

        </div>

        <!-- Right Cards -->
        <div class="cards">

            <!-- Card 1 -->
            <div class="card">
                <img src="https://randomuser.me/api/portraits/men/11.jpg" width="55" height="55" loading="lazy" alt="TESTIMONIAL">
                <h3>By Nick</h3>
                <div class="stars">★★★★★</div>
                <p>
                  I was fully impressed by the work of the team. 
                  They helped me a lot in getting the cheap flights and securing the best flight deals.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="card move-down">
                <img src="https://randomuser.me/api/portraits/women/12.jpg" width="55" height="55" loading="lazy" alt="TESTIMONIAL">
                <h3>By Kylin </h3>
                <div class="stars">★★★★★</div>
                <p>
                    The pricing of the flight for English Travellers is clear from the start.
                    There are no surprise fees while checking out. Their service is more than excellent.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <img src="https://randomuser.me/api/portraits/men/31.jpg" width="55" height="55" loading="lazy" alt="TESTIMONIAL">
                <h3>By William</h3>
                <div class="stars">★★★★★</div>
                <p>
                    This website is totally user-friendly.
                    It makes my flight experience more efficient and simple. 
                    Their budget-friendly deals help me to make my whole journey hassle-free.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="card move-down">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" width="55" height="55" loading="lazy" alt="TESTIMONIAL">
                <h3>By Jenny</h3>
                <div class="stars">★★★★★</div>
                <p>
                   My experience of booking my flights from English Traveller is mind-blowing. 
                   The team is understanding, responsive, and delivers excellence in their work.
                </p>
            </div>

        </div>

    </div>
</section>

    {{-- =============================== --}}
    {{-- FAQ SECTION                     --}}
    {{-- =============================== --}}
    <section class="faq-section">
        <div class="faq-container">

            <div class="faq-left">

                <h2>Frequently Asked Questions:</h2>

                <p class="faq-subtitle">
                   Get your budget-friendly flights all over the US. 
                   Know about the different places and the best possible way to book your cheap flights.
                </p>

                <div class="accordion">

                    <div class="accordion-item active">
                        <button class="accordion-header">
                            What kinds of trips can you actually book?
                            <span class="arrow">&#9662;</span>
                        </button>
                        <div class="accordion-body">
                           Anything from a single one-way ticket to a full multi-city loop across three countries.
                           We work the same 500+ airlines whether it's a quick weekend hop or a longer international trip,
                           and if splitting your route into two separate tickets would save you money, the agent will say so 
                           upfront instead of just selling you the round trip.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            What's included in the fare I see?
                            <span class="arrow">&#9662;</span>
                        </button>
                        <div class="accordion-body">
                       The price shown includes base fare and taxes. Optional extras like checked 
                       bags or seat selection are shown separately before you pay.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            Can I change my dates after booking?
                            <span class="arrow">&#9662;</span>
                        </button>
                        <div class="accordion-body">
                            It depends on the airline's fare rules, which we show you before you book.
                            Call our agents any time to check change or refund options.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                           Do you offer group or family discounts?
                            <span class="arrow">&#9662;</span>
                        </button>
                        <div class="accordion-body">
                            Yes — ask an agent about rates for group and family bookings when you call.
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            How do I book?
                            <span class="arrow">&#9662;</span>
                        </button>
                        <div class="accordion-body">
                           Search online and book directly, or call +1-844-426-3868 to book with an agent over the phone.
                        </div>
                    </div>

                </div>
            </div>

            <div class="faq-right">
                <img src="{{ asset('images/Group 1597884705.png') }}" loading="lazy" alt="FAQ Image">
            </div>

        </div>
    </section>

    {{-- =============================== --}}
    {{-- DISCLAIMER SECTION              --}}
    {{-- =============================== --}}
    <section class="disclaimer-section">
        <div class="disclaimer-container">
            <p>
                <strong>Disclaimer:</strong> englishtraveller.us is an independent platform that helps the user 
                to get budget-friendly ticket prices on all the main airlines. We aim to save the money of our 
                users on their international flight tickets. Also, we are not responsible for any losses or damage,
                including, without limitation, indirect loss or damage due to data or profits arising from, or in 
                connection with the use of our website. With the help of our website, you can link to other websites that are not under the 
                control of the English Traveller. The nature, content, and the availability of those sites are beyond our control. For any queries, call us at 
                <a href="tel:+18444263868">+1-844-426-3868</a>, and you will get the best assistance available.
            </p>
        </div>
    </section>

    {{-- =============================================================
     CSS
============================================================== --}}
    <style>
        /* ================================================
           BOOKING SECTION — LCP-OPTIMISED
        ================================================= */

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .booking-section {
            position: relative;
            display: flex;
            align-items: center;
            padding: 80px 8%;
            overflow: hidden;
            z-index: 1;
            min-height: 650px;
        }

        /* LCP FIX #3: no animation until the page has loaded (body.loaded is added by JS),
           and the animation uses transform (compositor-only) instead of background-size */
        .booking-hero {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: -2;
            transform-origin: center;
        }

        body.loaded .booking-hero {
            will-change: transform;
            animation: bgZoom 12s ease-in-out infinite alternate;
        }

        @keyframes bgZoom {
            from { transform: scale(1); }
            to   { transform: scale(1.08); }
        }

        /* Overlay */
        .booking-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background: #a5663d73;
            z-index: -1;
        }

        .booking-content {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 217px;
        }

        /* --- Text column ---
           LCP FIX #4: NO opacity:0 on the hero text. Chrome ignores elements at opacity 0
           for LCP, so the headline is now visible from first paint; only transform animates. */
        .booking-text {
            color: #fff;
            max-width: 450px;
            animation: slideInLeft 0.8s ease both;
        }

     .booking-text h1 {
    font-size: 62px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 15px;

    display: block;
    opacity: 1;
    visibility: visible;
    transform: none;
    animation: none;
    transition: none;
}

        .booking-text p {
            line-height: 1.7;
            font-size: 18px;
        }

        @keyframes slideInLeft {
            from { transform: translateX(-40px); }
            to   { transform: translateX(0); }
        }

        /* --- Booking form container (transform-only entrance, always visible) --- */
        .booking-form {
            width: 613px;
            background: rgb(255 255 255 / 56%);
            padding: 25px;
            border-radius: 12px;
            height: 500px;
            animation: slideInRight 0.8s ease 0.1s both;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .booking-form:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        @keyframes slideInRight {
            from { transform: translateX(40px); }
            to   { transform: translateX(0); }
        }

        /* --- Trip type toggle --- */
        .trip-type {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 30px;
            padding: 6px;
            width: fit-content;
        }

        .trip-type label {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            white-space: nowrap;
            padding: 8px 22px;
            border-radius: 24px;
            font-size: 26px;
            font-weight: 500;
            color: #6C3F2A;
            transition: transform 0.25s ease, color 0.3s ease, background 0.3s ease;
        }

        .trip-type label:hover {
            transform: scale(1.08);
        }

        .trip-type input[type="radio"] {
            width: auto !important;
            height: auto !important;
            margin: 0;
            display: none;
        }

        .trip-type label:has(input:checked) {
            color: #fff;
            background: #a5663d;
            box-shadow: 0 4px 12px rgba(165, 102, 61, 0.4);
            animation: pillPop 0.35s ease;
        }

        @keyframes pillPop {
            0%   { transform: scale(0.9); }
            60%  { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* --- Generic input-box wrapper (select + date fields) --- */
        .input-box {
            position: relative;
            width: 100%;
            opacity: 0;
            transform: translateY(15px);
            animation: fieldRise 0.6s ease forwards;
        }

        .booking-form .input-box:nth-of-type(1) { animation-delay: 0.3s; }
        .booking-form .input-box:nth-of-type(2) { animation-delay: 0.4s; }
        .booking-form .input-box:nth-of-type(3) { animation-delay: 0.5s; }
        .booking-form .date-group { animation-delay: 0.6s; }

        @keyframes fieldRise {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .booking-form input,
        .booking-form select {
            width: 100%;
            height: 50px;
            margin-bottom: 38px;
            padding: 0 45px 0 15px;
            border: 1px solid #ddd;
            border-bottom: 2px solid transparent;
            border-radius: 6px;
            outline: none;
            color: #6C3F2A;
            background: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }

        .input-box input:focus,
        .input-box select:focus {
            border-color: #ddd;
            border-bottom: 2px solid #a5663d;
            box-shadow: 0 0 0 3px rgba(165, 102, 61, 0.15), 0 6px 14px -6px rgba(165, 102, 61, 0.4);
            background: #fffdf9;
        }

        .input-box input::placeholder {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .input-box input:focus::placeholder {
            opacity: 0.5;
            transform: translateX(4px);
        }

        .date-group {
            display: flex;
            gap: 10px;
            opacity: 0;
            transform: translateY(15px);
            animation: fieldRise 0.6s ease forwards;
        }

        .date-group input {
            margin-bottom: 0;
        }

        /* Hide default calendar icon */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Hide default select arrow */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .input-box img {
            position: absolute;
            right: 15px;
            top: 30%;
            transform: translateY(-50%);
            width: 25px;
            height: auto;
            cursor: pointer;
            z-index: 2;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .input-box input:focus+img,
        .input-box select:focus+img {
            transform: translateY(-50%) scale(1.15) rotate(-8deg);
            filter: drop-shadow(0 2px 4px rgba(165, 102, 61, 0.4));
        }

        /* --- Shake animation for invalid fields --- */
        .input-box.shake {
            animation: shakeField 0.4s ease;
        }

        @keyframes shakeField {
            0%, 100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            40%      { transform: translateX(6px); }
            60%      { transform: translateX(-4px); }
            80%      { transform: translateX(4px); }
        }

        /* ================================================
           FLOATING LETTER-LABEL INPUTS (city / destination)
        ================================================= */
        .form-field {
            position: relative;
        }

        .floating-input {
            background: transparent !important;
            border: none !important;
            border-bottom: 2px solid #ddd !important;
            border-radius: 0 !important;
            padding: 0 45px 0 5px !important;
        }

        .floating-input:focus,
        .floating-input:valid {
            border-bottom: 2px solid #a5663d !important;
        }

        .floating-label {
            position: absolute;
            left: 5px;
            top: 40%;
            transform: translateY(-50%);
            display: flex;
            pointer-events: none;
            z-index: 1;
            font-weight: 600;
        }

        .floating-label span {
            display: inline-block;
            font-size: 16px;
            color: #6C3F2A;
            opacity: 0.6;
            white-space: pre;
            transition: transform 0.35s ease, color 0.35s ease, font-size 0.35s ease, opacity 0.35s ease;
        }

        .floating-input:focus+.floating-label span,
        .floating-input:valid+.floating-label span {
            color: #a5663d;
            opacity: 1;
            transform: translateY(-26px);
            font-size: 12px;
            font-weight: 600;
        }

        .floating-input:focus~img,
        .floating-input:valid~img {
            transform: translateY(-50%) scale(1.15) rotate(-8deg);
            filter: drop-shadow(0 2px 4px rgba(165, 102, 61, 0.4));
        }

        /* --- Submit button --- */
        .booking-form button {
            width: 100%;
            margin-top: 20px;
            height: 45px;
            border: none;
            border-radius: 6px;
            background: #8b5e3c;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(15px);
            animation: fieldRise 0.6s ease forwards;
            animation-delay: 0.7s;
            transition: background 0.3s ease, transform 0.15s ease, box-shadow 0.3s ease;
        }

        .booking-form button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .booking-form button:hover::before {
            left: 130%;
        }

        .booking-form button:hover {
            background: #6f472d;
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(139, 94, 60, 0.4);
        }

        .booking-form button:active {
            transform: scale(0.97);
        }

        .booking-form button img {
            width: 25px;
            height: 25px;
            object-fit: contain;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .booking-form button:hover img {
            transform: translateX(4px);
        }

        /* --- Ripple circle (JS-generated on click) --- */
        .ripple-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: rippleEffect 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes rippleEffect {
            to {
                transform: scale(3);
                opacity: 0;
            }
        }

        /* ================================================
           RESPONSIVE — LARGE DESKTOP / LAPTOP
        ================================================= */
        @media (max-width: 1400px) {
            .booking-content { gap: 120px; }
        }

        @media (max-width: 1200px) {
            .booking-content { gap: 70px; }
            .booking-text h1 { font-size: 54px; }
            .booking-form { width: 550px; }
        }

        /* ================================================
           RESPONSIVE — TABLET
        ================================================= */
        @media (max-width: 1024px) {
            .booking-content { gap: 40px; }
            .booking-text h1 { font-size: 46px; }

            .booking-form {
                width: 480px;
                height: auto;
            }

            .trip-type label {
                font-size: 22px;
                padding: 8px 18px;
            }
        }

        @media (max-width: 900px) {
            .booking-content {
                flex-direction: column;
                text-align: center;
                gap: 40px;
            }

            .booking-text { max-width: 100%; }

            .booking-form {
                width: 100%;
                max-width: 550px;
            }

            .trip-type { margin: 0 auto 20px; }
        }

        /* ================================================
           RESPONSIVE — MOBILE (LANDSCAPE / SMALL TABLET)
        ================================================= */
        @media (max-width: 768px) {

            .booking-section { padding: 50px 20px; }

            /* No hero zoom on mobile (selector matches the specificity of the rule above) */
            body.loaded .booking-hero {
                animation: none;
                will-change: auto;
            }

            .booking-content {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }

            .booking-text { max-width: 100%; }

            .booking-text h1 {
                font-size: 36px;
                line-height: 1.3;
            }

            .booking-text p {
                font-size: 15px;
                line-height: 1.6;
            }

            .booking-form {
                width: 100%;
                max-width: 500px;
                height: auto;
                padding: 20px;
            }

            .trip-type {
                justify-content: center;
                gap: 6px;
                flex-wrap: wrap;
                margin: 0 auto 20px;
            }

            .trip-type label {
                font-size: 16px;
                padding: 8px 16px;
            }

            .booking-form input,
            .booking-form select {
                height: 45px;
                margin-bottom: 20px;
                font-size: 14px;
                padding: 0 40px 0 12px;
            }

            .floating-input { padding: 0 40px 0 5px !important; }

            .floating-label span { font-size: 14px; }

            .floating-input:focus+.floating-label span,
            .floating-input:valid+.floating-label span {
                font-size: 11px;
                transform: translateY(-22px);
            }

            .date-group {
                flex-direction: column;
                gap: 20px;
            }

            .date-group input { width: 100%; }

            .booking-form button {
                height: 50px;
                font-size: 16px;
                margin-top: 20px;
            }

            /* Tighter stagger so the form finishes revealing faster on mobile */
            .booking-form .input-box:nth-of-type(1) { animation-delay: 0.15s; }
            .booking-form .input-box:nth-of-type(2) { animation-delay: 0.25s; }
            .booking-form .input-box:nth-of-type(3) { animation-delay: 0.35s; }
            .booking-form .date-group { animation-delay: 0.45s; }
            .booking-form button { animation-delay: 0.55s; }
        }

        /* ================================================
           RESPONSIVE — SMALL MOBILE
        ================================================= */
        @media (max-width: 480px) {

            .booking-section { padding: 40px 15px; }

            .booking-text h1 { font-size: 28px; }
            .booking-text p { font-size: 14px; }

            .trip-type label {
                font-size: 14px;
                padding: 7px 12px;
            }

            .booking-form { padding: 15px; }

            .booking-form input,
            .booking-form select {
                font-size: 13px;
                height: 42px;
            }

            .floating-label span { font-size: 13px; }

            .floating-input:focus+.floating-label span,
            .floating-input:valid+.floating-label span {
                font-size: 10px;
                transform: translateY(-20px);
            }

            .booking-form button {
                font-size: 15px;
                height: 46px;
            }

            .booking-form button img {
                width: 20px;
                height: 20px;
            }

            .input-box img {
                width: 20px;
                height: auto;
            }
        }

        @media (max-width: 360px) {
            .booking-text h1 { font-size: 24px; }

            .trip-type { gap: 2px; }

            .trip-type label {
                font-size: 12px;
                padding: 6px 10px;
            }
        }

        /* ================================================
           ACCESSIBILITY — REDUCED MOTION
        ================================================= */
        @media (prefers-reduced-motion: reduce) {

            body.loaded .booking-hero,
            .booking-section,
            .booking-text,
            .booking-text h1,
            .booking-text p,
            .booking-form,
            .booking-form .input-box,
            .booking-form .date-group,
            .booking-form button,
            .trip-type label:has(input:checked),
            .floating-label span {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ================================
           ABOUT SECTION
        ================================= */
        .about {
            padding: 47px 0;
            position: relative;
            overflow: hidden;
        }

        .about-container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 70px;
        }

        /* --- LEFT: image block --- */
        .about-image {
            width: 50%;
            position: relative;
            min-height: 550px;
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }

        .about.in-view .about-image {
            opacity: 1;
            transform: translateX(0);
        }

        .blob {
            width: 100%;
            height: 100%;
            animation: blobFloat 6s ease-in-out infinite;
        }

        .blob img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        .blob:hover img {
            transform: scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
        }

        @keyframes blobFloat {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-14px); }
        }

        /* --- Circle accent images --- */
        .circle {
            position: absolute;
            border-radius: 50%;
            overflow: hidden;
            border: 8px solid #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
            opacity: 0;
            transform: scale(0.6);
            transition: opacity 0.6s ease, transform 0.6s ease;
            z-index: 3;
        }

        .about.in-view .circle {
            opacity: 1;
            transform: scale(1);
        }

        .circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .circle:hover img {
            transform: scale(1.15);
        }

        .circle1 {
            width: 170px;
            height: 170px;
            top: 40px;
            left: -60px;
            transition-delay: 0.2s;
            animation: circleFloat1 5s ease-in-out infinite;
            animation-delay: 0.9s;
        }

        .circle2 {
            width: 165px;
            height: 165px;
            bottom: 20px;
            left: 40px;
            transition-delay: 0.35s;
            animation: circleFloat2 6s ease-in-out infinite;
            animation-delay: 1.1s;
        }

        .circle3 {
            width: 150px;
            height: 150px;
            right: -35px;
            top: 120px;
            transition-delay: 0.5s;
            animation: circleFloat3 5.5s ease-in-out infinite;
            animation-delay: 1.3s;
        }

        @keyframes circleFloat1 {
            0%, 100% { transform: scale(1) translateY(0); }
            50%      { transform: scale(1) translateY(-12px); }
        }

        @keyframes circleFloat2 {
            0%, 100% { transform: scale(1) translateY(0); }
            50%      { transform: scale(1) translateY(10px); }
        }

        @keyframes circleFloat3 {
            0%, 100% { transform: scale(1) translateX(0); }
            50%      { transform: scale(1) translateX(-8px); }
        }

        /* --- RIGHT: text content --- */
        .about-contents {
            width: 50%;
        }

        .about-subtitle {
            color: #9c5a2c;
            font-size: 18px;
            font-weight: 600;
        }

        .about-contents h2 {
            margin: 15px 0 25px;
            font-size: 37px;
            line-height: 1.2;
            color: #6C3F2A;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .about-contents h2::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            height: 3px;
            width: 0;
            background: #a5663d;
            border-radius: 2px;
            transition: width 0.7s ease 0.6s;
        }

        .about.in-view .about-contents h2::after {
            width: 70px;
        }

        .about-contents p {
            color: #2E3A2E;
            line-height: 30px;
            font-size: 20px;
            margin-bottom: 35px;
        }

        /* --- Staggered reveal for text items --- */
        .reveal-item {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .about.in-view .reveal-item:nth-of-type(1) { transition-delay: 0.1s; }
        .about.in-view .reveal-item:nth-of-type(2) { transition-delay: 0.25s; }
        .about.in-view .reveal-item:nth-of-type(3) { transition-delay: 0.4s; }
        .about.in-view .reveal-item:nth-of-type(4) { transition-delay: 0.55s; }

        .about.in-view .reveal-item {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- Button: shine sweep + lift on hover --- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 35px;
            border-radius: 40px;
            text-decoration: none;
            background: #a5663d;
            color: #fff;
            font-size: 20px;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 130%;
        }

        .btn:hover {
            background: #8f5532;
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(165, 102, 61, 0.35);
        }

        .btn span {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .btn:hover span {
            transform: translateX(5px);
        }

        /* --- Dots: rotation + fade in --- */
        .dots {
            position: absolute;
            right: -100px;
            bottom: -120px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background-image: radial-gradient(#eddccf 2px, transparent 2px);
            background-size: 16px 16px;
            opacity: 0;
            transition: opacity 1s ease 0.4s;
            animation: dotsRotate 40s linear infinite;
        }

        .about.in-view .dots {
            opacity: .8;
        }

        @keyframes dotsRotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* RESPONSIVE — TABLET */
        @media (max-width: 1024px) {
            .about-container { gap: 40px; }
            .about-contents h2 { font-size: 32px; }

            .circle1 { width: 140px; height: 140px; left: -40px; }
            .circle2 { width: 130px; height: 130px; left: 20px; }
            .circle3 { width: 120px; height: 120px; right: -20px; }
        }

        /* RESPONSIVE — MOBILE */
        @media (max-width: 768px) {

            .about { padding: 50px 20px; }

            .about-container {
                flex-direction: column;
                gap: 40px;
                text-align: center;
            }

            .about-image,
            .about-contents { width: 100%; }

            .about-image {
                min-height: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                transform: translateY(-30px);
            }

            .about.in-view .about-image { transform: translateY(0); }

            .blob {
                width: 320px;
                height: 320px;
                animation-duration: 5s;
            }

            /* Hide decorative circles on mobile to avoid clutter/overflow */
            .circle { display: none; }

            .about-contents h2 {
                font-size: 30px;
                margin: 15px 0;
            }

            .about-contents h2::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .about-contents p {
                font-size: 16px;
                line-height: 28px;
                margin-bottom: 25px;
            }

            .about-subtitle { font-size: 16px; }

            .btn {
                padding: 14px 28px;
                font-size: 18px;
            }

            .dots { display: none; }

            .about.in-view .reveal-item:nth-of-type(1) { transition-delay: 0.05s; }
            .about.in-view .reveal-item:nth-of-type(2) { transition-delay: 0.15s; }
            .about.in-view .reveal-item:nth-of-type(3) { transition-delay: 0.25s; }
            .about.in-view .reveal-item:nth-of-type(4) { transition-delay: 0.35s; }
        }

        @media (max-width: 480px) {
            .about-contents h2 { font-size: 26px; }

            .about-contents p {
                font-size: 14px;
                line-height: 24px;
            }

            .btn {
                padding: 12px 24px;
                font-size: 16px;
            }

            .blob {
                width: 260px;
                height: 260px;
            }
        }

        /* ACCESSIBILITY — REDUCED MOTION
           (fixed: the old rule forced width:70px on every element in this list) */
        @media (prefers-reduced-motion: reduce) {

            .about-image,
            .circle,
            .circle1,
            .circle2,
            .circle3,
            .reveal-item,
            .about-contents h2::after,
            .dots,
            .blob {
                transition: none !important;
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }

            .about-contents h2::after {
                width: 70px !important;
            }
        }


        /* ================================
           STACKING SCROLL CARDS SECTION
        ================================= */
        .stack-section {
            position: relative;
        }

        .stack-card {
            position: sticky;
            top: 0;
            min-height: 550px;
            display: flex;
            align-items: center;
            padding: 50px 0;
            margin-bottom: 85px;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        /* 1200px centered container */
        .stack-container {
            width: 1200px;
            max-width: 95%;
            margin: 0 auto;
        }

        .international-container {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 70px;
        }

        /* --- Image box --- */
        .image-box {
            width: 55%;
            opacity: 0;
            transform: translateX(-60px) scale(0.95);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }

        .stack-card.in-view .image-box {
            opacity: 1;
            transform: translateX(0) scale(1);
        }

        .image-box img {
            width: 85%;
            display: block;
            border-radius: 16px;
            height: 500px;
            object-fit: cover;
            transition: transform 0.6s ease, box-shadow 0.6s ease;
        }

        .image-box:hover img {
            transform: scale(1.02);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
        }

        /* --- Text content --- */
        .stack-content {
            width: 45%;
            opacity: 0;
            transform: translateX(60px);
            transition: opacity 0.9s ease 0.15s, transform 0.9s ease 0.15s;
        }

        .stack-card.in-view .stack-content {
            opacity: 1;
            transform: translateX(0);
        }

        /* --- Number: pop-in --- */
        .number {
            font-size: 70px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 10px;
            display: inline-block;
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.6s ease 0.3s, transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s;
        }

        .stack-card.in-view .number {
            opacity: 1;
            transform: scale(1);
        }

        .sub-title {
            display: block;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s ease 0.45s, transform 0.6s ease 0.45s;
        }

        .stack-card.in-view .sub-title {
            opacity: 1;
            transform: translateY(0);
        }

        .stack-content h2 {
            font-size: 38px;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s ease 0.55s, transform 0.6s ease 0.55s;
        }

        .stack-card.in-view .stack-content h2 {
            opacity: 1;
            transform: translateY(0);
        }

        .stack-content p {
            font-size: 20px;
            line-height: 30px;
            margin-bottom: 35px;
            max-width: 450px;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s ease 0.65s, transform 0.6s ease 0.65s;
        }

        .stack-card.in-view .stack-content p {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- Button --- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 40px;
            text-decoration: none;
            background: #9c6037;
            color: #fff;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s ease 0.75s, transform 0.6s ease 0.75s,
                background 0.3s ease, box-shadow 0.3s ease;
        }

        .stack-card.in-view .btn {
            opacity: 1;
            transform: translateY(0);
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 130%;
        }

        .btn:hover {
            background: #7c4d2c;
            box-shadow: 0 10px 22px rgba(124, 77, 44, 0.35);
        }

        .btn span {
            transition: transform 0.3s ease;
        }

        .btn:hover span {
            transform: translate(3px, -3px);
        }

        /* --- CARD COLORS --- */
        .card1 { background: #FFF2DA; z-index: 1; }
        .card1 .number { color: #2E3A2E; }
        .card1 .sub-title { color: #8f5a1f; }
        .card1 h2, .card1 p { color: #2E3A2E; }

        .card2 { background: #4A3425; z-index: 2; }
        .card2 .number { color: #FFD58C; }
        .card2 .sub-title { color: #F7C76D; }
        .card2 h2, .card2 p { color: #FFFFFF; }

        .card3 { background: #2E3A2E; z-index: 3; }
        .card3 .number { color: #FFD44F; }
        .card3 .sub-title { color: #FFE083; }
        .card3 h2, .card3 p { color: #FFFFFF; }

        /* DESKTOP — swiper disabled, sticky stacking active */
        @media (min-width: 992px) {

            .mobileSwiper { overflow: visible; }

            .mobileSwiper .swiper-wrapper { display: block; }

            .mobileSwiper .swiper-slide { width: 100%; }

            .swiper-pagination { display: none; }
        }

        /* TABLET */
        @media (max-width: 1200px) {
            .stack-container {
                width: 100%;
                padding: 0 40px;
            }
        }

        @media (max-width: 1024px) {
            .international-container { gap: 40px; }
            .stack-content h2 { font-size: 32px; }
            .number { font-size: 56px; }
            .image-box img { height: 420px; }
        }

        /* MOBILE */
        @media (max-width: 991px) {

            .mobileSwiper { overflow: hidden; }

            .mobileSwiper .swiper-wrapper { display: flex; }

            .stack-card {
                position: relative;
                top: auto;
                min-height: auto;
                margin-bottom: 0;
                padding: 35px 20px;
            }

            .stack-container { padding: 0; }

            .international-container {
                flex-direction: column;
                gap: 25px;
                text-align: center;
            }

            .image-box,
            .stack-content {
                width: 100%;
                transform: translateY(30px);
            }

            .stack-card.in-view .image-box,
            .stack-card.in-view .stack-content {
                transform: translateY(0);
            }

            .image-box img {
                width: 100%;
                height: 320px;
            }

            .number { font-size: 45px; }

            .stack-content h2 { font-size: 28px; }

            .stack-content p {
                font-size: 16px;
                line-height: 26px;
                margin: auto auto 25px;
            }

            .swiper-pagination {
                position: relative;
                margin-top: 20px;
            }

            .swiper-pagination-bullet-active { background: #9c6037; }

            /* Tighter stagger on mobile since cards are swiped individually */
            .stack-content h2 { transition-delay: 0.3s; }
            .stack-content p { transition-delay: 0.4s; }
            .number { transition-delay: 0.2s; }
            .sub-title { transition-delay: 0.25s; }
            .btn { transition-delay: 0.5s; }
        }

        @media (max-width: 600px) {
            .image-box img { height: 260px; }
        }

        @media (max-width: 480px) {
            .image-box img { height: 220px; }
            .number { font-size: 36px; }
            .stack-content h2 { font-size: 24px; }

            .stack-content p {
                font-size: 14px;
                line-height: 22px;
            }

            .btn {
                padding: 12px 22px;
                font-size: 15px;
            }
        }

        /* ACCESSIBILITY — REDUCED MOTION */
        @media (prefers-reduced-motion: reduce) {

            .image-box,
            .stack-content,
            .number,
            .sub-title,
            .stack-content h2,
            .stack-content p,
            .btn {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ================================
           DESTINATION SECTION
        ================================= */
        .destination {
            background: #D4B57B;
            padding: 30px 0;
            overflow: hidden;
        }

        .destination-container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
            text-align: center;
        }

        .sub-title {
            color: #2E3A2E;
            font-size: 20px;
            display: block;
            margin-bottom: 8px;
        }

        .destination h2 {
            color: #2E3A2E;
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .description {
            max-width: 700px;
            margin: auto;
            color: #2E3A2E;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 50px;
        }

        .destination-swiper {
            width: 100%;
            overflow: hidden;
            padding-bottom: 10px;
        }

        .swiper-slide {
            height: auto;
            display: flex;
            justify-content: center;
        }

        .swiper-pagination {
            color: #fff;
        }

        /* Touch targets: 14px bullets with 5px side margins = 24px centre-to-centre spacing */
        .swiper-pagination-bullet {
            width: 14px;
            height: 14px;
            margin: 0 5px !important;
        }

        /* Bullets on the tan destination background (white would be invisible) */
        .destination .swiper-pagination-bullet {
            background: #2E3A2E;
            opacity: 0.45;
        }

        .destination .swiper-pagination-bullet-active {
            background: #2E3A2E;
            opacity: 1;
        }

        /* --- Scroll-triggered staggered reveal --- */
        .reveal-item {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .destination.in-view .reveal-item:nth-of-type(1) { transition-delay: 0.1s; }
        .destination.in-view .reveal-item:nth-of-type(2) { transition-delay: 0.25s; }
        .destination.in-view .reveal-item:nth-of-type(3) { transition-delay: 0.4s; }
        .destination.in-view .reveal-item:nth-of-type(4) { transition-delay: 0.55s; }
        .destination.in-view .reveal-item:nth-of-type(5) { transition-delay: 0.7s; }

        .destination.in-view .reveal-item {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- FLIP CARDS --- */
        .flip-card {
            width: 320px;
            height: 420px;
            perspective: 1200px;
            margin: 0 auto;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s cubic-bezier(0.4, 0.2, 0.2, 1);
            transform-style: preserve-3d;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 20px;
            overflow: hidden;
        }

        .flip-card-front img,
        .flip-card-back img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            position: relative;
        }

        .flip-card-back::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.75) 100%);
        }

        .flip-card-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            text-align: left;
            color: #fff;
            z-index: 2;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.5s ease 0.3s, transform 0.5s ease 0.3s;
        }

        .flip-card:hover .flip-card-caption {
            opacity: 1;
            transform: translateY(0);
        }

        .flip-card-caption h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .flip-card-caption p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Touch device fallback: tap to flip */
        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card.flipped .flip-card-caption {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- VIEW ALL BUTTON --- */
        .view-btn {
            margin-top: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: #A96E37;
            color: #fff;
            text-decoration: none;
            border-radius: 40px;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .view-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .view-btn:hover::before {
            left: 130%;
        }

        .view-btn span {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .view-btn:hover {
            background: #8E5826;
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(142, 88, 38, 0.4);
        }

        .view-btn:hover span {
            transform: translate(3px, -3px);
        }

        @media (max-width: 1024px) {
            .flip-card {
                width: 280px;
                height: 380px;
            }

            .destination h2 { font-size: 32px; }
        }

        @media (max-width: 768px) {

            .destination { padding: 40px 0; }

            .destination h2 { font-size: 28px; }

            .description {
                font-size: 14px;
                margin-bottom: 35px;
            }

            .flip-card {
                width: 100%;
                max-width: 320px;
                height: 380px;
            }

            .flip-card-caption h3 { font-size: 18px; }
            .flip-card-caption p { font-size: 13px; }

            .view-btn {
                margin-top: 35px;
                padding: 12px 24px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {

            .flip-card { height: 340px; }

            .flip-card-caption { padding: 15px; }

            .sub-title { font-size: 16px; }

            .destination h2 { font-size: 24px; }
        }

        @media (prefers-reduced-motion: reduce) {

            .reveal-item,
            .flip-card-inner,
            .flip-card-caption,
            .view-btn::before {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }


        /* ================================
           BLOGS SECTION
        ================================= */
        .blogs-section {
            background: #8f5f27;
            padding: 30px 0;
            margin-top: 44px;
            overflow: hidden;
        }

        .blogs-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .sub-heading {
            color: #fff;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .blogs-section h2 {
            color: #fff;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .blogs-section h2::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -8px;
            height: 3px;
            width: 0;
            background: #fff;
            border-radius: 2px;
            transform: translateX(-50%);
            transition: width 0.7s ease 0.5s;
        }

        .blogs-section.in-view h2::after {
            width: 70px;
        }

        .blogs-section .description {
            color: #fff;
            font-size: 15px;
            line-height: 1.7;
            max-width: 700px;
            margin: 0 auto 50px;
        }

        .blogs-section.in-view .reveal-item:nth-of-type(1) { transition-delay: 0.1s; }
        .blogs-section.in-view .reveal-item:nth-of-type(2) { transition-delay: 0.25s; }
        .blogs-section.in-view .reveal-item:nth-of-type(3) { transition-delay: 0.4s; }
        .blogs-section.in-view .reveal-item:nth-of-type(4) { transition-delay: 0.55s; }
        .blogs-section.in-view .reveal-item:nth-of-type(5) { transition-delay: 0.7s; }

        .blogs-section.in-view .reveal-item {
            opacity: 1;
            transform: translateY(0);
        }

        .blogs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .blogs-card {
            border-radius: 14px;
            overflow: hidden;
            cursor: pointer;
            display: block;
            text-decoration: none;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.6s ease, transform 0.6s ease,
                box-shadow 0.4s ease;
        }

        .blogs-section.in-view .blogs-card {
            opacity: 1;
            transform: translateY(0);
        }

        .blogs-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            transform: translateY(-8px);
        }

        .blogs-img-wrap {
            overflow: hidden;
            position: relative;
        }

        .blogs-img-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, 0.5) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .blogs-card:hover .blogs-img-wrap::after {
            opacity: 1;
        }

        .blogs-card img {
            width: 100%;
            height: 215px;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .blogs-card:hover img {
            transform: scale(1.1);
        }

        .blog-content {
            padding: 18px 20px;
            text-align: left;
        }

        .blog-content h3 {
            font-size: 18px;
            color: #2E3A2E;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .blogs-card:hover .blog-content h3 {
            color: #8f5f27;
        }

        .blog-read-more {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #8f5f27;
            /*opacity: 0;*/
            transform: translateX(-8px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            border: 1px solid #8f5f27;
            border-radius: 20px;
            padding: 4px;
        }

        .blogs-card:hover .blog-read-more {
            opacity: 1;
            transform: translateX(0);
        }

        .blog-read-more i {
            font-style: normal;
            transition: transform 0.3s ease;
        }

        .blogs-card:hover .blog-read-more i {
            transform: translate(3px, -3px);
        }

        .blogs-btn {
            margin-top: 50px;
        }

        .blogs-btn a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 35px;
            background: #c88539;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blogs-btn a::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .blogs-btn a:hover::before {
            left: 130%;
        }

        .blogs-btn a:hover {
            background: #9a5e21;
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(154, 94, 33, 0.4);
        }

        .blogs-btn span {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .blogs-btn a:hover span {
            transform: translate(3px, -3px);
        }

        @media (max-width: 991px) {

            .blogs-grid { grid-template-columns: repeat(2, 1fr); }

            .blogs-container { padding: 0 15px; }

            .blogs-section h2 { font-size: 36px; }
        }

        @media (max-width: 600px) {

            .blogs-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .blogs-section h2 { font-size: 32px; }

            .blogs-section .description {
                font-size: 14px;
                margin-bottom: 35px;
            }

            .blogs-card img { height: 220px; }

            .blogs-btn { margin-top: 35px; }

            .blogs-btn a {
                padding: 13px 28px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {

            .blogs-section { padding: 25px 0; }

            .blogs-section h2 { font-size: 26px; }

            .sub-heading { font-size: 13px; }

            .blog-content { padding: 14px 16px; }

            .blog-content h3 { font-size: 16px; }
        }

        @media (prefers-reduced-motion: reduce) {

            .reveal-item,
            .blogs-card,
            .blogs-img-wrap::after,
            .blog-read-more,
            .blogs-section h2::after,
            .blogs-btn a::before {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }


        /* ================================
           TESTIMONIAL SECTION
        ================================= */
        .testimonial-section {
            padding: 30px 0;
            overflow: hidden;
        }

        .testimonial-container {
            width: 1200px;
            max-width: 95%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 60px;
        }

        .testimonial-section.in-view .reveal-item:nth-of-type(1) { transition-delay: 0.1s; }
        .testimonial-section.in-view .reveal-item:nth-of-type(2) { transition-delay: 0.22s; }
        .testimonial-section.in-view .reveal-item:nth-of-type(3) { transition-delay: 0.34s; }
        .testimonial-section.in-view .reveal-item:nth-of-type(4) { transition-delay: 0.46s; }
        .testimonial-section.in-view .reveal-item:nth-of-type(5) { transition-delay: 0.58s; }
        .testimonial-section.in-view .reveal-item:nth-of-type(6) { transition-delay: 0.7s; }

        .testimonial-section.in-view .reveal-item {
            opacity: 1;
            transform: translateY(0);
        }

        .left { width: 35%; }

        .subtitle {
            color: #9c5a2c;
            font-size: 14px;
            font-weight: 500;
        }

        .left h2 {
            margin: 12px 0;
            font-size: 46px;
            color: #6C3F2A;
            line-height: 1.2;
            position: relative;
            display: inline-block;
        }

        .left h2::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            height: 3px;
            width: 0;
            background: #d18b45;
            border-radius: 2px;
            transition: width 0.7s ease 0.5s;
        }

        .testimonial-section.in-view .left h2::after {
            width: 60px;
        }

        .left p {
            color: #000000;
            line-height: 1.8;
            margin: 18px 0;
        }

        .left h3 {
            font-size: 1.5rem;
            margin-top: 30px;
            color: #2f2925;
        }

        .rating {
            margin-top: 10px;
            color: #2E3A2E;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .stars-row { display: inline-flex; }

        .stars-row .star {
            display: inline-block;
            opacity: 0;
            transform: scale(0) rotate(-90deg);
            transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: #E8A33D;
        }

        .testimonial-section.in-view .stars-row .star:nth-child(1) { transition-delay: 0.75s; }
        .testimonial-section.in-view .stars-row .star:nth-child(2) { transition-delay: 0.82s; }
        .testimonial-section.in-view .stars-row .star:nth-child(3) { transition-delay: 0.89s; }
        .testimonial-section.in-view .stars-row .star:nth-child(4) { transition-delay: 0.96s; }
        .testimonial-section.in-view .stars-row .star:nth-child(5) { transition-delay: 1.03s; }

        .testimonial-section.in-view .stars-row .star {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        .rating-text {
            color: #666;
            font-size: 14px;
            margin-left: 8px;
            opacity: 0;
            transition: opacity 0.5s ease 1.1s;
        }

        .testimonial-section.in-view .rating-text { opacity: 1; }

        .arrow { margin-top: 40px; }

        .arrow img {
            width: 312px;
            height: auto;
            display: block;
            margin-left: 45px;
            margin-top: -33px;
            transform-origin: left center;
            animation: arrowSway 3s ease-in-out infinite;
        }

        .testimonial-section.in-view .arrow img { animation-delay: 1.2s; }

        @keyframes arrowSway {
            0%, 100% { transform: rotate(0deg) translateY(0); }
            50%      { transform: rotate(-4deg) translateY(3px); }
        }

        .cards {
            width: 65%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .card {
            position: relative;
            background: #fff8f2;
            border: 1px solid #eadfce;
            border-radius: 15px;
            padding: 25px 25px 25px 85px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.6s ease, transform 0.6s ease,
                box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .testimonial-section.in-view .card:nth-child(1) { transition-delay: 0.15s; }
        .testimonial-section.in-view .card:nth-child(2) { transition-delay: 0.3s; }
        .testimonial-section.in-view .card:nth-child(3) { transition-delay: 0.45s; }
        .testimonial-section.in-view .card:nth-child(4) { transition-delay: 0.6s; }

        .testimonial-section.in-view .card {
            opacity: 1;
            transform: translateY(0);
        }

        .card:hover {
            box-shadow: 0 20px 40px rgba(163, 116, 55, 0.18);
            border-color: #A37437;
            transform: translateY(-8px);
        }

        .card img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            position: absolute;
            left: 18px;
            top: 22px;
            border: 3px solid #A37437;
            transition: transform 0.4s ease;
        }

        .card:hover img {
            transform: scale(1.1) rotate(-6deg);
        }

        .card h3 {
            font-size: 16px;
            letter-spacing: 1px;
            color: #8a5f2b;
        }

        .stars {
            color: #2E3A2E;
            margin: 5px 0 12px;
            font-size: 14px;
            letter-spacing: 2px;
        }

        .card p {
            color: #000000;
            line-height: 1.7;
            font-size: 14px;
        }

        .card::before {
            content: "\201C";
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 50px;
            font-family: Georgia, serif;
            color: #A37437;
            opacity: 0;
            transform: scale(0.6);
            transition: opacity 0.35s ease, transform 0.35s ease;
            pointer-events: none;
        }

        .card:hover::before {
            opacity: 0.15;
            transform: scale(1);
        }

        @media (max-width: 1200px) {
            .testimonial-container { gap: 40px; }
        }

        @media (max-width: 991px) {

            .testimonial-container { flex-direction: column; }

            .left,
            .cards { width: 100%; }

            .left h2 { font-size: 38px; }
        }

        @media (max-width: 768px) {

            .cards { grid-template-columns: 1fr; }

            .move-down { margin-top: 0; }

            .left h2 { font-size: 36px; }

            .left h2::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .testimonial-section.in-view .left h2::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .arrow { display: none; }

            .left { text-align: center; }

            .rating { justify-content: center; }
        }

        @media (max-width: 480px) {

            .left h2 { font-size: 28px; }

            .left p { font-size: 14px; }

            .card { padding: 20px 20px 20px 75px; }

            .card img {
                width: 45px;
                height: 45px;
                left: 15px;
                top: 18px;
            }

            .card h3 { font-size: 14px; }

            .card p { font-size: 13px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal-item,
            .stars-row .star,
            .rating-text,
            .arrow img,
            .left h2::after,
            .card,
            .card img,
            .card::before {
                transition: none !important;
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }


        /* ================================
           FAQ SECTION
        ================================= */
        .faq-section {
            padding: 37px 80px;
            background-color: #FFF2DA;
        }

        .faq-container {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            align-items: center;
        }

        .faq-left h2 {
            font-size: 38px;
            color: #5b3727;
            margin-bottom: 15px;
        }

        .faq-subtitle {
            color: #2E3A2E;
            line-height: 1.8;
            margin-bottom: 35px;
            font-size: 20px;
            font-weight: 500;
        }

        .accordion {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .accordion-item {
            background: #fcf2df;
            border: 1px solid #2e3a2e57;
            border-radius: 10px;
            overflow: hidden;
        }

        .accordion-header {
            width: 100%;
            background: #FFF2DA;
            border: none;
            outline: none;
            padding: 22px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 20px;
            font-weight: 600;
            color: #2E3A2E;
        }

        .arrow {
            transition: .3s;
            font-size: 20px;
        }

        .accordion-item.active .arrow {
            transform: rotate(180deg);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease, padding .4s ease;
            padding: 0 25px;
            color: #2E3A2E;
            background: #FFF2DA;
            line-height: 1.4;
            font-size: 20px;
        }

        .accordion-item.active .accordion-body {
            max-height: 200px;
            padding: 0 25px 25px;
        }

        .faq-right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .faq-right img {
            width: 300px;
            max-width: 100%;
            height: auto;
            display: block;
        }

        .faq-right span {
            font-size: 320px;
            font-weight: bold;
            color: transparent;
            -webkit-text-stroke: 4px #7b503d;
            user-select: none;
        }

        @media (max-width: 900px) {

            .faq-section { padding: 50px 20px; }

            .faq-container { grid-template-columns: 1fr; }

            .faq-right { display: none; }

            .faq-left h2 { font-size: 30px; }
        }


        /* ================================
           DISCLAIMER SECTION
        ================================= */
        .disclaimer-section {
            background: #ffffff;
            padding: 22px 0;
            border-top: 1px solid #ececec;
        }

        .disclaimer-container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        .disclaimer-section p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            text-align: left;
            font-weight: 400;
            margin-bottom: 50px;
        }

        .disclaimer-section strong {
            color: #333;
            font-weight: 600;
        }

        .disclaimer-section a {
            color: #2d5fa8;
            text-decoration: underline;
            font-weight: 600;
        }

        .disclaimer-section a:hover {
            color: #163d74;
        }

        @media (max-width: 768px) {

            .disclaimer-section { padding: 18px 15px; }

            .disclaimer-section p {
                font-size: 10px;
                line-height: 1.7;
            }
        }
    </style>

    {{-- =============================================================
     JAVASCRIPT
     NOTE: load Swiper's JS with `defer` in layouts/app.blade.php (before this inline script
     runs on the `load` event, which is when Swiper is initialised below).
============================================================== --}}

    <script>
        /* ---------- LCP FIX: start the hero zoom only AFTER the page has loaded ---------- */
        (function () {
            function markLoaded() {
                document.body.classList.add('loaded');
            }
            if (document.readyState === 'complete') {
                markLoaded();
            } else {
                window.addEventListener('load', markLoaded);
            }
        })();

        /* ---------- Return date toggle (booking form) ---------- */
        document.addEventListener("DOMContentLoaded", function () {

            const tripRadios = document.querySelectorAll('input[name="trip"]');
            const returnDateBox = document.getElementById("returnDateBox");
            const returnDate = document.getElementById("returnDate");

            function toggleReturnDate() {
                const tripType = document.querySelector('input[name="trip"]:checked').value;

                if (tripType === "oneway") {
                    returnDateBox.style.display = "none";
                    returnDate.value = "";
                    returnDate.removeAttribute("required");
                } else {
                    returnDateBox.style.display = "block";
                    returnDate.setAttribute("required", "required");
                }
            }

            tripRadios.forEach(radio => {
                radio.addEventListener("change", toggleReturnDate);
            });

            // Run on page load
            toggleReturnDate();

        });


        /* ---------- Passenger dropdown + date icon triggers ---------- */
        const profileIcon = document.querySelector('.input-box img[src*="profile"]');

        if (profileIcon) {
            profileIcon.addEventListener('click', function () {
                this.previousElementSibling.focus();
                this.previousElementSibling.click();
            });
        }

        document.querySelectorAll('.input-box img[src*="calendar"]').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = this.previousElementSibling;

                if (input.showPicker) {
                    input.showPicker(); // Chrome, Edge
                } else {
                    input.focus();
                    input.click();
                }
            });
        });


        /* ---------- Stacking cards swiper (mobile/tablet only) ---------- */
        let mobileSwiper;

        function initSwiper() {

            if (typeof Swiper === 'undefined') return;

            if (window.innerWidth <= 991) {

                if (!mobileSwiper) {

                    mobileSwiper = new Swiper(".mobileSwiper", {
                        slidesPerView: 1,
                        spaceBetween: 20,

                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                    });

                }

            } else {

                if (mobileSwiper) {
                    mobileSwiper.destroy(true, true);
                    mobileSwiper = undefined;
                }

            }

        }

        window.addEventListener("load", initSwiper);
        window.addEventListener("resize", initSwiper);


        /* ---------- FAQ accordion ---------- */
        document.querySelectorAll(".accordion-header").forEach(header => {
            header.addEventListener("click", () => {
                header.parentElement.classList.toggle("active");
            });
        });

        /* ---------- Button ripple effect ---------- */
        const bookingBtn = document.querySelector('.booking-form button');

        if (bookingBtn) {
            bookingBtn.addEventListener('click', function (e) {
                const circle = document.createElement('span');
                const diameter = Math.max(this.clientWidth, this.clientHeight);
                const radius = diameter / 2;

                circle.style.width = circle.style.height = `${diameter}px`;
                circle.style.left = `${e.clientX - this.getBoundingClientRect().left - radius}px`;
                circle.style.top = `${e.clientY - this.getBoundingClientRect().top - radius}px`;
                circle.classList.add('ripple-circle');

                const existingRipple = this.querySelector('.ripple-circle');
                if (existingRipple) existingRipple.remove();

                this.appendChild(circle);

                setTimeout(() => circle.remove(), 600);
            });
        }

        /* ---------- Floating letter-labels: auto-build spans ---------- */
        document.querySelectorAll('.floating-label').forEach(label => {
            const text = label.getAttribute('data-text') || '';
            label.innerHTML = '';

            text.split('').forEach((char, i) => {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.style.transitionDelay = `${i * 20}ms`;
                label.appendChild(span);
            });
        });

        /* ---------- Reusable one-shot scroll reveal ---------- */
        function revealOnce(el, threshold) {
            if (!el) return;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: threshold });
            observer.observe(el);
        }

        /* About, destination, testimonial sections */
        revealOnce(document.getElementById('aboutSection'), 0.2);
        revealOnce(document.getElementById('destinationSection'), 0.15);
        revealOnce(document.querySelector('.testimonial-section'), 0.15);

        /* ---------- Stack cards: scroll-triggered reveal (replays on scroll back) ---------- */
        const stackCards = document.querySelectorAll('[data-stack-card]');

        if (stackCards.length) {
            const stackObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    } else {
                        entry.target.classList.remove('in-view');
                    }
                });
            }, { threshold: 0.35 });

            stackCards.forEach(card => stackObserver.observe(card));
        }

        /* ---------- Flip cards: tap to flip on touch devices ---------- */
        if ('ontouchstart' in window) {
            document.querySelectorAll('.flip-card').forEach(card => {
                card.addEventListener('click', function () {
                    this.classList.toggle('flipped');
                });
            });
        }

        /* ---------- Blogs section: scroll-triggered reveal ---------- */
        const blogsSection = document.getElementById('blogsSection');

        if (blogsSection) {
            // Auto-stagger blog cards regardless of how many are rendered
            blogsSection.querySelectorAll('.blogs-card').forEach((card, i) => {
                card.style.transitionDelay = `${0.15 + i * 0.12}s`;
            });

            revealOnce(blogsSection, 0.1);
        }
    </script>

@endsection