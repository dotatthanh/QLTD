@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">DANH SÁCH HÓA ĐƠN</h1>
		
		@if(session('notificationDelete'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationDelete') }}
            </div>
		@endif

		@if(session('notificationUpdate'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationUpdate') }}
            </div>
		@endif

		@if(session('notificationUpdateFail'))
			<div class="alert alert-danger text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationUpdateFail') }}
            </div>
		@endif

		<div class="row mt-5">
			<form method="GET" action="{{ route('bills.index') }}" class="d-inline-block w-100 col-6">
				<div class="row">
					<div class="col-8">
						<input type="text" name="search" placeholder="Mã hóa đơn" class="form-control w-100">
					</div>
					<div class="col-4">
						<button class="btn btn-success w-100" type="submit">Tìm kiếm</button>
					</div>
				</div>
			</form>

			<div class="col-2">
				<a target="_blank" href="{{ route('export-bill', ['search' => $search]) }}" class="text-white btn btn-success w-100">Xuất excel</a>
			</div>
		</div>

		<table class="table table-bordered table-striped mt-3">
			<tr class="text-center">
				<th>STT</th>
				<th>Mã HĐ</th>
				<th>Mã KH</th>
				<th>Tên khách hàng</th>
				<th>Số điện</th>
				<th>Số tiền</th>
				<th>Số tiền thu</th>
				<th>Số tiền trả lại</th>
				<th>Số tiền nợ cước</th>
				<th>Kỳ thu</th>
				<th>Trạng thái</th>
				<th>Thao tác</th>
			</tr>
			@php ($stt = 1)
			@foreach ($bills as $bill)
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>{{ $bill->code }}</td>
					<td>{{ $bill->user->code }}</td>
					<td>{{ $bill->user->name }}</td>
					<td class="text-right">{{ $bill->power_number }}</td>
					<td class="text-right">{{ $bill->price }}</td>
					<td class="text-right">{{ $bill->proceeds }}</td>
					<td class="text-right">{{ $bill->amount_return }}</td>
					<td class="text-right">{{ $bill->debit }}</td>
					<td>{{ date_format(new DateTime($bill->period), "m/Y") }}</td>
					<td class="text-center">
						{!! $bill->status == 0 ? '<label class="bg-warning text-white p-2 rounded">Chưa thu</label>' : '<label class="bg-success text-white p-2 rounded">Đã thu</label>' !!}
					</td>
					<td class="text-center">
						<a href="{{ route('bills.edit', $bill->id) }}" class="w-60px btn btn-warning text-white">Sửa</a>
						<form class="d-inline-block" method="POST" action="{{ route('bills.destroy', $bill->id) }}">
							@csrf
							@method('DELETE')
							<button class="w-60px btn btn-danger" type="submit">Xóa</button>
						</form>
					</td>
				</tr>
			@endforeach
		</table>
		{{ $bills->appends(['search' => $search])->links() }}
	</div>
@endsection