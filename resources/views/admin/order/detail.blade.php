@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card border-0">
            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif
            <div class="card-header font-weight-bold justify-content-between align-items-center bg-white border-bottom-0">
                <h5>Thông tin Khách hàng</h5>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ Route('admin.order.update', $detail->id) }}" class="detail">
                    @csrf
                    <ul class="list-item pl-0 row">
                        <div class="col-6">
                            <li>
                                <h6 class="">Mã đơn hàng</h6>
                                <span class="detail">{{ $detail->orderCode }}</span>
                            </li>
                            <li>
                                <h6 class="">Họ và tên</h6>
                                <input type="text" name="fullname" class="form-control" value="{{ $detail->fullname }}">
                                @error('fullname')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </li>
                            <li>
                                <h6 class="">Email</h6>
                                <input type="text" name="email" class="form-control" value="{{ $detail->email }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </li>
                            <li>
                                <h6 class="">Số điện thoại</h6>
                                <input type="text" name="phone" class="form-control" value="{{ $detail->phone }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </li>
                        </div>
                        <div class="col-6">
                            <li>
                                <h6 class="">Nội dung</h6>
                                <textarea name="note" id="" class="form-control" cols="5" rows="5">{{ $detail->note }}</textarea>
                            </li>
                            <li>
                                <h6 class="">Thông tin vận chuyển</h6>
                                <select class="form-control" name="payment" id="">
                                    <option {{ $detail->payment == 'at-home' ? 'selected' : '' }} value="at-home">Thanh
                                        toán khi nhận hàng</option>
                                    <option {{ $detail->payment == 'bank' ? 'selected' : '' }} value="bank">Thanh toán
                                        ngân hàng</option>
                                </select>
                            </li>
                            <li>
                                <h6 class="">Địa chỉ</h6>
                                <textarea name="address" id="" class="form-control" cols="5" rows="5">{{ $detail->address }}</textarea>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </li>
                        </div>
                    </ul>
                    <div>
                        <h6 class="">Tình trạng đơn hàng</h6>
                        <div class="form-action form-inline mt-3">
                            <select name="status" class="form-control mr-1 bg-danger text-white">
                                <option class="bg-white text-dark" {{ $detail->status == 'pending' ? 'selected' : '' }}
                                    value="pending">Đang xử lý</option>
                                <option class="bg-white text-dark" {{ $detail->status == 'confirmed' ? 'selected' : '' }}
                                    value="confirmed">Xác nhận</option>
                                <option class="bg-white text-dark" {{ $detail->status == 'shipping' ? 'selected' : '' }}
                                    value="shipping">Đang vận chuyển</option>
                                <option class="bg-white text-dark" {{ $detail->status == 'completed' ? 'selected' : '' }}
                                    value="completed">Thành công</option>
                                <option class="bg-white text-dark" {{ $detail->status == 'cancel' ? 'selected' : '' }}
                                    value="cancel">Hủy</option>
                            </select>
                                <input type="submit" class="btn btn-primary" value="Cập nhật đơn hàng">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card border-0">
            <div class="card-header font-weight-bold justify-content-between align-items-center border-0 bg-white py-0">
                <h5>Sản phẩm đơn hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ẢNH SẢN PHẨM</th>
                            <th scope="col" style="width:500px">TÊN SẢN PHẨM</th>
                            <th scope="col">ĐƠN GIÁ</th>
                            <th scope="col">SỐ LƯỢNG</th>
                            <th scope="col">THÀNH TIỀN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_order_product as $item)
                            <tr>
                                <td scope="row">1</td>
                                <td><img width="80px" src="{{ asset($item->product->product_thumb) }}" alt=""></td>
                                <td><a class="pd-name">{{ $item->product->product_title }}</a></td>
                                <td>{{ currency_format($item->price, '.đ') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ currency_format(get_subtotal($item->price, $item->qty), '.đ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card border-0">
            <div class="card-header font-weight-bold justify-content-between align-items-center border-0 bg-white py-0">
                <h5>Giá trị đơn hàng</h5>
            </div>
            <div class="card-body">
                <ul class="list-item clearfix pl-0">
                    <li class="float-left text-right" style="width:20%;">
                        <span class="total-fee">Tổng số lượng:</span>
                        <span class="total text-danger">Tổng đơn hàng:</span>
                    </li>
                    <li class="float-right" style="width:80%;">
                        <span class="total-fee">{{ $detail->total_product }}</span>
                        <span class="total text-danger">{{ currency_format($detail->total, '.đ') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
