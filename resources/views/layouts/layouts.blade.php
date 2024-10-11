<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- JavaScript files -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @yield('head') 
</head>
<body>
    @include('frontend.includes.nav') 

    <div id="layoutSidenav">
        @include('frontend.includes.side_nav')

        <div id="layoutSidenav_content">
            <main>
                <div class="">                
                    @yield('content') 
                </div>
            </main>
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
    </footer>
  
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery DateTimePicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

            const toggleSidebar = document.querySelector('#sidebarToggle');
            toggleSidebar.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-collapsed');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
