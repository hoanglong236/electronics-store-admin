<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('assets/images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ Request::routeIs('dashboard.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
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
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
