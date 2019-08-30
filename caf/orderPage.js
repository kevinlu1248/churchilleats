$(document).ready(function () {
    $("#exit-button").click(function () {
        window.location = "/";
    });

    var foodsData = [];
    $.getJSON("../assets/foodsData.json", function (data) {
        console.log("Foods:");
        console.log(data['foods']);
        foodsData = data['foods'];
    });

    //helper functions

    var monetize = function (money) {
        return "$" + parseFloat(Math.round(money * 100) / 100).toFixed(2);
    };

    // returns stringified json with number of delivering and serving
    var getStatuses = function (orders) {
        var json = {serving: 0, delivering: 0};
        orders.forEach(function (order) {
            if (order.status == "delivering") {
                json.delivering += 1;
            } else if (order.status == "serving") {
                json.serving += 1;
            }
        });
        return JSON.stringify(json);
    };

    var verifyRejectionReasoningButton = function (orderID) {
        // console.log("#rejectionReason-" + orderID);
        if ($("#rejectionReason-" + orderID).val()) {
            $("#submitReason-" + orderID).removeAttr("disabled");
        } else {
            $("#submitReason-" + orderID).attr("disabled", true);
        }
    };

    toastr.options = {
        "closeButton": false,
        "debug": true,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "tapToDismiss": true,
        "showDuration": "150",
        "hideDuration": "150",
        "timeOut": "5000",
        "showEasing": "swing",
        "hideEasing": "swing",
        "showMethod": "slideDown",
        "hideMethod": "slideUp",
    };

    var updateOrders = function () {
        $("caption").html("Refreshing...");
        $.ajax({
            method: "GET",
            url: "../library/caf/getOrders.php",
            dataType: "json",
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            success: function (data) {
                var orders = data;
                var table = $("#tableBody");
                var statuses = getStatuses(orders);

                if (statuses != table.attr("statuses")) {
                    table.attr("statuses", statuses);
                    table.children().fadeOut();

                    orders.forEach(function (order) {
                        var orderID = order.orderID;
                        // fix name
                        var name = order.fullName;
                        var location = order.location;
                        var foods = JSON.parse(order.foodOrder);
                        var status = order.status;
                        var totalCost = order.cost;
                        var firstFood = foods[0];
                        // console.log(order);

                        if (foods.length == 1) {
                            var html = `<tr class="${orderID}">
                                <td>
                                    ${orderID}
                                    <span id="${orderID}" hidden>${JSON.stringify(order)}</span>
                                </td>
                                <td>${name}</td>
                                <td>${location}</td>
                                <td>${firstFood.name}</td>
                                <td>${firstFood.qty}</td>
                                <td>${monetize(firstFood.cost)}</td>
                                <td>${totalCost}</td>`;

                            if (status == "serving") {
                                html += `
                                <td><button class="btn btn-primary actionBtn" for="${orderID}">Delivering</button></td>`;
                            } else if (status == "delivering") {
                                html += `
                                <td><button class="btn btn-success" for="${orderID}" data-toggle="modal" data-target="#done-modal-${orderID}">Done</button></td>`;
                            }

                            html += `
                                <td><button class="btn btn-danger" for="${orderID}" data-toggle="modal" data-target="#reject-modal-${orderID}">Reject</button></td>
                            </tr>
                            <tr class="${orderID}">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;

                            table.append(html);
                        } else {
                            var html =
                                `<tr class="${orderID}">
                                <td>
                                    ${orderID}
                                    <span id="${orderID}" hidden>${JSON.stringify(order)}</span>
                                </td>
                                <th>${name}</th>
                                <td>${location}</td>
                                <td>${firstFood.name}</td>
                                <td>${firstFood.qty}</td>
                                <td>${monetize(firstFood.cost)}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;

                            table.append(html);

                            foods.forEach(function (food, index) {
                                if (index == foods.length - 1) {
                                    // last row of foods
                                    var html =
                                        `<tr class="last-row ${orderID}">
                                        <td> </td>
                                        <td></td>
                                        <td></td>
                                        <td>${food.name}</td>
                                        <td>${food.qty}</td>
                                        <td>${monetize(food.cost)}</td>
                                        <td>${monetize(totalCost)}</td>
                                    `;

                                    if (status == "serving") {
                                        html += `
                                        <td><button class="btn btn-primary actionBtn" for="${orderID}">Delivering</button></td>`;
                                    } else if (status == "delivering") {
                                        html += `
                                        <td><button class="btn btn-success" for="${orderID}" data-toggle="modal" data-target="#done-modal-${orderID}">Done</button></td>`;
                                    }

                                    html += `
                                        <td><button class="btn btn-danger" for="${orderID}" data-toggle="modal" data-target="#reject-modal-${orderID}">Reject</button></td>
                                    </tr>
                                    <tr class="table-active ${orderID}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>`;
                                } else if (index != 0) {
                                    // console.log(index);
                                    var html =
                                        `<tr class="table-active ${orderID}">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${food.name}</td>
                                        <td>${food.qty}</td>
                                        <td>${monetize(food.cost)}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>`;
                                }
                                table.append(html);
                            });
                        }

                        var modalsHtml = `
                        <div class="modal fade" id="done-modal-${orderID}" tabindex="-1" role="dialog" aria-labelledby="modal-done-label${orderID}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-done-label${orderID}">Are you sure the order is complete?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                Please confirm that the order has been delivered and paid for. Note that this action can not be undone.
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-success actionBtn" for="${orderID}" data-dismiss="modal">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="reject-modal-${orderID}" tabindex="-1" role="dialog" aria-labelledby="modal-reject-label${orderID}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-reject-label${orderID}">What is the reason for rejecting Order ${orderID}?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="#rejectionReason${orderID}">Your reason:</label>
                                    <br/>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <button id="rejctionReasonBtn${orderID}" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Defaults
                                        </button>
                                        <div class="dropdown-menu rejectionDefaults">
                                          <button class="dropdown-item btn" orderID="${orderID}" for="#rejectionReason-${orderID}">We are out of stock.</button>
                                          <button class="dropdown-item btn" orderID="${orderID}" for="#rejectionReason-${orderID}">The order is unreasonable.</button>
                                          <button class="dropdown-item btn" orderID="${orderID}" for="#rejectionReason-${orderID}">The Cafeteria is closing.</button>
                                        </div>
                                      </div>
                                      <input id="rejectionReason-${orderID}" name="reason" type="text" class="form-control rejectionReason" orderID="${orderID}">
                                    </div>
                                    <small class="text-muted" for="#rejectionReason-${orderID}">Please provide a valid reason or choose a default reason on the left.</small>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button id="submitReason-${orderID}" type="button" class="btn btn-danger actionBtn" for="${orderID}" data-dismiss="modal" disabled>Confirm Rejection</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        $("#modals").append(modalsHtml);
                    });

                    //btn handlers
                    // delivering and rejecting
                    $(".actionBtn").unbind().click(function () {
                        var orderID = $(this).attr("for");
                        var action = $(this).html();
                        var orderData = $("#" + orderID).html();
                        // console.log(JSON.parse(orderData));
                        if (action == "Confirm Rejection") {
                            var reason = $("#rejectionReason-" + orderID).val();
                            $.ajax({
                                method: "POST",
                                url: "/library/caf/rejectOrder.php",
                                data: {
                                    order: orderData,
                                    reason: reason
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                    toastr.error(`Order ${orderID} rejection unsuccessful for the following reason: ${errorThrown}`, "Error");
                                },
                                success: function (data) {
                                    console.log(data);
                                    if (data == "true") {
                                        $(".orderID").fadeOut("slow");
                                        toastr.success(`Order ${orderID} was rejected because: "${reason}"`, "Success");
                                    }
                                }
                            });
                        } else if (action == "Delivering") {
                            $.ajax({
                                method: "POST",
                                url: "/library/caf/deliveringOrder.php",
                                data: {orderID: orderID},
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                    toastr.error(`Order ${orderID} delivering unsuccessful for the following reason: ${errorThrown}`, "Error");
                                },
                                success: function (data) {
                                    if (data == "true") {
                                        console.log("delivering successful");
                                        toastr.info(`Order ${orderID} delivering successful`, "Success");
                                    }
                                }
                            });
                        } else if (action == "Yes") {
                            $.ajax({
                                method: "POST",
                                url: "/library/caf/doneOrder.php",
                                data: {order: orderData},
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                    $(`#done-modal-${orderID}`).modal("hide");
                                    toastr.success(`Order ${orderID} finishing unsuccessful for the following reason: ${errorThrown}`, "Error");
                                },
                                success: function (data) {
                                    // console.log(data)
                                    if (data == "true") {
                                        console.log("finishing order successful");
                                        toastr.success(`Order ${orderID} finished successful`, "Success");
                                    }
                                }
                            }).done(function () {

                                // $("#done-modal-${orderID}").modal('hide');
                            });
                        }
                    });

                    $(".rejectionDefaults > button").unbind().click(function () {
                        var orderID = $(this).attr("orderID");
                        var defaultReason = $(this).html();
                        var reasonInput = $(this).attr("for");
                        $(reasonInput).val(defaultReason);
                        verifyRejectionReasoningButton(orderID);
                    });

                    $(".rejectionReason").unbind().keyup(function () {
                        verifyRejectionReasoningButton($(this).attr("orderID"));
                    });
                }
            }
        })
            .done(function (data) {
                $("caption").html("Last refreshed at " + new Date().toLocaleTimeString());
            });
    };

    updateOrders();

    var frequentID = setInterval(updateOrders, 1000);
    var infrequentID = setInterval(updateOrders, 5000);

    $("#frequent-toggle").click(function () {
        console.log("frequent intervals");
        clearInterval(frequentID);
        clearInterval(infrequentID);
        frequentID = setInterval(updateOrders, 1000);
    });

    $("#infrequent-toggle").click(function () {
        console.log("infrequent intervals");
        clearInterval(frequentID);
        clearInterval(infrequentID);
        infrequentID = setInterval(updateOrders, 5000);
    });
});
