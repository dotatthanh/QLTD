@extends('layouts.default')
@section('content')
	<div class="container mb-5">
		<h1 class="title-admin mt-5">QUẢN LÝ VAI TRÒ</h1>
		
		<table class="table table-bordered table-striped mt-3">
			<tr class="text-center">
				<th>STT</th>
				<th>Tên khách hàng</th>
				<th>Thao tác</th>
			</tr>
			@php ($stt = 1)
			@foreach ($roles as $role)
				<tr>
					<td class="text-center">{{ $stt++ }}</td>
					<td>{{ $role->name }}</td>
					<td class="text-center">
						<a href="{{ route('edit-permission', $role->id) }}" class="btn btn-success text-white">Chỉnh sửa</a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection