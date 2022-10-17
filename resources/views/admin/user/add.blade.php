@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>
            @if (request()->session()->has('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ url('admin/user/store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" value="{{ request()->input('name') }}"
                            id="name">
                        @error('name')
                            <small class="text-danger"> {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email">
                        @error('email')
                            <small class="text-danger"> {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger"> {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirm">
                        @error('password_confirmation')
                            <small class="text-danger"> {{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
