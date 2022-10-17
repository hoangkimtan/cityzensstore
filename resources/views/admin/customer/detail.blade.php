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
            @if ($customer)
                <div class="card-body pt-0">
                    <ul class="list-item pl-0">
                        <form method="POST" action="{{ Route('admin.customer.update', $customer->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <li>
                                            <h6 class="">Tên khách hàng</h6>
                                            <input type="text" name="fullname" class="form-control"
                                                value="{{ $customer->fullname }}">
                                            @error('fullname')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </li>
                                        <li>
                                            <h6 class="">Số điện thoại</h6>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $customer->phone }}">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </li>
                                        <li>
                                            <h6 class="">Email</h6>
                                            <input type="text" name="email" class="form-control"
                                                value="{{ $customer->email }}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </li>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <li>
                                            <h6 class="">Địa chỉ</h6>
                                            <textarea name="address" id="" class="form-control" cols="35" rows="5">{{ $customer->address }}</textarea>
                                        </li>
                                        <li>
                                            <h6 class="">Ghi chú</h6>
                                            <textarea name="note" id="" class="form-control" cols="5" rows="5">{{ $customer->note }}</textarea>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success">Cập nhật</button>
                        </form>
                    </ul>
                </div>
            @else
                <div class="card-body mt-2">
                    <div class="card-header text-center">
                        Khách hàng không tồn tại trong hệ thống
                    </div>
                </div>
            @endif
        </div>
        <div class="card border-0">
            <div class="card-header font-weight-bold justify-content-between align-items-center border-0 bg-white py-0">
                <h5>Đơn hàng của khách hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã/SĐT</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Ngày đặt hàng</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @if ($orders)
                            @foreach ($orders as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>{{ $t }}</td>
                                    <td>
                                        {{ $item->orderCode }} <br>
                                        {{ $item->phone }}
                                    </td>
                                    <td>{{ $item->fullname }}</td>
                                    <td>{{ currency_format($item->total, '.đ') }}</td>
                                    <td><span
                                            class="badge badge-{{ get_status_order_css($item->status) }}">{{ get_status_order($item->status) }}</span>
                                    </td>
                                    <td>
                                        @foreach ($item->orderDetail as $product)
                                            <span class="text-secondary">{{ $product->product->product_title }}</span><br>
                                            <span>SL:{{ $product->qty }} (Sp)</span><br>
                                        @endforeach
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td><a href="{{ Route('admin.order.edit', $item->id) }}">Chi tiết</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center bg-white">Không tìm thấy đơn hàng nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if ($orders)
                    <nav aria-label="Page navigation example">
                        {{ $orders->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection
