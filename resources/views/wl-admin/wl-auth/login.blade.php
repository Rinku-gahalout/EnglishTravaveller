<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=DM+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* ===========================================================
           TOKENS  (same colour theme as before)
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

            --font-display: 'Bricolage Grotesque', sans-serif;
            --font-body: 'DM Sans', sans-serif;
            --font-mono: 'Space Mono', monospace;

            --ease: cubic-bezier(.22, 1, .36, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            position: relative;
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
            overflow-x: hidden;
        }

        /* slow radar sweep behind the ticket */
        body::before {
            content: "";
            position: fixed;
            left: 50%;
            top: 50%;
            width: 150vmax;
            height: 150vmax;
            margin: -75vmax 0 0 -75vmax;
            background: conic-gradient(from 0deg, rgba(201, 162, 106, .16) 0deg, rgba(201, 162, 106, 0) 38deg, transparent 39deg);
            -webkit-mask-image: radial-gradient(circle, #000 0 30%, transparent 62%);
            mask-image: radial-gradient(circle, #000 0 30%, transparent 62%);
            animation: sweep 14s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }

        /* ===========================================================
           TICKET  (prints out top-to-bottom on load)
        ============================================================ */
        .container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            max-width: 940px;
            min-height: 540px;
            background: var(--paper);
            border-radius: 18px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .5);
            clip-path: inset(0 -80px 100% -80px round 18px);
            animation: print 1.1s var(--ease) .1s forwards;
        }

        /* ---------- Left: gate panel ---------- */
        .left-section {
            position: relative;
            flex: 1.05;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(160deg, var(--navy-mid), var(--navy-deep) 70%);
            color: var(--paper);
            padding: 40px 40px 36px;
            overflow: hidden;
            border-radius: 18px 0 0 18px;
        }

        .left-section > *:not(.flight-map) { position: relative; z-index: 2; }

        .gate-eyebrow {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--brass-bright);
            opacity: .9;
        }

        .gate-heading {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: clamp(44px, 6vw, 64px);
            line-height: .92;
            letter-spacing: -.02em;
            margin-top: 14px;
        }

        .gate-heading span { display: block; color: var(--brass); }

        .gate-sub {
            margin-top: 16px;
            max-width: 270px;
            font-size: 14.5px;
            line-height: 1.6;
            color: rgba(246, 241, 228, .68);
        }

        /* flight path */
        .flight-map {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .flight-map .route {
            fill: none;
            stroke: var(--brass);
            stroke-width: 1.3;
            stroke-linecap: round;
            stroke-dasharray: 4 9;
            opacity: .45;
            animation: dashMove 9s linear infinite;
        }

        .flight-map .route-faint { opacity: .16; stroke-width: 1; }

        .flight-map .trail {
            fill: none;
            stroke: var(--brass-bright);
            stroke-width: 2.2;
            stroke-linecap: round;
            filter: drop-shadow(0 0 5px rgba(231, 198, 140, .8));
        }

        .flight-map .dot { fill: var(--brass-bright); }

        .flight-map .ring {
            fill: none;
            stroke: var(--brass-bright);
            stroke-width: 1.2;
            transform-box: fill-box;
            transform-origin: center;
            animation: ping 3.2s ease-out infinite;
            animation-delay: var(--d, 0s);
        }

        /* split-flap board */
        .board {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
        }

        .code { display: flex; flex-direction: column; gap: 8px; }
        .code.dest { align-items: flex-end; }

        .code-label {
            font-size: 12.5px;
            font-weight: 500;
            color: rgba(246, 241, 228, .6);
        }

        .flaps { display: flex; gap: 4px; perspective: 400px; }

        .flap {
            position: relative;
            display: inline-grid;
            place-items: center;
            width: 30px;
            height: 42px;
            border-radius: 5px;
            background: linear-gradient(180deg, var(--navy-soft) 0 50%, #173646 50% 100%);
            color: var(--brass-bright);
            font-family: var(--font-mono);
            font-weight: 700;
            font-size: 22px;
            box-shadow: inset 0 0 0 1px rgba(231, 198, 140, .14), 0 6px 12px rgba(0, 0, 0, .35);
        }

        /* the hinge line across the middle */
        .flap::after {
            content: "";
            position: absolute;
            left: 0; right: 0; top: 50%;
            height: 1px;
            background: rgba(0, 0, 0, .55);
        }

        .flap.flip { animation: flip .16s ease-out; }

        /* ---------- perforated seam ---------- */
        .seam { position: relative; width: 0; flex: 0 0 auto; }

        .seam::before {
            content: "";
            position: absolute;
            top: 0; bottom: 0; left: -1px;
            width: 2px;
            background-image: repeating-linear-gradient(to bottom, transparent 0 6px, var(--paper-dim) 6px 16px);
        }

        .seam .notch {
            position: absolute;
            left: -11px;
            width: 22px; height: 22px;
            border-radius: 50%;
            background: var(--navy-deep);
        }

        .seam .notch.top { top: -11px; }
        .seam .notch.bottom { bottom: -11px; }

        /* ---------- Right: login panel ---------- */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border-radius: 0 18px 18px 0;
        }

        .login-container { width: 100%; max-width: 330px; text-align: center; }
        .login-container.shake { animation: shake .5s cubic-bezier(.36, .07, .19, .97); }

        .logo { width: 140px; margin: 0 auto 4px; display: block; }

        .form-eyebrow { font-size: 13px; font-weight: 500; color: var(--ink-soft); }

        h2 {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -.02em;
            color: var(--ink);
            margin: 4px 0 20px;
        }

        .error-message {
            background: var(--error);
            color: #fff;
            padding: 11px 14px;
            margin-bottom: 12px;
            border-radius: 10px;
            font-size: 13.5px;
            text-align: left;
            display: none;
            animation: dropIn .35s ease forwards;
        }

        /* floating-label fields */
        .field { position: relative; margin: 14px 0; }

        .field input {
            width: 100%;
            padding: 22px 44px 8px 42px;
            border: 1.5px solid #e2dbc8;
            border-radius: 11px;
            background: #fcfaf3;
            outline: none;
            font-family: var(--font-body);
            font-size: 15px;
            color: var(--ink);
            transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
        }

        .field input::placeholder { color: transparent; }

        .field input:focus {
            border-color: var(--brass);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201, 162, 106, .18);
        }

        .field label {
            position: absolute;
            left: 42px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14.5px;
            color: #8d8a7c;
            pointer-events: none;
            transition: top .25s var(--ease), font-size .25s var(--ease), color .25s, transform .25s var(--ease);
        }

        .field input:focus + label,
        .field input:not(:placeholder-shown) + label,
        .field input:-webkit-autofill + label {
            top: 10px;
            transform: none;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--brass);
        }

        /* brass underline draws in on focus */
        .field::after {
            content: "";
            position: absolute;
            left: 12px; right: 12px; bottom: 1px;
            height: 2px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--brass), var(--brass-bright));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .45s var(--ease);
            pointer-events: none;
        }

        .field:focus-within::after { transform: scaleX(1); }

        .field-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: var(--ink-soft);
            pointer-events: none;
            transition: color .25s, transform .35s var(--ease);
        }

        .field:focus-within .field-icon { color: var(--brass); transform: translateY(-50%) scale(1.15); }

        .toggle-pass {
            position: absolute;
            right: 6px; top: 50%;
            transform: translateY(-50%);
            width: 36px; height: 36px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--ink-soft);
            cursor: pointer;
            transition: color .2s, background .2s;
        }

        .toggle-pass:hover { color: var(--brass); background: rgba(201, 162, 106, .12); }
        .toggle-pass:focus-visible { outline: 2px solid var(--brass); }
        .toggle-pass svg { width: 18px; height: 18px; }
        .toggle-pass .eye-off { display: none; }
        .toggle-pass.on .eye { display: none; }
        .toggle-pass.on .eye-off { display: block; }

        .forgot-password {
            display: block;
            text-align: right;
            margin: 2px 0 18px;
            font-size: 13px;
            color: var(--ink-soft);
            text-decoration: none;
            transition: color .25s ease;
        }

        .forgot-password:hover { color: var(--brass); text-decoration: underline; }

        /* login button */
        .login-button {
            position: relative;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--navy-mid), var(--navy-deep));
            color: var(--brass-bright);
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 10px 24px rgba(11, 29, 38, .35);
        }

        .login-button:hover { transform: translateY(-2px); box-shadow: 0 14px 30px rgba(11, 29, 38, .45); }
        .login-button:active { transform: translateY(0) scale(.98); }
        .login-button:focus-visible { outline: 3px solid var(--brass); outline-offset: 3px; }
        .login-button:disabled { cursor: progress; transform: none; }

        .login-button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(231, 198, 140, .35) 50%, transparent 70%);
            transform: translateX(-120%);
        }

        .login-button:hover::after { transform: translateX(120%); transition: transform .8s ease; }

        .btn-plane { width: 18px; height: 18px; transform: rotate(90deg); transition: transform .4s var(--ease); }
        .login-button:hover .btn-plane { transform: rotate(90deg) translateY(-5px); }

        /* on submit the plane taxis off the button */
        .login-button.is-loading .btn-plane { animation: takeoff 1s ease-in infinite; }

        /* barcode footer */
        .barcode {
            position: relative;
            height: 34px;
            margin-top: 26px;
            border-radius: 3px;
            opacity: .55;
            overflow: hidden;
            background: repeating-linear-gradient(90deg,
                var(--ink) 0 2px, transparent 2px 5px,
                var(--ink) 5px 6px, transparent 6px 10px,
                var(--ink) 10px 13px, transparent 13px 15px,
                var(--ink) 15px 16px, transparent 16px 20px);
        }

        .barcode::after {
            content: "";
            position: absolute;
            top: 0; bottom: 0;
            width: 40%;
            background: linear-gradient(90deg, transparent, rgba(201, 162, 106, .9), transparent);
            transform: translateX(-120%);
            animation: scan 4.5s ease-in-out 1.6s infinite;
        }

        /* ===========================================================
           KEYFRAMES
        ============================================================ */
        @keyframes print {
            to { clip-path: inset(-80px -80px -80px -80px round 18px); }
        }

        @keyframes sweep { to { transform: rotate(360deg); } }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes dashMove { to { stroke-dashoffset: -260; } }

        @keyframes ping {
            0%   { transform: scale(1);   opacity: .75; }
            100% { transform: scale(5.5); opacity: 0; }
        }

        @keyframes flip {
            from { transform: rotateX(-90deg); opacity: .4; }
            to   { transform: rotateX(0);      opacity: 1; }
        }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(4px); }
            30%, 50%, 70% { transform: translateX(-7px); }
            40%, 60% { transform: translateX(7px); }
        }

        @keyframes takeoff {
            0%   { transform: rotate(90deg) translateY(0);      opacity: 1; }
            70%  { transform: rotate(90deg) translateY(-34px);  opacity: 0; }
            71%  { transform: rotate(90deg) translateY(30px);   opacity: 0; }
            100% { transform: rotate(90deg) translateY(0);      opacity: 1; }
        }

        @keyframes scan {
            0%, 20% { transform: translateX(-120%); }
            70%, 100% { transform: translateX(320%); }
        }

        /* ===========================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 820px) {
            .container { flex-direction: column; min-height: auto; }

            .left-section { padding: 30px 26px; min-height: 250px; border-radius: 18px 18px 0 0; }
            .gate-heading { font-size: 40px; }
            .gate-sub { max-width: 100%; }

            .seam { width: 100%; height: 0; }

            .seam::before {
                top: -1px; bottom: auto; left: 0; right: 0;
                width: auto; height: 2px;
                background-image: repeating-linear-gradient(to right, transparent 0 6px, var(--paper-dim) 6px 16px);
            }

            .seam .notch { top: -11px; left: auto; }
            .seam .notch.top { left: -11px; }
            .seam .notch.bottom { right: -11px; left: auto; }

            .right-section { padding: 32px 26px; border-radius: 0 0 18px 18px; }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Left Section: gate panel -->
        <div class="left-section">

            <svg class="flight-map" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                <path class="route route-faint" d="M30,150 C110,190 190,90 370,310" />
                <path class="route" id="flightPath" d="M52,436 C124,372 150,268 214,214 C276,162 330,120 356,58" />

                <!-- contrail: a short bright tail that follows the plane -->
                <path class="trail" d="M52,436 C124,372 150,268 214,214 C276,162 330,120 356,58"
                      pathLength="100" stroke-dasharray="16 200" stroke-dashoffset="16">
                    <animate attributeName="stroke-dashoffset" values="16;-84" dur="7s" repeatCount="indefinite" />
                    <animate attributeName="opacity" values="0;1;1;0" keyTimes="0;.1;.9;1" dur="7s" repeatCount="indefinite" />
                </path>

                <circle class="dot" cx="52" cy="436" r="4" />
                <circle class="dot" cx="356" cy="58" r="4" />
                <circle class="ring" cx="52" cy="436" r="5" />
                <circle class="ring" cx="52" cy="436" r="5" style="--d:1.6s" />
                <circle class="ring" cx="356" cy="58" r="5" style="--d:.8s" />

                <g>
                    <animateMotion dur="7s" repeatCount="indefinite" rotate="auto">
                        <mpath href="#flightPath" />
                    </animateMotion>
                    <animate attributeName="opacity" values="0;1;1;0" keyTimes="0;.1;.9;1" dur="7s" repeatCount="indefinite" />
                    <g transform="rotate(90) translate(-10.8 -11) scale(.9)" fill="#e7c68c">
                        <path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2.5 1.8V22l4-1 4 1v-1.2L13 19v-5.5l8 2.5z" />
                    </g>
                </g>
            </svg>

            <div class="gate-eyebrow">Restricted area &middot; Ground control</div>

            <div>
                <h1 class="gate-heading">Control<span>Tower</span></h1>
                <p class="gate-sub">Sign in to manage routes, fares, and every seat on the board.</p>
            </div>

            <!-- Split-flap departure board -->
            <div class="board">
                <div class="code">
                    <span class="code-label">Origin</span>
                    <div class="flaps" role="img" aria-label="DEL">
                        <span class="flap" aria-hidden="true">D</span><span class="flap" aria-hidden="true">E</span><span class="flap" aria-hidden="true">L</span>
                    </div>
                </div>
                <div class="code dest">
                    <span class="code-label">Access level</span>
                    <div class="flaps" role="img" aria-label="ADMIN">
                        <span class="flap" aria-hidden="true">A</span><span class="flap" aria-hidden="true">D</span><span class="flap" aria-hidden="true">M</span><span class="flap" aria-hidden="true">I</span><span class="flap" aria-hidden="true">N</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="seam">
            <div class="notch top"></div>
            <div class="notch bottom"></div>
        </div>

        <!-- Right Section: login form -->
        <div class="right-section">
            <div class="login-container">
                <img src="{{ asset('images/Group (1).png') }}" alt="Logo" class="logo">
                <p class="form-eyebrow">Boarding pass &middot; Admin</p>
                <h2>Login</h2>

                <!-- Error Message -->
                @if (session('error'))
                    <div class="error-message" id="errorMessage">{{ session('error') }}</div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('admin.login.authentication') }}">
                    @csrf

                    <div class="field">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M3 6l9 7 9-7" />
                            <path d="M3 6h18v12H3z" />
                        </svg>
                        <input type="email" name="email" id="email" placeholder=" " autocomplete="username" required>
                        <label for="email">Email</label>
                    </div>

                    <div class="field">
                        <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="5" y="11" width="14" height="9" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                        <input type="password" name="password" id="password" placeholder=" " autocomplete="current-password" required>
                        <label for="password">Password</label>

                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                            <svg class="eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z" /><circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3l18 18" /><path d="M10.6 6.1A10 10 0 0 1 12 5c6.4 0 10 7 10 7a17 17 0 0 1-3.2 4M6.5 6.6A17 17 0 0 0 2 12s3.6 7 10 7a9.8 9.8 0 0 0 4.4-1" />
                            </svg>
                        </button>
                    </div>

                    <!-- Forgot Password Link -->
                    <a href="#" class="forgot-password">Forgot password?</a>

                    <button type="submit" class="login-button" id="loginBtn">
                        <span class="btn-label">Take off</span>
                        <svg class="btn-plane" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2.5 1.8V22l4-1 4 1v-1.2L13 19v-5.5l8 2.5z" />
                        </svg>
                    </button>
                </form>

                <div class="barcode" aria-hidden="true"></div>
            </div>
        </div>

    </div>

    <script>
        const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        document.addEventListener("DOMContentLoaded", function() {

            // Show error message if it exists
            let errorMessage = document.getElementById("errorMessage");
            if (errorMessage) {
                errorMessage.style.display = "block";
                setTimeout(() => {
                    errorMessage.style.display = "none";
                }, 5000);
            }

            // Pause the plane / contrail for reduced-motion users
            if (reduceMotion) {
                const map = document.querySelector(".flight-map");
                if (map && map.pauseAnimations) map.pauseAnimations();
            }

            /* ---------- Split-flap board ---------- */
            if (!reduceMotion) {
                const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

                document.querySelectorAll(".flap").forEach(function(flap, i) {
                    const finalChar = flap.textContent;
                    let ticks = 0;
                    const total = 9 + i * 4;

                    function step() {
                        ticks++;
                        flap.textContent = ticks >= total ? finalChar : chars[Math.floor(Math.random() * chars.length)];
                        flap.classList.remove("flip");
                        void flap.offsetWidth;
                        flap.classList.add("flip");
                        if (ticks < total) setTimeout(step, 70);
                    }

                    flap.textContent = " ";
                    setTimeout(step, 900 + i * 90);   // starts once the ticket has printed
                });
            }

            /* ---------- Show / hide password ---------- */
            const toggle = document.getElementById("togglePass");
            const pass = document.getElementById("password");

            toggle.addEventListener("click", function() {
                const show = pass.type === "password";
                pass.type = show ? "text" : "password";
                toggle.classList.toggle("on", show);
                toggle.setAttribute("aria-label", show ? "Hide password" : "Show password");
            });
        });

        document.querySelector("#loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const btn = document.getElementById("loginBtn");
            const label = btn.querySelector(".btn-label");
            const box = document.querySelector(".login-container");

            function resetButton() {
                btn.disabled = false;
                btn.classList.remove("is-loading");
                label.textContent = "Take off";
            }

            function shake() {
                box.classList.remove("shake");
                void box.offsetWidth;
                box.classList.add("shake");
            }

            btn.disabled = true;
            btn.classList.add("is-loading");
            label.textContent = "Checking clearance";

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
                        label.textContent = "Cleared";
                        window.location.href = data.redirect; // Redirect on success
                    } else {
                        resetButton();
                        shake();

                        let errorDiv = document.createElement("div");
                        errorDiv.className = "error-message";
                        errorDiv.innerText = data.message;
                        errorDiv.style.display = "block";
                        document.querySelector(".login-container").prepend(errorDiv);
                        setTimeout(() => errorDiv.remove(), 5000);
                    }
                })
                .catch(error => {
                    resetButton();
                    shake();
                    console.error("Error:", error);
                });
        });
    </script>

</body>

</html>