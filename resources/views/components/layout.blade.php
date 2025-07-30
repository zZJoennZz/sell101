<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | ' . env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .top-nav {
            background-color: #00897b;
            padding: 10px 0;
            text-align: right;
        }

        .top-nav a {
            color: #fff;
            margin-right: 24px;
            font-weight: 500;
        }

        .brand-logo {
            font-size: 2rem;
            color: #00897b;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
        }

        .main-nav {
            background-color: #fff;
            padding: 10px 0 0 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .nav-mobile {
            display: none;
        }

        @media (max-width: 992px) {
            .search-bar {
                max-width: 100%;
            }

            .main-nav .col.s4,
            .main-nav .col.s3 {
                text-align: center !important;
            }

            .nav-desktop {
                display: none !important;
            }

            .nav-mobile {
                display: block !important;
            }
        }

        @media (max-width: 600px) {
            .main-nav .brand-logo {
                font-size: 1.3rem;
            }

            .product-card img {
                height: 120px;
            }

            .nav-mobile .brand-logo {
                font-size: 1.1rem;
            }
        }

        footer {
            background-color: #00897b;
            color: #fff;
            padding: 24px 0 8px 0;
            text-align: center;
        }

        footer ul {
            list-style: none;
            padding: 0;
            margin: 12px 0 0 0;
        }

        footer ul li {
            display: inline-block;
            margin: 0 10px;
        }

        footer ul li a {
            color: #fff;
            text-decoration: underline;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="top-nav nav-desktop">
        <a href="#"><i class="material-icons left" style="vertical-align:middle;">person</i>Register/Login</a>
    </div>
    <div class="main-nav nav-desktop">
        <div class="row valign-wrapper" style="margin-bottom:0;">
            <div class="col s12 m3 left-align">
                <span class="brand-logo">SELL101</span>
            </div>
            <div class="col s12 m6">
                <form class="search-bar" style="margin:0;">
                    <div class="input-field" style="margin:0;">
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <input id="search" type="search" placeholder="Search for medicines, beauty, wellness..." required style="padding-left:16px;">
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
            <div class="col s12 m3 right-align">
                <a href="#" class="btn-flat" style="color:#00897b;font-weight:500;">
                    <i class="material-icons left">shopping_cart</i>Cart
                </a>
            </div>
        </div>
    </div>
    <!-- Mobile Nav -->
    <nav class="nav-mobile white" style="box-shadow:none;display:none;">
        <div class="nav-wrapper" style="padding:0 10px;">
            <a href="#" class="brand-logo left" style="font-size:1.3rem;">SELL101</a>
            <a href="#" data-target="mobile-menu" class="sidenav-trigger right"><i class="material-icons teal-text">menu</i></a>
        </div>
    </nav>
    <ul class="sidenav" id="mobile-menu">
        <li>
            <form style="margin:0;padding:10px;">
                <div class="input-field" style="margin:0;">
                    <input id="search-mobile" type="search" placeholder="Search..." required style="background:#f5f5f5; border-radius:24px; padding-left:16px;">
                    <label class="label-icon" for="search-mobile"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </li>
        <li><a href="#"><i class="material-icons left">shopping_cart</i>Cart</a></li>
        <li><a href="#"><i class="material-icons left">person</i>Register/Login</a></li>
    </ul>
    {{ $slot }}
    <footer>
        <p>&copy; {{ date('Y') }} SEL101. All rights reserved.</p>
        <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">FAQs</a></li>
        </ul>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);

            var sidenav = document.querySelectorAll('.sidenav');
            M.Sidenav.init(sidenav);
        });
    </script>
</body>

</html>