$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    $(".nav-link.active i.arrow").toggleClass("fa-angle-right fa-angle-down");
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
    setTimeout(function () {
        $(".alert").slideToggle();
    }, 3000);

    // function Chart30days() {
    //     var url = $(".filter-statistical").attr("data-url");
    //     $.ajax({
    //         type: "GET",
    //         url: url,
    //         dataType: "json",
    //         success: function (data) {
    //             chart.setData(data);
    //         },
    //     });
    // }
    // Chart30days();

    // var chart = new Morris.Bar({
    //     element: "myfirstchart",
    //     xkey: "date",
    //     ykeys: ["total"],
    //     labels: ["Doanh số"],
    //     grid: false,
    //     fillOpacity: 0.4,
    //     hideHover: "auto",
    //     xLabels: "day",
    //     behaveLikeLine: true,
    //     resize: true,
    //     xLabelAngle: 1,
    //     xLabelFormat: function (d) {
    //         return (
    //             ("0" + d.getDate()).slice(-2) +
    //             "-" +
    //             ("0" + (d.getMonth() + 1)).slice(-2) +
    //             "-" +
    //             d.getFullYear()
    //         );
    //     },
    //     pointFillColors: ["#ffffff"],
    //     pointStrokeColors: ["black"],
    //     barSize: 75
    // });

    // $(".chart").submit(function (e) {
    //     e.preventDefault();
    //     var url = $(".chart").attr("data-url");
    //     var from_date = $("#from-date").val();
    //     var to_date = $("#to-date").val();
    //     var _token = $("input[name='_token']").val();
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: { from_date: from_date, to_date: to_date, _token: _token },
    //         dataType: "json",
    //         success: function (data) {
    //             if (data.message == 1) {
    //                 chart.setData(data.data_chart);
    //             } else {
    //                 alert(data.message);
    //             }
    //         },
    //     });
    // });

    $("#from-date").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFomart: "dd-mm-yy",
        dayNamesMin: [
            "Thứ 2",
            "Thứ 3",
            "Thứ 4",
            "Thứ 5",
            "Thứ 6",
            "Thứ 7",
            "Chủ nhật",
        ],
        changeMonth: false,
    });

    $("#to-date").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFomart: "dd-mm-yy",
        dayNamesMin: [
            "Thứ 2",
            "Thứ 3",
            "Thứ 4",
            "Thứ 5",
            "Thứ 6",
            "Thứ 7",
            "Chủ nhật",
        ],
        changeMonth: false,
    });
});
