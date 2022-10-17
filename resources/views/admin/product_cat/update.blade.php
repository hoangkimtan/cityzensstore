@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhật danh mục sản phẩm
                    </div>
                    @if (session('alert'))
                        <div class="alert alert-success">
                            {{ session('alert') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.product_cat.update', $cat->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="product_cat_title"
                                    value="{{ $cat->product_cat_title }}" id="name">
                                @error('product_cat_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Slug</label>
                                <input class="form-control" type="text" name="slug" value="{{ $cat->slug }}"
                                    id="name">
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select class="form-control" name="parent_id" id="">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($list_cat as $item)
                                        <option {{ $cat->parent_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">
                                            {{ str_repeat('|---', $item['level']) . $item->product_cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" value="Cập nhật" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($list_cat))
                                    @foreach ($list_cat as $item)
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>
                                                @if ($item->parent_id == 0)
                                                    <strong>{{ str_repeat('|---', $item->level) . $item->product_cat_title }}</strong>
                                                @else
                                                    {{ str_repeat('|---', $item->level) . $item->product_cat_title }}
                                                @endif
                                            </td>
                                            <td>{{ $item->slug }}</td>
                                            <td>
                                                <a href="{{ Route('admin.product_cat.edit', $item->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ Route('admin.product_cat.destroy', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Xóa danh mục sẽ xóa tất cả các sản phẩm của danh mục đó, bạn có chắc muốn xóa')"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center bg-white">Hiện không có bài viết nào</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
