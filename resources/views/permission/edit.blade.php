@extends('layouts.default')
@section('content')
	<div class="container mb-5">
		<h1 class="title-admin mt-5">QUẢN LÝ QUYỀN 
			@if ($role->name == 'admin')
				{{ 'ADMIN' }}
			@elseif ($role->name == 'staff')
				{{ 'NHÂN VIÊN' }}
			@elseif ($role->name == 'customer')
				{{ 'KHÁCH HÀNG' }}
			@endif
		</h1>

		@if(session('notificationEditPermission'))
			<div class="alert alert-success text-center mt-3" role="alert">
                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('notificationEditPermission') }}
            </div>
		@endif

		<a href="{{ route('role') }}" type="submit" class="btn btn-success text-white mt-3">Quản lý quyền</a>
		<form action="{{ route('update-permission', $role->id) }}" method="POST" class="row mt-5">
			@csrf
			<div class="col-4">
				<h4>Quản lý khách hàng</h3>
				@foreach ($permissions as $permission)
					@if (strpos($permission->name, 'customer'))
						<div class="form-check">
						    <input type="checkbox" name="permissions[{{ $permission->id }}]" class="form-check-input" id="permission{{ $permission->id }}"
						    	@foreach ($role->permissions as $is_permission)
						    		@if ($permission->id == $is_permission->id)
						    			{{ 'checked' }}
						    		@endif
						    	@endforeach
						    >
						    <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
						</div>
					@endif
				@endforeach
			</div>

			<div class="col-4">
				<h4>Quản lý hóa đơn</h3>
				@foreach ($permissions as $permission)
					@if (strpos($permission->name, 'bill'))
						<div class="form-check">
						    <input type="checkbox" name="permissions[{{ $permission->id }}]" class="form-check-input" id="permission{{ $permission->id }}"
						    	@foreach ($role->permissions as $is_permission)
						    		@if ($permission->id == $is_permission->id)
						    			{{ 'checked' }}
						    		@endif
						    	@endforeach
						    >
						    <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
						</div>
					@endif
				@endforeach
			</div>
			<div class="col-12 mt-4">
				<button type="submit" class="btn btn-success">Lưu lại</button>
			</div>
		</form>
	</div>
@endsection