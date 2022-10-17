@extends('layouts.admin')

@section('content')
    @if (session('alert'))
        <div class="alert alert-danger">
            {{ session('alert') }}
        </div>
    @endif
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG CHỜ XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG VẬN CHUYỂN</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[3] }}</h5>
                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">BÀI VIẾT</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[4] }}</h5>
                        <p class="card-text">Số lượng bài viết</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">SỐ LƯỢNG SẢN PHẨM</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[5] }}</h5>
                        <p class="card-text">Số lượng sản phẩm</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header">SLIDER</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[6] }}</h5>
                        <p class="card-text">Số lượng slider</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ currency_format($sales, '.đ') }}</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                @if ($list_order->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mã</th>
                                <th scope="col">Khách hàng/SĐT</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($list_order as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <th scope="row">{{ $t }}</th>
                                    <td>{{ $item->orderCode }}</td>
                                    <td>
                                        <a href="{{ Route('admin.customer.edit', $item->customer_id) }}"
                                            class="text-primary">{{ $item->fullname }}</a> <br>
                                        {{ $item->phone }}
                                    </td>
                                    <td>{{ currency_format($item->total, '.đ') }}</td>
                                    <td><span
                                            class="badge badge-{{ get_status_order_css($item->status) }}">{{ get_status_order($item->status) }}</span>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a href="{{ Route('admin.order.edit', $item->id) }}" class="" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center m-0">Không có đơn hàng mới nào</p>
                @endif
                <nav aria-label="Page navigation example">
                    {{ $list_order->links() }}
                </nav>

            </div>
        </div>

    </div>
@endsection
