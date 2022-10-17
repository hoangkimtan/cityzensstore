@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    @if (session('alert'))
                        <div class="alert alert-success">
                            {{ session('alert') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ Route('admin.post_cat.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="post_cat_title" id="name">
                                @error('post_cat_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug">
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select class="form-control" name="parent_id" id="">
                                    <option value="">Chọn danh mục</option>
                                    @if (!empty($list_post_cat))
                                        @foreach ($list_post_cat as $item)
                                            <option value="{{ $item->id }}">
                                                {{ str_repeat('|---', $item->level) . $item->post_cat_title }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Hiện không có danh mục nào</option>
                                    @endif
                                </select>
                            </div>
                            <button type="submit" name="btn_add" value="Thêm mới" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
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
                                @php
                                    $t = 0;
                                @endphp
                                @if (!empty($list_post_cat))
                                    @foreach ($list_post_cat as $item)
                                        @php
                                            $t++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $t }}</th>
                                            <td>
                                                @if ($item->parent_id == 0)
                                                    <strong>{{ str_repeat('|---', $item->level) . $item->post_cat_title }}</strong>
                                                @else
                                                    {{ str_repeat('|---', $item->level) . $item->post_cat_title }}
                                                @endif
                                            </td>
                                            <td>{{ $item->slug }}</td>
                                            <td>
                                                <a href="{{ Route('admin.post_cat.edit', $item->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ Route('admin.post_cat.destroy', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Xóa danh mục sẽ xóa tất cả các bài viết của danh mục đó, bạn có chắc muốn xóa')"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center bg-white">Không có danh mục nào</td>
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
