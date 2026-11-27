<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel')</title>

    <!--<link rel="icon" type="image/png"-->
    <!--      href="{{ asset('images/favicon-07.png') }}">-->
          
            <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/faicon.png') }}" type="image/png">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Boxicons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Summernote -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">

    <style>
        :root {
            --sidebar-width: 250px;
        }

        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
        }

        .container-fluid {
            min-height: 100vh;
        }

        .row.g-0 {
            min-height: 100vh;
        }

        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .dashboard-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        @media (max-width: 767.98px) {

            .sidebar-wrapper {
                position: relative;
                width: 100%;
                height: auto;
                overflow: visible;
            }

            .dashboard-wrapper {
                margin-left: 0;
            }
        }

        /* Summernote styling */
        .note-editor.note-frame {
            border: 1px solid rgba(22, 35, 43, .18) !important;
            border-radius: .75rem !important;
            overflow: hidden;
        }

        .note-editor .note-toolbar {
            background: #f6f1e4;
            border-bottom: 1px solid rgba(22, 35, 43, .12);
        }

        .note-editor .note-editable {
            background: #fff;
            min-height: 300px;
        }

        .note-editor .note-statusbar {
            background: #f6f1e4;
        }
    </style>

    @yield('styles')
</head>

<body>

<div class="container-fluid">
    <div class="row g-0">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar-wrapper">
            @include('wl-admin.layouts.sidebar')
        </div>

        <!-- Dashboard -->
        <div class="col-md-9 col-lg-10 dashboard-wrapper">

            @include('wl-admin.layouts.header')

            @yield('content')

        </div>

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


<!-- Delete confirmation -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".delete-btn").forEach(button => {

        button.addEventListener("click", function () {

            const form = this.closest("form");
            const deleteUrl = this.getAttribute("data-url");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});
</script>

@yield('scripts')

</body>
</html>