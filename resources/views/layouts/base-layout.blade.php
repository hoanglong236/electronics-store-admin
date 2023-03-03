<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.page-header')
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#" class="logo-wrapper">
                    <img src="{{ asset('assets/images/icon/tiny-logo.png') }}" alt="lhstore" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="{{ route('dashboard.index') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('catalog.category.index') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Category</a>
                        </li>
                        <li>
                            <a href="{{ route('catalog.brand.index') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Brand</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('admin.coupon') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Coupon</a>
                        </li> --}}
                        <li>
                            <a href="{{ route('catalog.product.index') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Product</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('admin.customer') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Customer</a>
                        </li> --}}
                        {{-- <li>
                            <a href="{{ route('admin.order') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Order</a>
                        </li> --}}
                        {{-- <li>
                            <a href="{{ route('admin.slider') }}" style="text-decoration: none;">
                                <i class="fas fa-tachometer-alt"></i>Slider</a>
                        </li> --}}
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"
                                                style="text-decoration: none;">{{ Session::get('ADMIN_NAME') }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('admin.logout') }}" style="text-decoration: none;">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @section('container')
                        @show
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTAINER-->

        </div>
    </div>

    @include('layouts.page-footer')
</body>

</html>
