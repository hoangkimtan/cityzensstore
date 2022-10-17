@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật trang
            </div>
            <div class="card-body">
                <form action="{{ Route('admin.page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="page_title" value="{{ $page->page_title }}"
                            id="name">
                        @error('page_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea class="form-control editor" name="content" id="content" cols="30" rows="5">{{ $page->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Danh mục</strong></label>
                        <select class="form-control" name="page_cat" id="">
                            <option value=''>Chọn danh mục</option>
                            <option {{ $page->page_cat == 'header' ? 'selected' : '' }} value='header'>Header</option>
                            <option {{ $page->page_cat == 'footer' ? 'selected' : '' }} value='footer'>Footer</option>
                        </select>
                        @error('page_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status"
                                {{ $page->status == 'publish' ? 'checked' : '' }} id="exampleRadios2" value="publish">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status"
                                {{ $page->status == 'pending' ? 'checked' : '' }} id="exampleRadios1" value="pending">
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <button type="submit" value="Cập nhật" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
