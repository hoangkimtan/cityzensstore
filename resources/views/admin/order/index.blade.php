@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search ">
                    <form action="#" class="chart form-inline">

                        <input type="" class="form-control form-search" name="key"
                            value="{{ request()->input('key') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <div id="myfirstchart" style="display: none"></div>
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
                    <a href="{{ Route('admin.order.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'success'])) }}"
                        class="text-primary">Thành công<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'pending'])) }}"
                        class="text-primary">Đang chờ duyệt<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'shipping'])) }}"
                        class="text-primary">Đang vận chuyển<span class="text-muted">({{ $count[5] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'cancel'])) }}"
                        class="text-primary">Hủy<span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="{{ str_replace(request()->page, 1, request()->fullUrlWithQuery(['status' => 'trash'])) }}"
                        class="text-primary">Thùng rác<span class="text-muted">({{ $count[4] }})</span></a>
                </div>
                <form action="{{ Route('admin.order.action') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="action" id="">
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
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Mã/SĐT</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thanh toán</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Chi tiết</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @if ($list_order->count() > 0)
                                @foreach ($list_order as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $t }}</td>
                                        <td>
                                            {{ $item->orderCode }} <br>
                                            {{ $item->phone }}
                                        </td>
                                        <td><a href="{{ Route('admin.customer.edit', $item->customer_id) }}"
                                                class="text-primary">{{ $item->fullname }}</a></td>
                                        <td>{{ currency_format($item->total, '.đ') }}</td>
                                        <td><span
                                                class="badge badge-{{ get_status_order_css($item->status) }}">{{ get_status_order($item->status) }}</span>
                                        </td>
                                        <td>
                                            {{ get_payment_method($item->payment) }}
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>

                                            <a class="btn btn-success" href="{{ Route('admin.order.edit', $item->id) }}">Chi tiết</a>

                                        </td>
                                        <td>

                                            @if (Request::get('status') === 'trash')
                                                <a href="{{ Route('admin.order.delete', $item->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ Route('admin.order.destroy', $item->id) }}"
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
                                    <td colspan="9" class="text-center bg-white">Không tìm thấy đơn hàng nào</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                <nav aria-label="Page navigation example">
                    {{ $list_order->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
