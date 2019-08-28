$(document).ready(function () {
    var current_status = "serving";
    // console.log(current_status);

    $("#cancel-order").click(function () {
        window.location.href = "../../../library/orderingActions/cancelOrder.php";
    });

    $("#done-order").click(function () {
        window.location.href = "../../../library/orderingActions/doneOrder.php";
    });

    setInterval(function () {
        var val = parseInt($('#serving-timer').html());
        $('#serving-timer').html(val + 1);
    }, 1000);

    var getOrderingStatus = function () {
        $.ajax({
            method: "GET",
            url: "../../../library/orderingActions/getStatus.php",
            dataType: "text",
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            success: function (data) {
                console.log(data);
                if (current_status != data) {
                    if (data == "delivering") {
                        $("#serving").attr("hidden", true);
                        $("#delivering").removeAttr("hidden");
                    } else if (data == "delivered" || !data) {
                        window.location.href = "../../../library/orderingActions/orderDone.php";
                    } else if (data == "rejected") {
                        window.location.href = "../../../library/orderingActions/orderRejected.php";
                    }
                }
                // update status
                current_status = data;
            }
        });
    };

    getOrderingStatus();
    setInterval(getOrderingStatus, 1000);
});
