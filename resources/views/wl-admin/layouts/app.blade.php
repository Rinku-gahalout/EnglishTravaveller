<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel') | EnglishTraveller</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/faicon.png') }}" type="image/png">

    <!-- Fonts (loaded once for the whole panel) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&family=Space+Mono:wght@400;700&display=swap">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Boxicons (pinned version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Summernote -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">

    <style>
        /* =====================================================
           EnglishTraveller admin theme
           Forest green #2d382b + copper #9c6037 + cream #ffffff.
           Change the colors here and the whole panel follows.
        ===================================================== */
        :root {
            --navy-deep: #2d382b;
            --navy-mid: #3a4838;
            --navy-soft: #4f6149;
            --sky: #5d7856;
            --sky-bright: #b5c9ad;
            --sky-soft: #e6ecdf;
            --cream-light: #ffffff;
            --sunset: #9c6037;
            --sunset-bright: #d9a273;
            --sunset-soft: #f7e8de;
            --cloud: #ffffff;
            --ink: #232b21;
            --ink-soft: #6b7466;
            --green: #3d7a4a;
            --red: #d64545;
            --line: rgba(45, 56, 43, .1);

            /* aliases so pages not redesigned yet pick up the new colors */
            --brass: var(--sunset);
            --brass-bright: var(--sunset-bright);
            --paper: var(--cloud);

            --sidebar-width: 260px;
            --header-height: 70px;
            --body-font: 'Inter', sans-serif;
            --display-font: 'Outfit', sans-serif;
            --mono-font: 'Space Mono', monospace;
        }

        html, body { min-height: 100%; overflow-x: hidden; }

        body {
            font-family: var(--body-font);
            color: var(--ink);
            background-color: var(--cloud);
            /* radar / flight-range rings from the top-right corner + a fine dot grid */
            background-image:
                repeating-radial-gradient(circle at 100% 0, transparent 0 78px, rgba(93, 120, 86, .09) 78px 79px),
                radial-gradient(rgba(45, 56, 43, .07) 1px, transparent 1.5px);
            background-size: auto, 26px 26px;
            background-attachment: fixed;
        }

        /* ---------- App shell ---------- */
        .sidebar-wrapper {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-width); height: 100vh;
            z-index: 1040;
            transition: transform .3s ease;
        }

        .dashboard-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding-top: var(--header-height);   /* room for the fixed header */
        }

        .sidebar-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(45, 56, 43, .6); z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .sidebar-wrapper { transform: translateX(-100%); }
            body.nav-open .sidebar-wrapper { transform: none; }
            body.nav-open .sidebar-backdrop { display: block; }
            .dashboard-wrapper { margin-left: 0; }
        }

        /* ---------- Summernote ---------- */
        .note-editor.note-frame {
            border: 1px solid rgba(45, 56, 43, .18) !important;
            border-radius: .75rem !important;
            overflow: hidden;
        }
        .note-editor .note-toolbar { background: var(--sky-soft); border-bottom: 1px solid var(--line); }
        .note-editor .note-editable { background: #fff; min-height: 300px; }
        .note-editor .note-statusbar { background: var(--sky-soft); }

        @media (prefers-reduced-motion: reduce) {
            .sidebar-wrapper { transition: none; }
        }
    </style>

    @yield('styles')
</head>

<body>

<div class="app-shell">

    <!-- Sidebar -->
    <aside class="sidebar-wrapper" id="sidebar">
        @include('wl-admin.layouts.sidebar')
    </aside>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Dashboard -->
    <div class="dashboard-wrapper">
        @include('wl-admin.layouts.header')

        <main>
            @yield('content')
        </main>
    </div>

</div>

@include('wl-admin.layouts.footer')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Mobile sidebar toggle
    const toggle   = document.getElementById("sidebarToggle");
    const backdrop = document.getElementById("sidebarBackdrop");

    if (toggle) {
        toggle.addEventListener("click", function () {
            document.body.classList.toggle("nav-open");
        });
    }
    if (backdrop) {
        backdrop.addEventListener("click", function () {
            document.body.classList.remove("nav-open");
        });
    }

    // Delete confirmation for pages that use the generic .delete-btn
    document.querySelectorAll(".delete-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            const form = this.closest("form");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d64545",
                cancelButtonColor: "#4f6149",
                confirmButtonText: "Yes, delete it"
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>

@yield('scripts')

</body>
</html>