@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">DANH SÁCH KHÁCH HÀNG</h1>
		
		@if(session('notificationImportSuccess'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationImportSuccess') }}
            </div>
		@endif

		@if(session('notificationAdd'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationAdd') }}
            </div>
		@endif

		@if(session('notificationUpdate'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationUpdate') }}
            </div>
		@endif

		@if(session('notificationDelete'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationDelete') }}
            </div>
		@endif
		
		@if(session('notificationImportFail'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationImportFail') }}
            </div>
		@endif

		<div class="row mt-5">
			<form method="GET" action="{{ route('customers.index') }}" class="d-inline-block w-100 col-6">
				<div class="row">
					<div class="col-8">
						<input type="text" name="search" placeholder="Mã khách hàng, Tên khách hàng, Số điện thoại" class="form-control w-100">
					</div>
					<div class="col-4">
						<button class="btn btn-success w-100" type="submit">Tìm kiếm</button>
					</div>
				</div>
			</form>

			<div class="col-2">
				<a href="{{ route('customers.create') }}" class="btn btn-success text-white w-100">Thêm khách hàng</a>
			</div>

			<div class="col-2">
				<a target="_blank" href="{{ route('export-customer', ['search' => $search]) }}" class="text-white btn btn-success w-100">Xuất excel</a>
			</div>
		</div>


		<table class="table table-bordered table-striped mt-3">
			<tr class="text-center">
				<th>STT</th>
				<th width="119px">Mã khách hàng</th>
				<th>Tên khách hàng</th>
				<th width="105px">Số điện thoại</th>
				<th>Địa chỉ</th>
				<th width="258px">Thao tác</th>
			</tr>
			@php ($stt = 1)
			@foreach ($customers as $customer)
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>{{ $customer->code }}</td>
					<td>{{ $customer->name }}</td>
					<td>{{ $customer->phone }}</td>
					<td>{{ $customer->address }}</td>
					<td class="text-center">
						<a href="{{ route('import', $customer->id) }}" class="btn btn-success text-white">Nhập số điện</a>
						<a href="{{ route('customers.edit', $customer->id) }}" class="w-60px btn btn-warning text-white">Sửa</a>
						<form class="d-inline-block" method="POST" action="{{ route('delete-customer', $customer->id) }}">
							@csrf
							<button class="w-60px btn btn-danger" type="submit">Xóa</button>
						</form>
					</td>
				</tr>
			@endforeach
		</table>
		{{ $customers->appends(['search' => $search])->links() }}
	</div>
@endsection