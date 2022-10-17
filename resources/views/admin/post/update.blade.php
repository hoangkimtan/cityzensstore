@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật bài viết
            </div>
            <div class="card-body">
                <form action="{{ Route('admin.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="post_title" value="{{ $post->post_title }}"
                            id="name">
                        @error('post_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input class="form-control" type="text" name="slug" value="{{ $post->slug }}"
                            placeholder="Không bắt buộc" id="slug">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea class="form-control editor" name="content" id="content" cols="30" rows="5">{{ $post->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select class="form-control" name="post_cat_id" id="">
                            <option value="">Chọn danh mục</option>
                            @foreach ($list_post_cat as $item)
                                <option {{ $post->post_cat_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ str_repeat('|---', $item->level) . $item->post_cat_title }}</option>
                            @endforeach
                        </select>
                        @error('post_cat_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="post-thumb">Ảnh bài viết</label><br>
                                <input type="file" name="post_thumb" id="post-thumb"> <br>
                                @error('post_thumb')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-8">
                                <strong>Ảnh cũ</strong>
                                <div class="old-img" style="width:150px">
                                    <img src="{{ Asset($post->post_thumb) }}" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                {{ $post->status == 'publish' ? 'checked' : '' }} value="publish">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status"
                                {{ $post->status == 'pending' ? 'checked' : '' }} id="exampleRadios1" value="pending">
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
