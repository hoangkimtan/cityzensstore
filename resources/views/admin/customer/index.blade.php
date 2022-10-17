@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách khách hàng</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" name='key' placeholder="Tìm kiếm">
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
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">SĐT</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($list_customer)
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($list_customer as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>{{ $t }}</td>
                                    <td>{{ $item->fullname }}</td>
                                    <td>
                                        {{ $item->phone }}
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <a href="{{ Route('admin.customer.edit', $item->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ Route('admin.customer.destroy', $item->id) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa')" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center bg-white">Không có khách hàng nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    {{ $list_customer->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
