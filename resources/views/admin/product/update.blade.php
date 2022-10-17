@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ Route('admin.product.update', $product->id) }}" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"><strong>Tên sản phẩm</strong></label>
                                <input class="form-control" type="text" name="product_title"
                                    value="{{ $product->product_title }}" id="name">
                                @error('product_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code"><strong>Mã sản phẩm</strong></label>
                                <input class="form-control" type="text" readonly name="code"
                                    value="{{ $product->code }}" id="code">
                            </div>
                            <div class="form-group">
                                <label for="price"><strong>Giá</strong></label>
                                <input class="form-control" type="text" name="price" value="{{ $product->price }}"
                                    id="price">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qty"><strong>Số lượng</strong></label>
                                <input class="form-control" type="number" name="qty" value="{{ $product->qty }}"
                                    id="qty">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="intro"><strong>Mô tả sản phẩm</strong></label>
                                <textarea name="product_desc" class="form-control editor" id="intro" cols="30"
                                    rows="5">{{ $product->product_desc }}</textarea>
                                @error('product_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="intro"><strong>Chi tiết sản phẩm</strong></label>
                        <textarea name="product_detail" class="form-control editor" id="intro" cols="30"
                            rows="5">{{ $product->product_detail }}</textarea>
                        @error('product_detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Danh mục</strong></label>
                        <select class="form-control" name="product_cat_id" id="">
                            <option>Chọn danh mục</option>
                            @foreach ($list_product_cat as $item)
                                <option {{ $product->product_cat_id == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">
                                    {{ str_repeat('|---', $item->level) . $item->product_cat_title }}</option>
                            @endforeach
                        </select>
                        @error('product_cat_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="product-thumb"><strong>Ảnh sản phẩm</strong></label><br>
                                <input type="file" name="product_thumb" id="product-thumb"> <br>
                                <input type="hidden" name="product_thumb_old" value="{{ $product->product_thumb }}"
                                    id="product-thumb"> <br>
                                @error('product_thumb')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-8">
                                <strong>Ảnh cũ</strong>
                                <div class="old-img" style="width:150px">
                                    <img src="{{ Asset($product->product_thumb) }}" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="product-thumb"><strong>Ảnh liên quan sản phẩm</strong></label><br>
                                <input type="file" name="product_thumb_relative[]" id="product-thumb" multiple> <br>
                            </div>
                            <div class="col-8">
                                <strong>Danh sách ảnh liên quan sản phẩm cũ</strong>
                                @if ($list_img)
                                    <div class="row">
                                        @foreach ($list_img as $item)
                                            <div class="col-3">
                                                <div class="old-img" style="width:150px">
                                                    <img src="{{ asset($item->img_relative_thumb) }}" alt=""
                                                        class="img-fluid img-thumbnail">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('product_thumb_relative')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Nổi bật</strong></label>
                        <input type="checkbox" name="feature" {{ $product->feature == 1 ? 'checked' : '' }} value="1"
                            id="">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Trạng thái</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="publish"
                                {{ $product->status == 'publish' ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                {{ $product->status == 'pending' ? 'checked' : '' }} value="pending">
                            <label class="form-check-label" for="exampleRadios2">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                        <button type="submit" name="btn_update" value="Cập nhật" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
