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
    <body class="bg-dashboard">
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
                        <a class="dropdown-item" href="{{ route('change-password-store') }}">Đổi mật khẩu</a>
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

        <div class="container mt-3">
            <div class="row">
                <div class="col-5">
                    <div class="bg-white">
                        @role('admin')
                            <form method="GET" action="{{ route('dashboard') }}" class="form-group text-secondary mb-0 pb-2 pt-3 pl-3 pr-3">
                                <input type="radio" name="key" value="code" class="" checked> Tìm Mã KH
                                <input type="radio" name="key" value="name" class="ml-3" {{ $key == 'name' ? 'checked' : '' }}> Tìm Tên KH
                                <input type="radio" name="key" value="phone" class="ml-3" {{ $key == 'phone' ? 'checked' : '' }}> Tìm Số điện thoại
                                <div class="row mt-2">
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="search">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('print') }}" class="pt-2 pb-2 pl-3 pr-3">
                                @csrf
                                <input type="number" name="proceeds" hidden>
                                <input type="number" name="id" hidden>
                                <button onfocus="selectBill()" type="submit" class="btn btn-primary" id="buttonPrint"><i class="fa fa-print" aria-hidden="true"></i> In giấy biên nhận</button>
                                <a href="{{ route('bills.index') }}" class="float-right mt-2"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử thu cước</a>
                            </form>
                        @endrole

                        @role('staff')
                            <form method="GET" action="{{ route('dashboard') }}" class="form-group text-secondary mb-0 pb-2 pt-3 pl-3 pr-3">
                                <input type="radio" name="key" value="code" class="" checked> Tìm Mã KH
                                <input type="radio" name="key" value="name" class="ml-3" {{ $key == 'name' ? 'checked' : '' }}> Tìm Tên KH
                                <input type="radio" name="key" value="phone" class="ml-3" {{ $key == 'phone' ? 'checked' : '' }}> Tìm Số điện thoại
                                <div class="row mt-2">
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="search">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('print') }}" class="pt-2 pb-2 pl-3 pr-3">
                                @csrf
                                <input type="number" name="proceeds" hidden>
                                <input type="number" name="id" hidden>
                                <button onfocus="selectBill()" type="submit" class="btn btn-primary" id="buttonPrint"><i class="fa fa-print" aria-hidden="true"></i> In giấy biên nhận</button>
                                <a href="{{ route('bills.index') }}" class="float-right mt-2"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử thu cước</a>
                            </form>
                        @endrole

                        @role('customer')
                            <form method="GET" action="{{ route('dashboard') }}" class="form-group text-secondary mb-0 pb-2 pt-3 pl-3 pr-3">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label class="font-weight-bold text-black">Mã hóa đơn</label>
                                        <input type="text" class="form-control" name="code" placeholder="Mã hóa đơn">
                                    </div>
                                    <div class="col-8">
                                        <label class="font-weight-bold text-black">Kỳ thu</label>
                                        <input type="month" name="period" class="form-control w-100">
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-end">
                                    <div class="col-3 mt-2">
                                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                        @endrole
                    </div>
                </div>

                <div class="col-7">
                    <div class="bg-white h-100">
                        <div class="row pt-3">
                            <div class="col-6">
                                @role('admin')
                                    <div class="pb-2 pl-3 pr-3">
                                        <p class="mb-0">Tổng tiền hóa đơn <span class="h5 text-danger font-weight-bold float-right">VNĐ</span><span class="float-right mr-1 h5 text-danger font-weight-bold" id="totalBill"></span></p>
                                        <p class="mb-0 mt-2">Số tiền thu <input min="0" type="number" id="proceeds" class="w-130 d-inline-block ml-80 form-control" onkeyup="importProceeds(this.value)"></p> 
                                        <p class="mb-0 mt-1">Tiền trả lại <span class="float-right"><span class="h5 text-primary font-weight-bold" id="amountReturnBill">0</span> VNĐ</span></p>
                                    </div>
                                @endrole
                                @role('staff')
                                    <div class="pb-2 pl-3 pr-3">
                                        <p class="mb-0">Tổng tiền hóa đơn <span class="h5 text-danger font-weight-bold float-right">VNĐ</span><span class="float-right mr-1 h5 text-danger font-weight-bold" id="totalBill"></span></p>
                                        <p class="mb-0 mt-2">Số tiền thu <input min="0" type="number" id="proceeds" class="w-130 d-inline-block ml-80 form-control" onkeyup="importProceeds(this.value)"></p> 
                                        <p class="mb-0 mt-1">Tiền trả lại <span class="float-right"><span class="h5 text-primary font-weight-bold" id="amountReturnBill">0</span> VNĐ</span></p>
                                    </div>
                                @endrole

                                @role('customer')
                                    <form method="POST" action="" class="pb-2 pl-3 pr-3">
                                        <p class="mb-0">Tổng tiền <span class="font-weight-bold">1</span> hóa đơn <span class="float-right h5 text-danger font-weight-bold">80 VNĐ</span></p>
                                        <p class="mb-0 mt-2">Số tiền thu </span> hóa đơn <span class="float-right h5 text-danger font-weight-bold">80 VNĐ</span></p> 
                                        <p class="mb-0 mt-2">Tiền trả lại <span class="float-right"><span class="h5 text-primary font-weight-bold">0</span> VNĐ</span></p>
                                    </form>
                                @endrole
                            </div>
                            @role('admin')
                                <div class="col-6 border-left">
                                    <p class="mb-1">Tên KH: <span class="font-weight-bold" id="nameCustomer"></span></p>
                                    <p class="mb-1">Địa chỉ: <span class="font-weight-bold" id="addressCustomer"></span></p>
                                    <p class="mb-1">Số điện thoại: <span class="font-weight-bold" id="phoneCustomer"></span></p>
                                    <p class="mb-1">Nợ cước: <span class="font-weight-bold" id="debitCustomer"></span></p>
                                </div>
                            @endrole
                            @role('staff')
                                <div class="col-6 border-left">
                                    <p class="mb-1">Tên KH: <span class="font-weight-bold" id="nameCustomer"></span></p>
                                    <p class="mb-1">Địa chỉ: <span class="font-weight-bold" id="addressCustomer"></span></p>
                                    <p class="mb-1">Số điện thoại: <span class="font-weight-bold" id="phoneCustomer"></span></p>
                                    <p class="mb-1">Nợ cước: <span class="font-weight-bold" id="debitCustomer"></span></p>
                                </div>
                            @endrole

                            @role('customer')
                                <div class="col-6 border-left">
                                    <p class="mb-1">Tên KH: <span class="font-weight-bold" id="nameCustomer">{{ $user->name }}({{ $user->code }})</span></p>
                                    <p class="mb-1">Địa chỉ: <span class="font-weight-bold" id="addressCustomer">{{ $user->address }}</span></p>
                                    <p class="mb-1">Số điện thoại: <span class="font-weight-bold" id="phoneCustomer">{{ $user->phone }}</span></p>
                                </div>
                            @endrole
                        </div>
                    </div>
                </div>

                <div class="col mt-5">
                    @if(session('notification'))
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('notification') }}
                        </div>
                    @endif

                    <table class="table table-bordered bg-white">
                        <tr>
                            <th scope="col"><input type="radio" id="radio"></th>
                            <th scope="col">STT</th>
                            <th scope="col">MÃ HÓA ĐƠN</th>
                            <th scope="col">KHÁCH HÀNG</th>
                            <th scope="col">KỲ THU</th>
                            <th scope="col">SỐ ĐIỆN TIÊU THỤ</th>
                            <th scope="col">SỐ TIỀN NỢ CƯỚC</th>
                            <th scope="col">SỐ ĐIỆN THOẠI</th>
                            <th scope="col">TRẠNG THÁI</th>
                        </tr>
                        @php ($stt = 1)
                        @foreach ($bills as $bill)
                            <tr>
                                <th scope="row"><input type="radio" name="radio[]" value="{{ $bill }}" onclick="getInfo(this.value)"></th>
                                <td>{{ $stt++ }}</td>
                                <td>{{ $bill->code }}</td>
                                <td>
                                    <p class="mb-0 font-weight-bold">{{ $bill->user->name }}</p>
                                    <p class="mb-0 text-primary">{{ $bill->user->code }}</p>
                                    <p class="mb-0">{{ $bill->user->address }}</p>
                                </td>
                                <td>{{ date_format(new DateTime($bill->period), "m/Y") }}</td>
                                <td class="font-weight-bold">{{ $bill->power_number }}</td>
                                <td class="text-right h4 text-primary font-weight-bold">{{ $bill->debit }}</td>
                                <td class="font-weight-bold">{{ $bill->user->phone }}</td>
                                <td class="text-center">
                                    <label class="bg-{{ $bill->status ? 'success' : 'warning'}} text-white p-2 rounded">{{ $bill->status ? 'Đã thu' : 'Chưa thu'}}</label>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $bills->appends([
                        'search' => $search,
                        'key' => $key,
                    ])->links() }}
                </div>
            </div>
        </div>

        @if ($notification)
            <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ $notification }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#notificationModal').modal('show');
                });
            </script>
        @endif

        <div class="modal fade" id="notificationSelectBillModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="notificationSelectBill">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

        <script type="text/javascript">
            function selectBill() {
                if ($(`input[name='radio[]']`).is(":checked")) {
                    // alert('check roi ne');
                    $(`#buttonPrint`).attr('type', 'submit')
                }
                else {
                    $(`#buttonPrint`).attr('type', 'button');
                    $(`#notificationSelectBill`).text('Hãy chọn hóa đơn thanh toán');
                    $('#notificationSelectBillModal').modal('show');
                }
            }

            function getInfo(val) {
                let bill = JSON.parse(val);

                $(`#nameCustomer`).text(bill.user.name);
                $(`#addressCustomer`).text(bill.user.address);
                $(`#phoneCustomer`).text(bill.user.phone);
                $(`#debitCustomer`).text(bill.debit + ' VNĐ');
                $(`#totalBill`).text(bill.price);
                $(`input[name='id']`).val(bill.id);

                if ($(`input[name='radio[]']`).is(":checked")) {
                    $(`#radio`).attr('checked', 'checked');
                }

                let proceeds = $(`#proceeds`).val();
                let totalBill = $(`#totalBill`).text();
                if (parseInt(proceeds) > parseInt(totalBill)) {
                    $(`#amountReturnBill`).text(parseInt(proceeds) - parseInt(totalBill));
                }
                else {
                    $(`#amountReturnBill`).text(0);
                }
            }

            function importProceeds(proceeds) {
                let totalBill = $(`#totalBill`).text();

                $(`input[name='proceeds']`).val(proceeds);

                if (parseInt(proceeds) > parseInt(totalBill)) {
                    $(`#amountReturnBill`).text(parseInt(proceeds) - parseInt(totalBill));
                }
                else {
                    $(`#amountReturnBill`).text(0);
                }
            }
        </script>
    </body>
</html>