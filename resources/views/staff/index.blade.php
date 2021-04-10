@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">QUẢN LÝ NHÂN VIÊN</h1>
			
		{{-- <div class="row mt-5">
			<div class="col-4">
				<input type="text" placeholder="Tên khách hàng" class="form-control w-100">
			</div>
			<div class="col-2">
				<button class="btn btn-success w-100">Tìm kiếm</button>
			</div>
			<div class="col-2">
				<form action="" method="">
					@csrf
					<button class="btn btn-success w-100">Xuất excel</button>
				</form>
			</div>
		</div> --}}

		@if(session('notificationActive'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationActive') }}
            </div>
		@endif

		@if(session('notificationDelete'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationDelete') }}
            </div>
		@endif

		<table class="table table-bordered table-striped mt-3">
			<tr class="text-center">
				<th>STT</th>
				<th>Mã nhân viên</th>
				<th>Họ và tên</th>
				<th>Email</th>
				<th>Số điện thoại</th>
				<th>Địa chỉ</th>
				<th>Trạng thái</th>
				<th>Thao tác</th>
			</tr>
			@php ($stt = 1)
			@foreach ($users as $user)
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>{{ $user->code }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->phone }}</td>
					<td>{{ $user->address }}</td>
					<td>
						@if ($user->status == 1)
							{{ 'Đã kích hoạt' }}
						@elseif ($user->status == 0)
							{{ 'Chưa kích hoạt' }}
						@elseif ($user->status == -1)
							{{ 'Đã xóa' }}
						@endif
					</td>
					<td class="text-center">
						@if ($user->status < 1)
							<form action="{{ route('active', $user->id) }}" method="POST" class="d-inline-block">
								@csrf
								<button type="submit" class="btn btn-success text-white">Kích hoạt</button>
							</form>
						@endif

						@if ($user->status > -1)
							<form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline-block">
								@csrf
								<button type="submit" class="btn btn-danger text-white">Xóa</button>
							</form>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		{{ $users->links() }}
	</div>
@endsection