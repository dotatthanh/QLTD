@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">DANH SÁCH KHÁCH HÀNG</h1>

		@if(isset($errors) && $errors->any())
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
				@foreach($errors->all() as $error)
					{{ $error }}
				@endforeach
            </div>
		@endif

		@if (session()->has('failures'))
			<table class="table table-danger">
				<tr>
					<th colspan="2" class="text-center font-weight-bold">Có một số lỗi xảy ra</th>
				</tr>
				<tr>
					<td class="font-weight-bold">Hàng</td>
					<td class="font-weight-bold">Lỗi</td>
				</tr>
				@foreach(session()->get('failures') as $validation)
					<tr>
						<td>{{ $validation->row() }}</td>
						<td>
							<ul>
								@foreach($validation->errors() as $e)
									<li>{{ $e }}</li>
								@endforeach
							</ul>
						</td>
					</tr>
				@endforeach
			</table>
		@endif

		@if(session('notificationImportSuccess'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationImportSuccess') }}
            </div>
		@endif

		@if(session('notificationImport'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationImport') }}
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

			@can('add customer')
			<div class="col-2">
					<a href="{{ route('customers.create') }}" class="btn btn-success text-white w-100">Thêm khách hàng</a>
			</div>
			@endcan

			<div class="col-2">
				<a target="_blank" href="{{ route('export-customer', ['search' => $search]) }}" class="text-white btn btn-success w-100">Xuất excel</a>
			</div>
		</div>

		<form class="row mt-3" action="{{ route('import-customer') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="col-3">
				<div class="form-group">
					<input required type="file" class="form-control-file" name="file">
				</div>
			</div>
			<div class="col-3">
				<button class="btn btn-success w-100" type="submit">Nhập excel khách hàng</button>
			</div>
			<div class="col-2">
				<a target="_blank" href="{{ route('export-form-import-customer') }}" class="text-white btn btn-success w-100">Lấy file nhập mẫu</a>
			</div>
		</form>

		<form class="row mt-3" action="{{ route('import-power-number-customer') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="col-3">
				<div class="form-group">
					<input required type="file" class="form-control-file" name="file">
				</div>
			</div>
			<div class="col-3">
				<button class="btn btn-success w-100" type="submit">Nhập excel số điện khách hàng</button>
			</div>
			<div class="col-2">
				<a target="_blank" href="{{ route('export-form-import-power-number-customer') }}" class="text-white btn btn-success w-100">Lấy file nhập mẫu</a>
			</div>
		</form>


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
						@can('edit customer')
							<a href="{{ route('customers.edit', $customer->id) }}" class="w-60px btn btn-warning text-white">Sửa</a>
						@endcan
						@can('delete customer')
							<form class="d-inline-block" method="POST" action="{{ route('delete-customer', $customer->id) }}">
								@csrf
								<button class="w-60px btn btn-danger" type="submit">Xóa</button>
							</form>
						@endcan
					</td>
				</tr>
			@endforeach
		</table>
		{{ $customers->appends(['search' => $search])->links() }}
	</div>
@endsection