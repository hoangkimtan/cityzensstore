@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật Slider
            </div>
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ Route('admin.slider.update', $slider->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề slider</label>
                        <input class="form-control" type="text" name="slider_title" value="{{ $slider->slider_title }}"
                            id="name">
                        @error('slider_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Thứ tự</label>
                        <input class="form-control" type="number" min="0" name="num_order"
                            value="{{ $slider->num_order }}" id="name">
                        @error('num_order')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="product-thumb"><strong>Ảnh slider</strong></label><br>
                                <input type="file" name="slider_thumb" id="product-thumb"> <br>
                                @error('slider_thumb')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-8">
                                <strong>Ảnh cũ</strong>
                                <div class="old-img" style="width:150px">
                                    <img src="{{ Asset($slider->slider_thumb) }}" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                value="pending" {{ $slider->status == 'pending' ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="publish" {{ $slider->status == 'publish' ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
