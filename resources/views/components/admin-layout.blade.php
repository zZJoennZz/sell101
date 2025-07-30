<html>
    <head>
        <title>{{ $title . ' | ' . env('APP_NAME') }}</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            .admin-sidebar {
                min-height: 100vh;
            }
            @media (max-width: 992px) {
                .admin-sidebar {
                    min-height: auto;
                }
                main.admin-main {
                    margin-left: 0 !important;
                }
            }
        </style>
    </head>
    <body>
        <!-- Preloader Overlay -->
        <div id="preloader-overlay" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:2000;background:rgba(255,255,255,0.95);display:flex;align-items:center;justify-content:center;">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-teal-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <ul id="slide-out" class="sidenav sidenav-fixed admin-sidebar teal lighten-5">
            <li>
                <div class="user-view">
                    <div class="background teal lighten-2"></div>
                    <a href="#user"><img class="circle" src="https://ui-avatars.com/api/?name=Admin"></a>
                    <a href="#name"><span class="white-text name">Admin</span></a>
                    <a href="#email"><span class="white-text email">admin@sell101.com</span></a>
                </div>
            </li>
            <li><a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="material-icons">dashboard</i>Dashboard</a></li>
            <li><a href="#orders" class="waves-effect"><i class="material-icons">assignment</i>Orders</a></li>
            <li><a href="{{ route('admin.productsdash') }}" class="waves-effect"><i class="material-icons">local_pharmacy</i>Products</a></li>
            <li><a href="#customers" class="waves-effect"><i class="material-icons">people</i>Customers</a></li>
            <li><a href="{{ route('admin.reports') }}" class="waves-effect"><i class="material-icons">bar_chart</i>Reports</a></li>
            <li><div class="divider"></div></li>
            <li><a href="#settings" class="waves-effect"><i class="material-icons">settings</i>Settings</a></li>
            <li><a href="#logout" class="waves-effect"><i class="material-icons">exit_to_app</i>Logout</a></li>
        </ul>
        <a href="#" data-target="slide-out" class="sidenav-trigger hide-on-large-only btn-floating btn-small teal" style="position:fixed;top:16px;left:16px;z-index:1001;">
            <i class="material-icons">menu</i>
        </a>
        <main style="margin-left:300px; padding:32px 16px 16px 16px;" class="admin-main">
            <nav class="white" style="box-shadow:none;">
                <div class="nav-wrapper">
                    <span class="brand-logo black-text" style="font-size:1.5rem; margin-left:16px;">{{ $title }}</span>
                    <ul class="right">
                        <li><a href="#!" class="black-text"><i class="material-icons">notifications</i></a></li>
                        <li><a href="#!" class="black-text"><i class="material-icons">account_circle</i></a></li>
                    </ul>
                </div>
            </nav>
            {{ $slot }}
        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var sidenav = document.querySelectorAll('.sidenav');
                M.Sidenav.init(sidenav);
                // Hide preloader after page load
                setTimeout(function() {
                    var preloader = document.getElementById('preloader-overlay');
                    if (preloader) {
                        preloader.style.opacity = 0;
                        setTimeout(function() {
                            preloader.style.display = 'none';
                        }, 400);
                    }
                }, 400); // Adjust delay as needed
            });
        </script>
    </body>
</html>