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
<body>
    <div class="bg-login text-center">
        <img src="{{ asset('images/logo.svg') }}" class="d-inline-block w-60px mb-3 mr-3 mt-2">
        <div class="d-inline-block">
            <h3 class="text-white">Công ty Bưu điện Bảo Thắng </h3>
        </div>
        {{-- <div class="float-right text-white mt-3 mr-100">
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
        </div> --}}
    </div>

    <div class="container" style="font-size: 20px;">
        <div class="row">
            <div class="col-12 mt-3 text-center mb-3">
                <p class="font-weight-bold mb-0 h3">BIÊN NHẬN</p>
                <p class="font-weight-bold mb-0 h3">NẠP VÍ THANH TOÁN TIỀN ĐIỆN</p>
            </div>
            <div class="col-12">
                <p class="">Mã KH: <span class="float-right">{{ $bill->user->code }}</span></p>
                <p class="">Tên KH: <span class="float-right">{{ $bill->user->name }}</span></p>
                <p class="">SĐT: <span class="float-right">{{ $bill->user->phone }}</span></p>
                <p class="">Địa chỉ: <span class="float-right">{{ $bill->user->address }}</span></p>
                <p class="">Kỳ thu: <span class="float-right">{{ date_format(new DateTime($bill->period), "m/Y") }}</span></p>
                <table class="table table-bordered">
                    <tr>
                        <td>Bậc</td>
                        <td>Khoảng số điện áp dụng (kWh)</td>
                        <td>Đơn giá (VND)</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>0 - 50</td>
                        <td>1,678</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>51 - 100</td>
                        <td>1,734</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>101 - 200</td>
                        <td>2,014</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>201 - 300</td>
                        <td>2,536</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>301 - 400</td>
                        <td>2,834</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>401 trở lên</td>
                        <td>2,927</td>
                    </tr>
                </table>
                <p>Số điện tiêu thụ: <span class="float-right">{{ number_format($bill->power_number) }} kWh</span></p>
                <p>Tổng tiền: <span class="float-right">{{ number_format($bill->price) }} VND</span></p>
                <p>Ngày in: <span class="float-right">{{ $today }}</span></p>
                <p>Tổng HĐ: <span class="float-right">{{ number_format($bill->price) }} VND</span></p>
            </div>
        </div>
    </div>
</body>
</html>