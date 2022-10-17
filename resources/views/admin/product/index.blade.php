@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="{{ Route('admin.product.index') }}">
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
                    <a href="{{ Route('admin.product.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'publish'])) }}"
                        class="text-primary">Đang hoạt
                        động<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'pending'])) }}"
                        class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'trash'])) }}"
                        class="text-primary">Thùng
                        rác<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'out-of-stock'])) }}"
                        class="text-primary">Hết hàng<span class="text-muted">({{ $count[4] }})</span></a>
                </div>
                <form action="{{ url('admin/product/action') }}" method="">

                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option value="">Chọn</option>
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
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col" style="width:300px">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @if ($list_product->count() > 0)
                                @foreach ($list_product as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $t }}</td>
                                        <td style="width:130px"><img src="{{ Asset($item->product_thumb) }}"
                                                class="img-fluid" alt=""></td>
                                        <td><a
                                                href="{{ Route('admin.product.edit', $item->id) }}">{{ $item->product_title }}</a>
                                        </td>
                                        <td>{{ currency_format($item->price, '.đ') }}</td>
                                        <td>{{ $item->productCat->product_cat_title }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <?php $tracking = $item->qty == 0 ? 'out-of-stock' : $item->tracking; ?>
                                            <span
                                                class="badge badge-{{ get_tracking_css($tracking) }}">{{ get_tracking($tracking) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ Route('admin.product.edit', $item->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Request::get('status') === 'trash')
                                                <a href="{{ Route('admin.product.delete', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ Route('admin.product.destroy', $item->id) }}"
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
                                    <td colspan="9" class="text-center bg-white">Không có sản phẩm nào</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                <nav aria-label="Page navigation example">
                    {{ $list_product->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
