<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    </head>
<body class="body-admin">
	<div class="bg-login">
        <img src="{{ asset('images/logo.svg') }}" class="d-inline-block w-60px mb-3 mr-3 ml-3 mt-2">
        <div class="d-inline-block">
            <h3 class="text-white">Website thu tiền điện của Công ty Bưu điện Bảo Thắng </h3>
        </div>

        <div class="float-right text-white mt-3 mr-100">
            <div class="dropdown">
                <button class="btn text-white dropdown-toggle w-160px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} <i class="fa fa-angle-down ml-2" aria-hidden="true"></i></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('dashboard') }}">Thu cước</a>
                    @role('admin')
                        <a class="dropdown-item" href="{{ route('role') }}">QL quyền</a>
                        <a class="dropdown-item" href="{{ route('staff') }}">QL nhân viên</a>
                        <a class="dropdown-item" href="{{ route('revenue') }}">QL doanh thu</a>
                    @endrole
                    <a class="dropdown-item" href="{{ route('customers.index') }}">QL khách hàng</a>
                    <a class="dropdown-item" href="{{ route('bills.index') }}">QL hóa đơn</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Đăng xuất') }}
                        </x-dropdown-link>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
    @yield('script')

	{{-- <script src="theme/frontend/js/jquery-2.2.1.min.js"></script>
	<script src="theme/frontend/js/bootstrap.min.js"></script>
	<script src="theme/frontend/js/script.js"></script>
	<script src="theme/frontend/slick/slick.js"></script>
	<script src="theme/frontend/js/select2.min.js"></script> --}}
</body>
</html>