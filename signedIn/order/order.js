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
    $.getJSON("assets/foodsData.json", function (data) {
        foods = data["foods"];
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

            // var cardTemplate = `
            // <div class="card" id="${id}-card">
            //     <div class="card-header" id="${id}-headers">
            //         <button class="btn btn-outline-dark collapsable" type="button" data-toggle="collapse" data-target="#${id}-body" aria-expanded="false" aria-controls="${id}-body">
            //             <div class="row">
            //                 <div class="col-6 text-left">
            //                     ${name}
            //                 </div>
            //                 <div class="col-6 text-right">
            //                     $${cost} &times
            //                     <input id="${id}-counter" type="number" class="counter" value="0" cost="${cost}" ${max} readonly>
            //                 </div>
            //             </div>
            //         </button>
            //     </div>
            //     <div id="${id}-body" class="collapse" aria-labelledby="${id}-headers" data-parent="#food-cards-container">
            //         <div class="row no-gutters">
            //             <div class="col-4">
            //                 <img id="${id}-image" src="${image}" class="card-img food-card-image" alt="Image not found." imageOf="${name}">
            //             </div>
            //             <div class="col-4">
            //                 <div id="${id}-cost" class="card-body align-middle text-center">
            //                     0.00
            //                 </div>
            //             </div>
            //             <div class="col-4 food-counter-buttons">
            //                 <button type="button" class="btn btn-outline-secondary counter-buttons plus" name="plus" for="${id}" id="${id}-plus">
            //                     <i class="fa fa-plus"></i>
            //                 </button>
            //                 <button type="button" class="btn btn-outline-secondary counter-buttons minus" name="minus" for="${id}" id="${id}-minus" disabled>
            //                     <i class="fa fa-minus"></i>
            //                 </button>
            //                 <p id="${id}-max-warning" class="text-danger max-food-warning" hidden>You have the reached the maximum amount of purchasable food.</p>
            //             </div>
            //         </div>
            //     </div>
            // </div>
            // `; // from cardTemplate.html

            var cardTemplate = `
                    <div id="${id}-card" class="row food-item">
                        <div class="col-3 d-flex">
                            <img src="${image}" alt="" class="food-image" align="middle">
                        </div>
                        <div class="col-3 text-left d-flex">
                            <div class="align-self-center food-name">
                                ${name}</br>
                                $${cost}
                            </div>
                        </div>
                        </div>
                        <div class="col-4 d-flex">
                            <div class="d-flex align-self-center text-center">
                                <div class="align-self-center">
                                    <button id="${id}-minus" class="minus counter-buttons btn btn-outline-light" for="${id}" disabled><i class="fas fa-minus"></i></button>
                                </div>
                                <button id="${id}-plus" class="plus counter-buttons btn btn-light mr-2" for="${id}"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-2 text-left d-flex">
                            <div class="align-self-center food-name d-flex">
                                <div class="align-self-center mr-1">&times;</div>
                                <div class="display-4 quantity d-flex">
                                    <div class="d-flex align-self-center">
                                        <input id="${id}-counter" type="number" class="counter" value="0" cost="${cost}" ${max} disabled>
</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            // console.log(cardTemplate)

            
            $(cardTemplate).insertBefore("#instructions-unhider-container");
            // console.log(cardTemplate);
        });
    })
        .fail(function () {
            $("#food-cards-container").html(`
            <p class="text-danger">
                An error has occured. Please refresh the page or contact and an administrator.
            </p>
        `);
        })
        .done(function () {
            // adding images
            // $("img").each(function () {
            //     // console.log($(this).attr("src"));
            //     if (!$(this).attr("src")) {
            //         var imageOf = $(this).attr("imageOf");
            //         var imageID = $(this).attr("id");
            //         // console.log(imageOf.toLowerCase());
            //
            //         //get image ajax call
            //         var pixabayAPI = "https://pixabay.com/api/";
            //
            //         $.ajax(pixabayAPI, {
            //             method: "GET",
            //             dataType: "json",
            //             data: {
            //                 key: "12385886-e50ba07b2c9bf55ce5c73dae2",
            //                 q: imageOf.toLowerCase(),
            //                 category: "food"
            //             },
            //             success: function (result, status, jqXHR) {
            //                 var images = result.hits;
            //                 if (images.length > 0) {
            //                     $("#" + imageID).attr("src", images[0].webformatURL);
            //                 }
            //                 ;
            //             },
            //             error: function (e) {
            //                 console.log(e);
            //             }
            //         });
            //     }
            // });

            // set event handler for button presses
            $(".counter-buttons").click(function () {
                const doAdd = $(this).hasClass("plus");
                const targetFood = $(this).attr("for");
                const targetCounter = $("#" + targetFood + "-counter");
                const foodCost = targetCounter.attr("cost"); // cost of the food
                const targetCost = $("#" + targetFood + "-cost");
                var value = parseInt(targetCounter.val());

                if (doAdd) {
                    targetCounter.val(value + 1);
                    value++;
                } else {
                    targetCounter.val(value - 1);
                    value--;
                }

                // value rounded to two decimal
                targetCost.html(parseFloat(Math.round(value * foodCost * 100) / 100).toFixed(2));

                //disabling buttons
                const addButton = $("#" + targetFood + "-plus");
                const subtractButton = $("#" + targetFood + "-minus");
                const maxFoodWarning = $("#" + targetFood + "-max-warning");
                const maxCount = targetCounter.attr("max");

                if (targetCounter.val() <= 0) {
                    // deactivates subtract button
                    subtractButton.attr("disabled", true);
                } else {
                    //activates subtract button
                    subtractButton.attr("disabled", false);
                }

                if (maxCount > 0) {
                    if (targetCounter.val() >= maxCount) {
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
                    var count = parseInt($("#" + id + "-counter").val());
                    totalCost += cost * count;
                    console.log(cost);

                    if (cost) {
                        var count = $("#" + id + "-counter").val();
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
