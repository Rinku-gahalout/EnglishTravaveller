<footer class="footer">

    <div class="container">

        <!-- Newsletter -->
        <div class="newsletter-box">
            <h2>Want to Get in Touch with Our Team?</h2>

            <p>
               Get the best deals on flights to San Francisco, 
               Ohio, and other famous destinations of the US.
            </p>

            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email ID">
                <button type="submit">
                    ➜
                </button>
            </form>
        </div>

        <!-- Footer Content -->
        <div class="row footer-top">

            <div class="col-lg-3">
                <img src="{{ asset('images/Group (1).png') }}" alt="LOGO" class="footer-logo">

                <p class="footer-text">
                   English Traveller is the airline-based website that is designed
                   to fulfill your affordable flight deals worldwide. Through this
                   website, you will get the best flight deals.
                </p>
            </div>

            <div class="col-6 col-lg-2">
                <h3>Reach Out</h3>

                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li>
    <a href="{{ route('categoryblogs', ['cate_subcate' => 'blog']) }}">
        Blog
    </a>
</li>
                    
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h3>International Tours</h3>

                <ul>
                    <li><a href="#">Maldives Tour</a></li>
                    <li><a href="#">Bali, Indonesia Tour</a></li>
                    <li><a href="#">Thailand Tour</a></li>
                    <li><a href="#">Philippines Tour</a></li>
                    <li><a href="#">Hawaii, USA Tour</a></li>
                    <li><a href="#">Switzerland Tour</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h3>Contact Us</h3>

                <ul class="contact-info">
                 <li>
    <img src="{{ asset('images/Vector (1).png') }}" alt="Phone" width="20">
    <a href="tel:+18444263868">+1-844-426-3868</a>
</li>

<li>
    <img src="{{ asset('images/Vector (2).png') }}" alt="Email" width="20">
    <a href="mailto:info@englishtraveller.us">info@englishtraveller.us</a>
</li>

                    <li>
                        <img src="{{ asset('images/Group 69.png') }}" alt="Location" width="20">
                        123 Street, New York, USA
                    </li>
                </ul>

             
<div class="social-icons">

    <a href="#" aria-label="Facebook">
        <i class="fab fa-facebook-f" aria-hidden="true"></i>
    </a>

    <a href="#" aria-label="Instagram">
        <i class="fab fa-instagram" aria-hidden="true"></i>
    </a>

    <a href="#" aria-label="Twitter">
        <i class="fab fa-twitter" aria-hidden="true"></i>
    </a>

    <a href="#" aria-label="LinkedIn">
        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
    </a>

</div>



            </div>

        </div>

        <hr>

        <div class="footer-bottom">

            <p>© 2026 English Traveller. All rights reserved.</p>

            <div>
                <a href="{{ route('privacyPolicy') }}">Privacy Policy</a>
                <a href="{{ route('term_conditions') }}">Terms & Conditions</a>
                 <a href="{{ route('disclaimer') }}">Disclaimer</a>
            </div>

        </div>

    </div>

</footer>

<div class="mobile-bottom-bar d-lg-none">
    <a href="tel:+18444263868" class="mobile-call-btn">
     
<img
    src="{{ asset('images/call-calling.png') }}"
    alt="Call"
    width="20"
    height="20"
>


        +1-844-426-3868
    </a>
</div>
