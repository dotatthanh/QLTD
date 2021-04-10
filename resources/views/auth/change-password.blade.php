@extends('layouts.default')
@section('content')
	<div class="container">
		<h1 class="title-admin mt-5">ĐỔI MẬT KHẨU</h1>
		
		<div class="row justify-content-center">
			<div class="col-7">
				<form action="" method="POST" class="mt-3">
					@csrf
					<div class="form-group row">
					    <label for="password" class="col-sm-3 col-form-label">Mật khẩu hiện tại</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="password" placeholder="Mật khẩu hiện tại">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="passwordNew" class="col-sm-3 col-form-label">Mật khẩu mới</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="passwordNew" placeholder="Mật khẩu mới">
					    </div>
					</div>
					<div class="form-group row">
					    <label for="passwordConfirm" class="col-sm-3 col-form-label">Nhập lại mật khẩu</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="passwordConfirm" placeholder="Nhập lại mật khẩu">
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