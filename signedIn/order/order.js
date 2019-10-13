$(document).ready(function () {

    var foods = {};

    var getImageURL = function (query) {
        var output = "";

        var pixabayAPI = "https://pixabay.com/api/";
        $.getJSON(pixabayAPI, {
                key: "12385886-e50ba07b2c9bf55ce5c73dae2",
                q: query,
                category: "food"
            },
            function (result) {
                var images = result.hits;
                // console.log(images[0].webformatURL);
                if (images.length > 0) {
                    // console.log(images[0].webformatURL);
                    output = images[0].webformatURL;
                }
                ;
            })
            .fail(function (xhr, status, error) {
                console.log(error);
            });

        return output;
    };

    //getting local json file for foods
    $.getJSON("/assets/foodsData.json", function (data) {
        foods = data["foods"];
        console.log(foods);
        $("#food-spinner-container").remove();
        foods.forEach(function (food) {
            var id = food["id"];
            var name = food["name"];
            var cost = parseFloat(Math.round(food["cost"] * 100) / 100).toFixed(2);
            var max = "";
            var image = "";

            if (food.hasOwnProperty("max")) {
                max = `max="${food['max']}"`;
            }

            if (food.hasOwnProperty("image")) {
                image = `assets/foods/${food["image"]}`;
            }

            var cardTemplate = `
                    <div id="${id}-card" class="row food-item mx-0 px-3">
                        <div class="col-2 d-flex px-0 overflow-auto">
                            <img src="${image}" alt="" class="food-image" align="middle" imageOf="${name}">
                        </div>
                        <div class="col-6 text-left d-flex pr-0 pl-3">
                            <div class="align-self-center food-name">
                                ${name}</br>
                                $${cost}
                            </div>
                        </div>
                        <div class="col-4 d-flex px-0 justify-content-between">
                            <div id="${id}-hider" class="hider justify-content-between flex-2 mr-2" style="display: none;">
                                <div class="display-4 quantity d-flex">
                                     <div class="d-flex align-self-center">
                                         <div id="${id}-counter" type="number" class="counter" cost="${cost}" ${max}>0</div>
                                     </div>
                                </div>
                                <div class="align-self-center">
                                    <button id="${id}-minus" class="minus counter-buttons btn btn-outline-light" for="${id}" disabled><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="d-flex align-self-center ml-auto">
                                <button id="${id}-plus" class="plus counter-buttons btn btn-light" for="${id}"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                `;


            $(cardTemplate).insertBefore("#instructions-unhider-container");
            // console.log(cardTemplate);
        });
    })
        .fail(function () {
            $("#food-cards-container").html(`
            <p class="text-danger">
                An error has occured. Please refresh the page or contact an administrator.
            </p>
        `);
        })
        .done(function () {

            // set event handler for button presses
            $(".counter-buttons").click(function () {
                const doAdd = $(this).hasClass("plus");
                const targetFood = $(this).attr("for");
                const targetCounter = $("#" + targetFood + "-counter");
                const foodCost = targetCounter.attr("cost"); // cost of the food
                const targetCost = $("#" + targetFood + "-cost");
                var value = parseInt(targetCounter.html());

                if (doAdd) {
                    targetCounter.html(value + 1);
                    value++;
                } else {
                    targetCounter.html(value - 1);
                    value--;
                }

                // value rounded to two decimal
                targetCost.html(parseFloat(Math.round(value * foodCost * 100) / 100).toFixed(2));

                //disabling buttons
                const addButton = $("#" + targetFood + "-plus");
                const subtractButton = $("#" + targetFood + "-minus");
                const maxFoodWarning = $("#" + targetFood + "-max-warning");
                const maxCount = targetCounter.attr("max");


                if (value <= 0 && !doAdd) {
                    // slide out
                    $(`#${targetFood}-hider`).fadeOut(100);
                }
                if (targetCounter.html() == 1 && doAdd) {
                    // slide in
                    $(`#${targetFood}-hider`).fadeIn(100);

                }

                if (targetCounter.html() <= 0) {
                    // deactivates subtract button

                    subtractButton.attr("disabled", true);
                } else {
                    //activates subtract button
                    // $(`#${targetFood}-hider`).animate({width: "toggle"}, 350);
                    subtractButton.attr("disabled", false);
                }

                if (maxCount > 0) {
                    if (targetCounter.html() >= maxCount) {
                        addButton.attr("disabled", true);
                        maxFoodWarning.attr("hidden", false);

                    } else {
                        addButton.attr("disabled", false);
                        maxFoodWarning.attr("hidden", true);
                    }
                }

                // if something is bought, have footer bar show up
                var totalCost = 0;
                var order = [];
                foods.forEach(function (food) {
                    const id = food.id;
                    const cost = parseFloat($("#" + id + "-counter").attr("cost"));
                    var count = parseInt($("#" + id + "-counter").html());
                    totalCost += cost * count;
                    console.log(count);

                    if (count != "0") {
                        var count = $("#" + id + "-counter").html();
                        var foodObject = {
                            "id": id,
                            "name": food["name"],
                            "cost": food["cost"],
                            "qty": count,
                            "totalCost": count * food["cost"]
                        }

                        order.push(foodObject);
                    }
                });

                $("#total-cost").val(parseFloat(Math.round(totalCost * 100) / 100).toFixed(2));
                // console.log(order);
                $("#order").val(JSON.stringify(order));

                if (parseFloat($("#total-cost").val())) {
                    // $("#ordering-footer").removeAttr("hidden");
                    $("#ordering-footer").slideDown("fast");
                } else {
                    // $("#ordering-footer").attr("hidden", "");
                    $("#ordering-footer").slideUp("fast");
                }
            });
            // adding images
            $("img").each(function () {
                if (!$(this).attr("src")) {
                    var imageOf = $(this).attr("imageOf");
                    var imageID = $(this).attr("id");
                    // console.log(imageOf.toLowerCase());

                    //get image ajax call
                    var pixabayAPI = "https://pixabay.com/api/";

                    $.ajax(pixabayAPI, {
                        method: "GET",
                        dataType: "json",
                        async: false,
                        data: {
                            key: "12385886-e50ba07b2c9bf55ce5c73dae2",
                            q: imageOf.toLowerCase(),
                            category: "food"
                        },
                        imageID: imageID,
                        success: function (result) {
                            var images = result.hits;
                            if (images.length > 0) {
                                console.log(imageID);
                                $("#" + imageID).attr("src", images[0].webformatURL);
                                // console.log(images[0].webformatURL)
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $("#ordering-footer").click(function () {
                $("#ordering-form").submit();
            });

            // automatically opening first foods
            // $(".collapsable:first").addClass("active");
            $(".collapsable:first").click();
        });

    $("#instructions-unhider").click(function () {
        $("#instructions").removeAttr("hidden");
        window.scrollTo(0, 0);
    });
});
