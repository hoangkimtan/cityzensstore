<div class="">
    <div class="aHl"></div>
    <div id=":oa" tabindex="-1"></div>
    <div id=":n3" class="ii gt">
        <div id=":n4" class="a3s aiL "><u></u>
            <div>
                <span style="margin-bottom:10px;display:block">Xin chào {{ $fullname }}</span>
                <p>Rất cảm ơn quý khách đã tin tưởng và lựa chọn dịch vụ sản phẩm tại của hàng <strong
                        style="color:#ad0000">Cityzens</strong> của chúng tôi.</p>
                <span style="margin-bottom:10px;display:block">Chi tiết đơn hàng:</span>
                <table style="width:70%;text-align:center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">TÊN SẢN PHẨM</th>
                            <th scope="col" style="white-space: nowrap">ĐƠN GIÁ</th>
                            <th scope="col" style="white-space: nowrap">SỐ LƯỢNG</th>
                            <th scope="col" style="white-space: nowrap">THÀNH TIỀN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach ($content as $item)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td scope="row">{{ $t }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ currency_format($item->price, '.đ') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ currency_format($item->total, '.đ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="font-weight:600;font-size:15px;margin-bottom:15px">Tổng giá: <span
                        style="color:#ad0000">{{ currency_format($total, '.đ') }}</span></p>

                <p>Nếu có bất kỳ vấn đề gì, hãy gọi ngay đến tổng đài trợ giúp của chúng tôi tại đây!</p>
                <span>Hotline:0348431999</span>
                <div class="yj6qo"></div>
                <div class="adL">
                </div>
            </div>
            <div class="adL">
            </div>
        </div>
    </div>
    <div id=":o6" class="ii gt" style="display:none">
        <div id=":o5" class="a3s aiL "></div>
    </div>
    <div class="hi"></div>
</div>
