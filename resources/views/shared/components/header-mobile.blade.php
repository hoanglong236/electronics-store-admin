<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="index.html">
                    <img src="{{ asset('assets/images/icon/logo.png') }}" alt="CoolAdmin" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li class="{{ Request::routeIs('dashboard.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li class="{{ Request::routeIs('monthly-report.*') ? 'active' : '' }}">
                    <a href="{{ route('monthly-report.index') }}">
                        <i class="fas fa-chart-bar"></i>Monthly Report
                    </a>
                </li>
                <li class="{{ Request::routeIs('catalog.category.*') ? 'active' : '' }}">
                    <a href="{{ route('catalog.category.index') }}">
                        <i class="fas fa-tag"></i>Category
                    </a>
                </li>
                <li class="{{ Request::routeIs('catalog.brand.*') ? 'active' : '' }}">
                    <a href="{{ route('catalog.brand.index') }}">
                        <i class="fas fa-tag"></i>Brand
                    </a>
                </li>
                <li class="{{ Request::routeIs('catalog.product.*') ? 'active' : '' }}">
                    <a href="{{ route('catalog.product.index') }}">
                        <i class="fas fa-tag"></i>Product
                    </a>
                </li>
                <li class="{{ Request::routeIs('manage.customer.*') ? 'active' : '' }}">
                    <a href="{{ route('manage.customer.index') }}">
                        <i class="fas fa-tag"></i>Customer
                    </a>
                </li>
                <li class="{{ Request::routeIs('manage.order.*') ? 'active' : '' }}">
                    <a href="{{ route('manage.order.index') }}">
                        <i class="fas fa-tag"></i>Order
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->
