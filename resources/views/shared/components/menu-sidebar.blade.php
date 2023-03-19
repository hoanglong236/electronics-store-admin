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
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li>
                            <a href="index.html">Dashboard 1</a>
                        </li>
                        <li>
                            <a href="index2.html">Dashboard 2</a>
                        </li>
                        <li>
                            <a href="index3.html">Dashboard 3</a>
                        </li>
                        <li>
                            <a href="index4.html">Dashboard 4</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="chart.html">
                        <i class="fas fa-chart-bar"></i>Charts</a>
                </li>
                <li>
                    <a href="table.html">
                        <i class="fas fa-table"></i>Tables</a>
                </li>
                <li class="{{ Request::routeIs('catalog.brand.*') ? 'active' : '' }}">
                    <a href="{{ route('catalog.brand.index') }}">
                        <i class="fas fa-tag"></i>Brand
                    </a>
                </li>
                <li class="{{ Request::routeIs('catalog.category.*') ? 'active' : '' }}">
                    <a href="{{ route('catalog.category.index') }}">
                        <i class="fas fa-tag"></i>Category
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
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
