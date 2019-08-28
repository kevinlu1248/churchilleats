$(document).ready(function () {
    $("input").keyup(function () {
        if ($(this).attr("id") == "room-number") {
            var roomNumber = $(this).val();
            if (roomNumber.length == 3 && roomNumber[0] >= 1 && roomNumber[0] <= 3) {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                $("#submit-location").removeAttr("disabled");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $("#submit-location").attr("disabled", "");
            }
        } else {
            var description = $(this).val();
            console.log(description);
            console.log(Boolean(description));
            if (description) {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                $("#submit-location").removeAttr("disabled");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $("#submit-location").attr("disabled", "");
            }
        }
    });
});
