<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-07.png') }}" style="height: 18px; width:18px;">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
        }

        html, body {
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
                            form.submit(); // Submit the form
                        }
                    });
                });
            });
        });
        </script>
         @section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    tinymce.init({ selector: '#editor' });
});
</script>
@endsection

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @yield('scripts')
</body>
</html>
