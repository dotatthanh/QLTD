@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">DOANH THU</h1>
		
		<form class="row mt-5">
			<div class="col-2">
				<input type="text" placeholder="Tên khách hàng" name="name" class="form-control w-100">
			</div>
			<div class="col-1 text-right">
				<label>Từ</label>
			</div>
			<div class="col-2">
				<input type="month" name="fromMonth" class="form-control w-100">
			</div>
			<div class="col-1 text-right">
				<label>Đến</label>
			</div>
			<div class="col-2">
				<input type="month" name="toMonth" class="form-control w-100">
			</div>
			<div class="col-2">
				<button class="btn btn-success w-100" type="submit">Tìm kiếm</button>
			</div>
			<div class="col-2 form-group">
				<a target="_blank" href="{{ route('export-revenue', ['name' => $name, 'fromMonth' => $fromMonth, 'toMonth' => $toMonth, ]) }}" class="text-white btn btn-success w-100">Xuất excel</a>
			</div>
		</form>
		<table class="table table-bordered table-striped mt-3">
			<tr class="text-center">
				<th>STT</th>
				<th width="119px">Mã khách hàng</th>
				<th>Tên khách hàng</th>
				<th>Email</th>
				<th>Số điện thoại</th>
				<th>Địa chỉ</th>
				<th>Số điện</th>
				<th>Số nợ</th>
				<th>Doanh thu</th>
			</tr>
			@php ($stt = 1)
			@foreach ($customers as $customer)
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>{{ $customer->code }}</td>
					<td>{{ $customer->name }}</td>
					<td>{{ $customer->email }}</td>
					<td>{{ $customer->phone }}</td>
					<td>{{ $customer->address }}</td>
					<td>{{ $customer->power_number }}</td>
					<td>{{ $customer->debit }}</td>
					<td>{{ $customer->revenue }}</td>
				</tr>
			@endforeach
		</table>
		{{ $customers->appends([
			'name' => $name,
			'fromMonth' => $fromMonth,
			'toMonth' => $toMonth,
		])->links() }}
	</div>
@endsection