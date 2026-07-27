<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=Space+Mono:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===========================================================
           TOKENS
        ============================================================ */
        :root {
            --navy-deep: #0b1d26;
            --navy-mid: #142f3d;
            --navy-soft: #1d3f50;
            --brass: #c9a26a;
            --brass-bright: #e7c68c;
            --paper: #f6f1e4;
            --paper-dim: #ece3cf;
            --ink: #16232b;
            --ink-soft: #5b6b74;
            --error: #b23a32;

            --font-display: 'Big Shoulders Display', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-mono: 'Space Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--navy-deep);
            background-image:
                radial-gradient(1px 1px at 12% 20%, rgba(255, 255, 255, .35) 50%, transparent 51%),
                radial-gradient(1px 1px at 28% 55%, rgba(255, 255, 255, .25) 50%, transparent 51%),
                radial-gradient(1px 1px at 68% 15%, rgba(255, 255, 255, .3) 50%, transparent 51%),
                radial-gradient(1px 1px at 82% 65%, rgba(255, 255, 255, .2) 50%, transparent 51%),
                radial-gradient(1px 1px at 45% 80%, rgba(255, 255, 255, .25) 50%, transparent 51%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }

        /* ===========================================================
           TICKET / CONTAINER
        ============================================================ */
        .container {
            position: relative;
            display: flex;
            width: 100%;
            max-width: 920px;
            min-height: 520px;
            background: var(--paper);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .45);
        }

        /* ---------- Left: Gate panel ---------- */
        .left-section {
            position: relative;
            flex: 1.05;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(160deg, var(--navy-mid), var(--navy-deep) 70%);
            color: var(--paper);
            padding: 42px 40px;
            overflow: hidden;
            opacity: 0;
            transform: translateX(-24px);
            animation: paneIn .7s cubic-bezier(.2, .8, .2, 1) .1s forwards;
        }

        .gate-eyebrow {
            font-family: var(--font-mono);
            font-size: 12px;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--brass-bright);
        }

        .gate-heading {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(40px, 6vw, 58px);
            line-height: .95;
            letter-spacing: .01em;
            margin-top: 14px;
            text-transform: uppercase;
        }

        .gate-heading span {
            display: block;
            color: var(--brass);
        }

        .gate-sub {
            margin-top: 16px;
            max-width: 260px;
            font-size: 14px;
            line-height: 1.6;
            color: rgba(246, 241, 228, 0.65);
        }

        /* Flight path signature element */
        .flight-map {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: .9;
        }

        .flight-map .route {
            fill: none;
            stroke: var(--brass);
            stroke-width: 1.4;
            stroke-linecap: round;
            stroke-dasharray: 5 8;
            opacity: .55;
            stroke-dashoffset: 0;
            animation: dashMove 9s linear infinite;
        }

        .flight-map .dot {
            fill: var(--brass-bright);
        }

        .plane {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .plane span {
            position: absolute;
            display: block;
            width: 16px;
            height: 16px;
            color: var(--brass-bright);
            offset-path: path("M52,436 C124,372 150,268 214,214 C276,162 330,120 356,58");
            offset-rotate: auto;
            animation: fly 6.5s ease-in-out infinite;
            filter: drop-shadow(0 0 6px rgba(231, 198, 140, .8));
        }

        .airport-codes {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            font-family: var(--font-mono);
            font-size: 13px;
            letter-spacing: .08em;
            color: var(--paper);
        }

        .airport-codes .code {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .airport-codes .code b {
            font-size: 20px;
            color: var(--brass-bright);
        }

        .airport-codes .code.dest {
            text-align: right;
            align-items: flex-end;
        }

        /* ---------- Perforated seam ---------- */
        .seam {
            position: relative;
            width: 0;
            flex: 0 0 auto;
        }

        .seam::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: -1px;
            width: 2px;
            background-image: repeating-linear-gradient(to bottom,
                    transparent 0 6px,
                    var(--paper-dim) 6px 16px);
        }

        .seam .notch {
            position: absolute;
            left: -11px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--navy-deep);
        }

        .seam .notch.top {
            top: -11px;
        }

        .seam .notch.bottom {
            bottom: -11px;
        }

        /* ---------- Right: Login panel ---------- */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 44px 40px;
            opacity: 0;
            transform: translateY(18px);
            animation: paneIn .7s cubic-bezier(.2, .8, .2, 1) .25s forwards;
        }

        .login-container {
            width: 100%;
            max-width: 340px;
            text-align: center;
        }

        .logo {
            width: 150px;
            margin: 0 auto 6px;
            display: block;
        }

        .form-eyebrow {
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        h2 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: .01em;
            text-transform: uppercase;
            color: var(--ink);
            margin: 6px 0 22px;
        }

        /* Error message */
        .error-message {
            background: var(--error);
            color: #fff;
            padding: 11px 14px;
            margin-bottom: 12px;
            border-radius: 8px;
            font-size: 13.5px;
            text-align: left;
            display: none;
            animation: dropIn .35s ease forwards;
        }

        /* Inputs */
        .field {
            position: relative;
            margin: 14px 0;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 40px;
            border: 1.5px solid #e2dbc8;
            border-radius: 9px;
            background: #fcfaf3;
            outline: none;
            font-family: var(--font-body);
            font-size: 14.5px;
            color: var(--ink);
            transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
        }

        input::placeholder {
            color: #9a978a;
        }

        input:focus {
            border-color: var(--brass);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201, 162, 106, .18);
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: var(--ink-soft);
            pointer-events: none;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin: 2px 0 18px;
            font-size: 13px;
            color: var(--ink-soft);
            text-decoration: none;
            transition: color .25s ease;
        }

        .forgot-password:hover {
            color: var(--brass);
            text-decoration: underline;
        }

        /* Login button */
        .login-button {
            position: relative;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy-deep));
            color: var(--brass-bright);
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 14.5px;
            letter-spacing: .04em;
            text-transform: uppercase;
            cursor: pointer;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 10px 24px rgba(11, 29, 38, .35);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(11, 29, 38, .45);
        }

        .login-button:active {
            transform: translateY(0px) scale(.98);
        }

        .login-button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(231, 198, 140, .35) 50%, transparent 70%);
            transform: translateX(-120%);
        }

        .login-button:hover::after {
            transform: translateX(120%);
            transition: transform .8s ease;
        }

        /* ===========================================================
           KEYFRAMES
        ============================================================ */
        @keyframes paneIn {
            to {
                opacity: 1;
                transform: translate(0, 0);
            }
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes dashMove {
            to {
                stroke-dashoffset: -260;
            }
        }

        @keyframes fly {

            0%,
            100% {
                offset-distance: 0%;
                opacity: 0;
            }

            8% {
                opacity: 1;
            }

            92% {
                opacity: 1;
            }

            100% {
                offset-distance: 100%;
                opacity: 0;
            }
        }

        /* ===========================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 820px) {
            .container {
                flex-direction: column;
                min-height: auto;
            }

            .left-section {
                padding: 32px 28px;
                min-height: 220px;
            }

            .gate-heading {
                font-size: 38px;
            }

            .seam {
                width: 100%;
                height: 0;
            }

            .seam::before {
                top: -1px;
                bottom: auto;
                left: 0;
                right: 0;
                width: auto;
                height: 2px;
                background-image: repeating-linear-gradient(to right,
                        transparent 0 6px,
                        var(--paper-dim) 6px 16px);
            }

            .seam .notch {
                top: -11px;
                left: auto;
            }

            .seam .notch.top {
                left: -11px;
            }

            .seam .notch.bottom {
                right: -11px;
                left: auto;
            }

            .right-section {
                padding: 34px 28px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Left Section: Gate panel -->
        <div class="left-section">

            <svg class="flight-map" viewBox="0 0 400 500" preserveAspectRatio="none">
                <path class="route" d="M52,436 C124,372 150,268 214,214 C276,162 330,120 356,58" />
                <circle class="dot" cx="52" cy="436" r="4" />
                <circle class="dot" cx="356" cy="58" r="4" />
            </svg>

            <div class="plane">
                <span>
                    <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                        <path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2.5 1.8V22l4-1 4 1v-1.2L13 19v-5.5l8 2.5z" />
                    </svg>
                </span>
            </div>

            <div class="gate-eyebrow">Restricted &middot; Ground Control</div>

            <div>
                <h1 class="gate-heading">Control<span>Tower</span></h1>
                <p class="gate-sub">Sign in to manage routes, fares, and every seat on the board.</p>
            </div>

            <div class="airport-codes">
                <div class="code">
                    <span>Origin</span>
                    <b>DEL</b>
                </div>
                <div class="code dest">
                    <span>Access level</span>
                    <b>ADMIN</b>
                </div>
            </div>

        </div>

        <div class="seam">
            <div class="notch top"></div>
            <div class="notch bottom"></div>
        </div>

        <!-- Right Section: Login Form -->
        <div class="right-section">
            <div class="login-container">
                <img src="{{ asset('images/Group (1).png') }}" alt="Logo" class="logo">
                <p class="form-eyebrow">Boarding Pass &middot; Admin</p>
                <h2>Login</h2>

                <!-- Error Message -->
                @if (session('error'))
                    <div class="error-message" id="errorMessage">{{ session('error') }}</div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('admin.login.authentication') }}">
                    @csrf

                    <div class="field">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16v16H4z" stroke="none" />
                            <path d="M3 6l9 7 9-7" />
                            <path d="M3 6h18v12H3z" />
                        </svg>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="field">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="11" width="14" height="9" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <!-- Forgot Password Link -->
                    <a href="#" class="forgot-password">Forgot password?</a>

                    <button type="submit" class="login-button">Take off &rarr;</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show error message if it exists
            let errorMessage = document.getElementById("errorMessage");
            if (errorMessage) {
                errorMessage.style.display = "block";
                setTimeout(() => {
                    errorMessage.style.display = "none";
                }, 5000);
            }
        });

        document.querySelector("#loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = data.redirect; // Redirect on success
                    } else {
                        let errorDiv = document.createElement("div");
                        errorDiv.className = "error-message";
                        errorDiv.innerText = data.message;
                        errorDiv.style.display = "block";
                        document.querySelector(".login-container").prepend(errorDiv);
                        setTimeout(() => errorDiv.remove(), 5000);
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>

</body>

</html>