@extends('layouts.app')

@section('title', 'Disclaimer – Travel Information Notice | English Traveller')

@section('meta_description', 'English Traveller is an independent travel information provider. Please read our full disclaimer on accuracy of content, third-party links and liability.')



@section('content')
<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>Disclaimer</span></h1>
          
        </div>
    </div>
</section>

<section class="privacy-policy-content">
    <div class="container">
        
             <p>
              English Traveler is a page that shares travel info. It covers almost all topics, such as airlines and flights, different places to visit, and general advice for travelers. 
            </p>

        <p>We do not deal with any official pages that direct you to airlines, airports, hotels, or any other travel businesses. We only name a company if the text itself says it.</p>

        <p>Most of our content is meant for general use. This can change fast. We regularly update our content and do not alert the readers right away. We only share accurate information. However, we cannot make a promise that all the information we have written is definitely correct. </p>

       <p>Before you plan your trip or buy the tickets, please double-check key items. Look at the costs, departure times, ticket terms, visa requirements, and any travel limits. Confirm these items with the official sources linked to them. </p> 

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