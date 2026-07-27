<footer class="footer">

    <div class="container">

        <!-- Newsletter -->
        <div class="newsletter-box">
            <h2>Want to consult with our team?</h2>

            <p>
                Get best rates on the flights of san fransico. Know about the places to
                explore in san fransico and the best way to book at low prices.
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
                <img src="{{ asset('images/Group (1).png') }}" class="footer-logo">

                <p class="footer-text">
                    Englishtraveller is your movement amigo who designs every one
                    of your movements around the Worldwide with Markdown Flights
                    Arrangements.
                </p>
            </div>

            <div class="col-6 col-lg-2">
                <h5>Reach Out</h5>

                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="#">Blogs</a></li>
                    <li><a href="#">News</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h5>International Tours</h5>

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
                <h5>Contact Us</h5>

                <ul class="contact-info">
                    <li>
                        <img src="{{ asset('images/Vector (1).png') }}" alt="Phone" width="20">
                        +1-844-426-3868
                    </li>

                    <li>
                        <img src="{{ asset('images/Vector (2).png') }}" alt="Email" width="20">
                        englishtraveler.info@gmail.com
                    </li>

                    <li>
                        <img src="{{ asset('images/Group 69.png') }}" alt="Location" width="20">
                        123 Street, New York, USA
                    </li>
                </ul>

                <div class="social-icons">

                    <a href="#"><i class="fab fa-facebook-f"></i></a>

                    <a href="#"><i class="fab fa-twitter"></i></a>

                    <a href="#"><i class="fab fa-instagram"></i></a>

                    <a href="#"><i class="fab fa-linkedin-in"></i></a>

                    <a href="#"><i class="fab fa-youtube"></i></a>

                </div>

            </div>

        </div>

        <hr>

        <div class="footer-bottom">

            <p>© 2026 English Traveller. All rights reserved.</p>

            <div>
                <a href="{{ route('privacyPolicy') }}">Privacy Policy</a>
                <a href="{{ route('term_conditions') }}">Terms & Conditions</a>
            </div>

        </div>

    </div>

</footer>

<div class="mobile-bottom-bar d-lg-none">
    <a href="tel:+18444263868" class="mobile-call-btn">
        <img src="{{ asset('images/call-calling.png') }}" alt="Call" width="20">
        +1-844-426-3868
    </a>
</div>
