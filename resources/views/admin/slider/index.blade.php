@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách slider</h5>
                <div class="form-search form-inline">
                    {{-- <form action="#">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form> --}}
                </div>
            </div>
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ Route('admin.slider.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'publish']) }}" class="text-primary">Xuất
                        bản<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                </div>
                <form action="{{ url('admin/slider/action') }}">

                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $item)
                                <option value="{{ $k }}">{{ $item }}</option>
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
                                <th scope="col">STT</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($list_slider->count())
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($list_slider as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td style="width:150px"><img src="{{ Asset($item->slider_thumb) }}" alt=""
                                                class="img-fluid"></td>
                                        <td><a href="">{{ $item->slider_title }}</a>
                                        </td>
                                        <td>{{ $item->num_order }}</td>
                                        <td>
                                            <a href="{{ Route('admin.slider.edit', $item->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ Route('admin.slider.destroy', $item->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center bg-white">Không slider nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                <nav aria-label="Page navigation example">
                    {{ $list_slider->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
