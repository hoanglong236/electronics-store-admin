@extends('layouts.base-layout')

@section('page-content')
    <!-- HEADER MOBILE-->
    @include('layouts.components.header-mobile')
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    @include('layouts.components.menu-sidebar')
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        @include('layouts.components.header-desktop')
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
        <!-- END MAIN CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
@endsection
