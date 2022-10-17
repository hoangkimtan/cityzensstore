$(document).ready(function () {
    setTimeout(function () {
        $(".success").fadeOut(1000);
    }, 1500);
    //click đọc thêm
    $(".moredetail").click(function () {
        $("#post-product-wp").toggleClass("active");
        var text = $(".moredetail-item").text();
        if (text == "Đọc thêm") {
            $(".moredetail-item").text("Rút gọn");
        } else {
            $(".moredetail-item").text("Đọc thêm");
            $("body,html").animate(
                {
                    scrollTop: "600px",
                },
                700
            );
        }
    });
    //cập nhật giỏ hàng ajax
    $(".num-order").change(function (e) {
        e.preventDefault();
        var url = $(this).attr("data-url");
        var rowId = $(this).attr("data-rowId");
        var qty = $(this).val();
        var data = { url: url, rowId: rowId, qty: qty };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                $(".product-" + rowId).text(data.sub_total);
                $("span.qty-" + rowId).text(data.num_order);
                $(".price.total").text(data.total);
                $("#total-price span").text(data.total);
                $(".total-cart").text(data.total_cart);
                $("#cart-respon-wp span#num").text(data.total_cart);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    });

    //   $('.num-order').keypress(function(e){
    //       e.preventDefault();
    //   })

    $(".filter").click(function () {
        $.ajax({
            url: "{{url(filter)}}",
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {},
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    });
    
       $("#city").click(function(){
        var url = $(this).attr("data-url");
        var cityId = $(this).find(":selected").attr("data-id");
        var data = { cityId: cityId };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "html",
            success: function (data) {
                $("#district").html(data);
                $("#district").removeAttr("readonly");
                $("#district").css("pointer-events","all");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    })

    $("#city").change(function () {
        var url = $(this).attr("data-url");
        var cityId = $(this).find(":selected").attr("data-id");
        var data = { cityId: cityId };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "html",
            success: function (data) {
                $("#district").html(data);
                 $("#district").removeAttr("readonly");
                $("#district").css("pointer-events","all");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    });
    $("#district").change(function () {
        var url = $(this).attr("data-url");
        var districtId = $(this).find(":selected").attr("data-id");
        var data = { districtId: districtId };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "html",
            success: function (data) {
                $("#commune").html(data);
                $("#commune").removeAttr("readonly");
                $("#commune").css("pointer-events","all");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    });
    //=======================LỌC SP============================
    $("#filter input[name='r-price']").change(function () {
        $("#filter input[name='r-price']").removeClass("price");
        $(this).addClass("price");
        var url = $(this).attr("data-url");
        var brand = $("#filter .brand ").val();
        if (!brand) {
            brand = null;
        }
        var id = $("#sort-cat-id").attr("data-id");
        var price = $(this).val();
        var data = { brand: brand, price: price, id: id };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                $("#list-product").html(data.str);
                $("#paging-wp").html(data.pagging);
                $(".count-product").html(data.count);
                if (data.count == "(0 sản phẩm)") {
                    $(".filter-wp").css("display", "none");
                } else {
                    $(".filter-wp").css("display", "block");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
        return false;
    });

    $("#filter input[name='r-brand']").change(function () {
        $("#filter input[name='r-brand']").removeClass("brand");
        $(this).addClass("brand");
        var price = $("#filter .price ").val();
        var url = $(this).attr("data-url");
        if (!price) {
            price = null;
        }
        var id = $("#sort-cat-id").attr("data-id");
        var brand = $(this).val();
        var data = { brand: brand, price: price, id: id };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                $("#list-product").html(data.str);
                $("#paging-wp").html(data.pagging);
                $(".count-product").html(data.count);
                $(".cat-name").text(data.cat_title);
                if (data.count == "(0 sản phẩm)") {
                    $(".filter-wp").css("display", "none");
                } else {
                    $(".filter-wp").css("display", "block");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
        return false;
    });

    $(".sort").change(function () {
        var value = $(this).val();
        var url = $(this).attr("data-url");
        var id = $("#sort-cat-id").attr("data-id");
        var price = $("#filter .price ").val();
        var brand = $("#filter .brand ").val();
        var data = { value: value, id: id, price: price, brand: brand };
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                $("#list-product").html(data.str);
                $("#paging-wp").html(data.pagging);
                // $(".count-product").html(data.count);
                // $(".cat-name").text(data.cat_title);
                // if (data.count == "(0 sản phẩm)") {
                //     $(".filter-wp").css("display", "none");
                // } else {
                //     $(".filter-wp").css("display", "block");
                // }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status);
                // alert(thrownError);
            },
        });
    });

    $(".list-pay .card .card-header").click(function () {
        $(".list-pay .card .card-body").removeClass("active");
        $(this).parent(".card").children(".card-body").addClass("active");
        $(this).parent(".card").children(".active").slideDown();
        $(".list-pay .card .card-body").not(".active").slideUp();
    });
});
