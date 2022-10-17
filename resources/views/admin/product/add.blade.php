@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ Route('admin.product.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"><strong>Tên sản phẩm</strong></label>
                                <input class="form-control" type="text" name="product_title"
                                    value="{{ old('product_title') }}" id="name">
                                @error('product_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code"><strong>Mã sản phẩm (không bắt buộc)</strong></label>
                                <input class="form-control" type="text" name="code" value="{{ old('code') }}"
                                    id="code">
                            </div>
                            <div class="form-group">
                                <label for="price"><strong>Giá</strong></label>
                                <input class="form-control" type="number" name="price" value="{{ old('price') }}"
                                    id="price">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qty"><strong>Số lượng</strong></label>
                                <input class="form-control" type="number" min="0" name="qty"
                                    value="{{ old('qty') }}" id="qty">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="intro"><strong>Mô tả sản phẩm</strong></label>
                                <textarea name="product_desc" class="form-control editor" id="intro" cols="30" rows="5">{{ old('product_desc') }}</textarea>
                                @error('product_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="intro"><strong>Chi tiết sản phẩm</strong></label>
                        <textarea name="product_detail" class="form-control editor" id="intro" cols="30" rows="5">{{ old('product_detail') }}</textarea>
                        @error('product_detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Danh mục</strong></label>
                        <select class="form-control" name="product_cat_id" id="">
                            <option value=''>Chọn danh mục</option>
                            @foreach ($list_product_cat as $item)
                                <option {{ old('product_cat_id') == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">
                                    {{ str_repeat('|---', $item->level) . $item->product_cat_title }}</option>
                            @endforeach
                        </select>
                        @error('product_cat_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product-thumb"><strong>Ảnh sản phẩm</strong></label><br>
                        <input type="file" name="product_thumb" id="product-thumb"> <br>
                        @error('product_thumb')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product-thumb"><strong>Ảnh liên quan sản phẩm</strong></label><br>
                        <input type="file" name="product_thumb_relative[]" id="product-thumb" multiple> <br>
                        @error('product_thumb_relative')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Nổi bật</strong></label>
                        <input type="checkbox" name="feature" value="1" id="">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Trạng thái</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                value="publish" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="pending">
                            <label class="form-check-label" for="exampleRadios2">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="btn_add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
