@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">ĐỔI MẬT KHẨU</h1>
		
		<div class="row justify-content-center">
			<div class="col-7">
				@if ($errors->any())
		            @foreach ($errors->all() as $error)
		                <span class="text-danger d-block mt-2">{{ $error }}</span>
		            @endforeach
				@endif
				@if(session('notificationSuccess'))
					<div class="alert alert-success text-center mt-3" role="alert">
		                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
		                {{ session('notificationSuccess') }}
		            </div>
				@endif
				@if(session('notificationFail'))
					<div class="alert alert-danger text-center mt-3" role="alert">
		                <button type="button" class="close d-block" data-dismiss="alert" aria-hidden="true">&times;</button>
		                {{ session('notificationFail') }}
		            </div>
				@endif
				<form action="{{ route('change-password-store') }}" method="POST" class="mt-3">
					@csrf
					<div class="form-group row">
					    <label for="password" class="col-sm-3 col-form-label">Mật khẩu cũ</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" name="password_old" id="password" placeholder="Mật khẩu cũ">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="passwordNew" class="col-sm-3 col-form-label">Mật khẩu mới</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" name="password" id="passwordNew" placeholder="Mật khẩu mới">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="passwordConfirm" class="col-sm-3 col-form-label">Nhập lại mật khẩu</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" name="password_confirmation" id="passwordConfirm" placeholder="Nhập lại mật khẩu">
					    </div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success">Đổi mật khẩu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection