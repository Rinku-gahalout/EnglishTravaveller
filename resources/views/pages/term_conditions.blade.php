@extends('layouts.app')

@section('title', 'Terms & Conditions – Know Before You Go | English Traveller')

@section('meta_description', 'Before you book, review the English Traveller terms and conditions. Learn the rules, user rights and service guidelines that apply to every single traveler.')

@section('content')

<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>Terms <span>Conditions</span></h1>
          
        </div>
    </div>
</section>

<section class="privacy-policy-content">
    <div class="container">
        
       <p>
               Thanks for Visiting English Traveler
            </p>

        <p>Hi there. Welcome. We want to make it easier for you to plan your trip, with less worry. If you are looking for flights, 
        a hotel, or good travel offers, we will try to keep booking from feeling complicated. </p>

        <p>Please read the terms and conditions before you use this site or make a purchase. Using the website means you agree to the rules listed here. </p>

        <h2>General Disclaimer:</h2>
        <p>English Traveler helps you search for and book travel options. This can include flights and hotels.
        We may also show travel offers, special deals, lower prices, and other booking details from the travel partners.</p>
        
        <p>We try to share up to date information. Even so, details can change. Prices can move. Rooms can get booked out. Flight times and offers can be updated. Sorry, we cannot say that every listing on this site is always right, with no errors.</p>

        <p>Your trip is handled by the airline, the hotel, or another travel provider. If they make changes, delay a departure, cancel, or have service problems, or if they make an error, we cannot control that.</p>
        
        <p>Also, your bank or payment provider may add fees. This can happen with currency exchange or other payment charges.</p>
        
        <h2>Privacy Policy:</h2>
        <p>We care about your privacy. While you use our site and services, we add simple safeguards. They are meant to help keep your personal details protected.</p>
        
        <p>We use your information to take care of bookings, respond to questions, and support you when you need assistance. We also use it to make our services better. For more details on what we collect and why, see the Privacy Policy section below.</p>
        
        

        <h3>Cookie Policy:</h3>
        <p>Many sites, including English Traveler, use cookies and similar tools. 
        These tools help us learn how people move through the site. They can also make your time online easier. 
        Cookies can store choices you make and help the site run faster.</p>
      

        <h3>Personal Details: </h3>
        <p>Once you start making your booking, we will ask your some of the personal details. You may have to give your full name, email id, phone number, and your billing address. 
        In some cases, we will also need passport or other ID details. If you must pay, we will ask for the payment info as well.</p>
       
        <p>If you make an account, we will use the info you put in there. Any messages you send us can also include the details we require.</p>
        
        <p>Check your entries before you submit them. If something is wrong or missing, it can slow down your booking. It can also affect your trip plans.</p>

        <h3>Cookies:</h3>
        <p>Cookies are a set of small files that are saved on your devices. They keep a few pieces of info. 
        Then a website can behave the same way next time. This can make your browsing feel more stable.</p>
        <p>You can adjust your browser accordingly to stop the unnecessary cookies and delete them. If you do the same, some parts of the website may not work. Some features might be limited. </p>

        <h3>Web Beacons:</h3>
        <p>We beacons are tiny tracking tags. You may see them on some pages. They can also be found in emails. These tags can show how many people view a page. They can also help check how an email is doing. </p>

        <h3>Third-party tracking tools: </h3>
        <p>Some sections of our site may be handled by outside vendors. This can include media, ads, tools, or apps. Those vendors may use cookies or similar methods. They may collect details about how you use the web. </p>
        <p>The info from those tools may be tied to other data the vendor stores. We ask that you read the privacy notice for each vendor. That way you can see how they collect and use details. </p>

        <h2>How we Use and Share Your Data:  </h2>
        <p>In some cases, we must pass along details to complete your reservation. This may involve airlines, hotels, payment providers, and other service partners.</p>
        <p>We share only what is needed for the service you asked for. We also take steps to manage your data in a careful way.</p>
        
       

        <h2>Using Our Site</h2>
        <p>When you use English Traveler, you agree to use the site in a proper manner. You also agree to use it only for legal reasons.</p>
        
        <p>Book with real details. Stick to the rules in the booking agreement. Use the site in a safe way. Do not do things that damage it. Do not put in false or made up info. Do not try to view places you were not allowed to see. Do not open those areas. We can also cancel your booking. We will use the terms that apply, plus the current laws.</p>

        <h2>Refunds and Cancellations: </h2>
        
        <p>The rules may vary on the basis of your booking time. An airline may handle it one way, while a hotel may handle it another. Your fare type can also matter. So can the booking terms set by the travel company you used.</p>
        
        <p>Sometimes a booking cannot be refunded. In other cases, you can cancel, but you may still be charged. If you are allowed to get a refund, the amount and timing follow the travel supplier rules. Those rules come from what you see at the time you book.</p>
        

        <h2>Baggage Check-In</h2>
        <li>One carry-on and personal baggage is allowed in the cabin.</li>
        <li>But it may vary from airline to airline</li>
        <li>Check all the size limits before traveling. </li>
        <li>The limits depend on the airline. The dimensions must stay within what they allow.</li>
        <li>If facing any problem, then you can also contact the airline staff.</li>

        <h2>Some Prohibited Activities</h2>
        <p>You must follow all the terms and conditions of this website, and does not use it for any illegal or unauthorized activities. </p>

        <h2>Booking Process: </h2>
        <p>You must carry your passports and all the valid ID documents issued by the government for the security checked at the airport.</p>

        <h2>Pricing, Taxes and Fees Payments:</h2>
        <p>When you book travel, you have to cover every tax and fee tied to it. That can include airfare, lodging, car rental, and any booked activities. At check-in, extra charges may come up too, so be ready for that.
        You must pay using a debit card or a credit card. Also, the listed prices or special deals may change over time.</p>

        <h2>Multiple Airline Itineraries:</h2>
        <p>You should read the rules and fees of each airline very carefully before you travel. Different airlines may have different fees if you need to make changes to your flights. Print out your tickets before you travel.</p>
        

    </div>
</section>

<style>
.contact-banner{
    background: url("{{ asset('images/et_conditions_bg.webp') }}") center center/cover no-repeat;
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

.privacy-policy-content{
    padding: 60px 0;
}
.privacy-policy-content .container{
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}
.privacy-policy-content h2{
    font-size: 26px;
    font-weight: 600;
    color: #583624;
    margin-top: 36px;
    margin-bottom: 14px;
}
.privacy-policy-content h3{
    font-size: 20px;
    font-weight: 600;
    color: #583624;
    margin-top: 24px;
    margin-bottom: 10px;
}
.privacy-policy-content p{
    font-size: 15px;
    line-height: 1.8;
    color: #444;
    margin-bottom: 14px;
}
.privacy-policy-content ul{
    margin: 0 0 16px 20px;
    padding: 0;
}
.privacy-policy-content ul li{
    font-size: 15px;
    line-height: 1.8;
    color: #444;
    margin-bottom: 8px;
    list-style: disc;
}
.privacy-policy-content a{
    color: #d39a45;
    text-decoration: none;
}
.privacy-policy-content a:hover{
    text-decoration: underline;
}
</style>
@endsection