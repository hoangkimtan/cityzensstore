@extends('layouts.home')
@section('content')
    <div class="content" style="min-height: 200px">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('tra-cuu-don-hang') }}">
                    <label for="code">Mời quý khách nhập mã vận đơn để tra cứu (VD: ISM-160689,ISM-123456789)</label>
                    <div class="input-group mt-2">
                        <input type="text" name="code" id="code" class="form-control"
                            value="{{ request()->input('code') }}" required="">
                        <button class="btn btn-danger">Tìm đơn hàng</button>
                    </div>
                </form>
            </div>
        </div>
        @if (!$info_order && $order_code)
            <div class="alert alert-danger mt-4">
                <strong class="text-danger">Mã đơn hàng <span class="badge badge-danger">{{ $order_code }}</span>
                    sai hoặc đơn hàng không tồn tại !</strong>
            </div>
        @elseif($info_order)
            <div class="row mt-3">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Thông tin đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="title">
                                        <i class="fas fa-barcode text-primary mr-1"></i>
                                        <strong>Mã đơn hàng</strong>
                                    </div>
                                    <div class="content mt-2">
                                        {{ $info_order->orderCode }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="title">
                                        <i class="fas fa-cash-register text-primary mr-1"></i>
                                        <strong>Hình thức thanh toán</strong>
                                    </div>
                                    <div class="content mt-2">
                                        {{ get_payment_method($info_order->payment) }}
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="title">
                                        <i class="fas fa-map-marked-alt text-primary mr-1"></i>
                                        <strong>Địa chỉ nhận</strong>
                                    </div>
                                    <div class="content mt-2">
                                        {{ $info_order->address }}
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="title">
                                        <i class="fas fa-shipping-fast text-primary mr-1"></i>
                                        <strong>Trạng thái đơn hàng</strong>
                                    </div>
                                    <div class="content mt-2">
                                        <h2 class="text-danger font-weight-bold" style="font-size: 1.3rem">
                                            {{ get_status_order($info_order->status) }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 ">
                    <div class="card">
                        <div class="card-header">
                            <h5>Tổng giá trị đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="section">
                                <strong>Tổng số sản phẩm:</strong><span
                                    class="ml-2">{{ $info_order->total_product }}</span>
                            </div>
                            <div class="section">
                                <strong class="text-danger">
                                    Tổng giá trị:
                                </strong><span
                                    class="text-danger font-weight-bold ml-2">{{ currency_format($info_order->total, '.đ') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Khách hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="title">
                                        <i class="fas fa-user text-primary mr-1"></i>
                                        <strong>Tên khách hàng</strong>
                                    </div>
                                    <div class="content mt-1">
                                        {{ $info_order->fullname }}
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="title">
                                        <i class="fas fa-phone-volume text-primary mr-1"></i>
                                        <strong>Số điện thoại</strong>
                                    </div>
                                    <div class="content mt-1">
                                        {{ $info_order->phone }}
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="title">
                                        <i class="fas fa-at text-primary mr-1"></i>
                                        <strong>Email</strong>
                                    </div>
                                    <div class="content mt-1">
                                        @if ($info_order->email == '')
                                            Không có email
                                        @else
                                            {{ $info_order->email }}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="title">
                                        <i class="fas fa-comment text-primary mr-1"></i>
                                        <strong>Ghi Chú</strong>
                                    </div>
                                    <div class="content mt-1">
                                        <div class="text-muted font-italic">
                                            @if ($info_order->note == '')
                                                Không có ghi chú
                                            @else
                                                {{ $info_order->note }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Danh sách sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-checkall">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t = 0;
                                    @endphp
                                    @if ($list_order_product->count() > 0)
                                        @foreach ($list_order_product as $item)
                                            @php
                                                $t++;
                                            @endphp
                                            <tr class="">
                                                <td>{{ $t }}</td>
                                                <td>
                                                    <a
                                                        href="{{ Route('product.detail', [$item->product->slug, $item->product_id]) }}">
                                                        <img src="{{ asset($item->product->product_thumb) }}"
                                                            style="max-width:100px" alt="">
                                                    </a>
                                                </td>
                                                <td style="width:500px;">
                                                    <a
                                                        href="{{ Route('product.detail', [$item->product->slug, $item->product_id]) }}">
                                                        {{ $item->product->product_title }}
                                                    </a>
                                                </td>
                                                <td>{{ currency_format($item->product->price, '.đ') }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ currency_format(get_subtotal($item->price, $item->qty), '.đ') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
