@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="" class="form-control form-search" name="key"
                            value="{{ request()->input('key') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ Route('admin.post.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ str_replace(request()->page, '', request()->fullUrlWithQuery(['status' => 'publish'])) }}"
                        class="text-primary">Đang xuất
                        bản<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ str_replace(request()->page, '', request()->fullUrlWithQuery(['status' => 'pending'])) }}"
                        class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ str_replace(request()->page, '', request()->fullUrlWithQuery(['status' => 'trash'])) }}"
                        class="text-primary">Thùng
                        rác<span class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/post/action') }}" method="">

                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="action" id="">
                            <option value="">Chọn</option>
                            @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @if ($list_post->count() > 0)
                                @foreach ($list_post as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td style="width:130px"><img src="{{ Asset($item->post_thumb) }}" alt=""
                                                class="img-fluid img-thumbnail"></td>
                                        <td><a href="">{{ $item->post_title }}</a></td>
                                        <td>{{ $item->post_cat->post_cat_title }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ Route('admin.post.edit', $item->id) }}"
                                                class="btn btn-success btn-sm rounded-0" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Request::get('status') === 'trash')
                                                <a href="{{ Route('admin.post.delete', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ Route('admin.post.destroy', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
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
                </form>

                <nav aria-label="Page navigation example">
                    {{ $list_post->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
