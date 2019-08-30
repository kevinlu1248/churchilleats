$(document).ready(function () {
    function update() {
        $("#submit-location").attr("disabled", "");
        // if ($(this).attr("id") == "room-number") {
        //     var roomNumber = $(this).val();
        //     if (roomNumber.length == 3 && roomNumber[0] >= 1 && roomNumber[0] <= 3) {
        //         $(this).removeClass("is-invalid");
        //         $(this).addClass("is-valid");
        //         $("#submit-location").removeAttr("disabled");
        //     } else {
        //         $(this).removeClass("is-valid");
        //         $(this).addClass("is-invalid");
        //     }
        // } else {
        //     var description = $(this).val();
        //     console.log(description);
        //     console.log(Boolean(description));
        //     if (description) {
        //         $(this).removeClass("is-invalid");
        //         $(this).addClass("is-valid");
        //         $("#submit-location").removeAttr("disabled");
        //     } else {
        //         $(this).removeClass("is-valid");
        //         $(this).addClass("is-invalid");
        //     }
        // }

        var roomNumber = $("#room-number").val();
        if (roomNumber.length == 3 && roomNumber[0] >= 1 && roomNumber[0] <= 3) {
            $("#room-number").removeClass("is-invalid");
            $("#room-number").addClass("is-valid");
            $("#described-location").removeClass("is-invalid");
            $("#described-location").addClass("is-valid");
            $("#submit-location").removeAttr("disabled");
            return;
        } else {
            $("#room-number").removeClass("is-valid");
            $("#room-number").addClass("is-invalid");
        }

        var description = $("#described-location").val();
        console.log(description);
        console.log(Boolean(description));
        if (description) {
            $("#room-number").removeClass("is-invalid");
            $("#room-number").addClass("is-valid");
            $("#described-location").removeClass("is-invalid");
            $("#described-location").addClass("is-valid");
            $("#submit-location").removeAttr("disabled");
        } else {
            $("#described-location").removeClass("is-valid");
            $("#described-location").addClass("is-invalid");
        }
    };

    $("input").keyup(update);
    $("input").focus(update);
})
;
