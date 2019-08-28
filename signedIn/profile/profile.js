$(document).ready(function () {
    // for personal data changes
    // $("#personalDataChange div input").focus(function() {
    //     $("#submitPersonalDataChange").prop("disabled", false);
    // });

    $("#personalDataChange div input").keyup(function () {
        var isValid = true;

        // $("#personalDataChange div input").each(function() {
        //     if ($(this).val().length == 0) {
        //         isValid = false;
        //     }
        // });

        var name = $("#name").val();
        if ((name.match(/ /g) || []).length == 1) {
            $("#nameError").attr("hidden", true);
        } else {
            $("#nameError").attr("hidden", false);
            isValid = false;
        }

        var studentID = $("#studentId").val();
        if (/^\d+$/.test(studentID)) {
            $("#studentIDError").attr("hidden", true);
        } else {
            $("#studentIDError").attr("hidden", false);
            isValid = false;
        }

        var email = $("#email").val();
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test(email)) {
            $("#emailError").attr("hidden", true);
        } else {
            $("#emailError").attr("hidden", false);
            isValid = false;
        }

        var password = $("#password").val();
        if (password) {
            $("#dataChange-passwordError").attr("hidden", true);
        } else {
            $("#dataChange-passwordError").attr("hidden", false);
            isValid = false;
        }

        if (isValid) {
            // removes error text and enables the button
            // $("#dataChangeInvalidity").attr("hidden", true);
            $("#submitPersonalDataChange").prop("disabled", false);
        } else {
            // adds error text and disables the button
            // $("#dataChangeInvalidity").attr("hidden", false);
            $("#submitPersonalDataChange").prop("disabled", true);
        }
    });


    $("#changePassword div input").keyup(function () {
        var isValid = true;
        $("#changePassword div input").each(function () {
            if ($(this).val().length == 0) {
                isValid = false;
            }
        });

        if (isValid) {
            $("#invalidity").attr("hidden", true);
        } else {
            $("#invalidity").attr("hidden", false);
        }

        if ($("#npwd").val() == $("#rpwd").val()) {
            $("#samePassword").attr("hidden", true);
        } else {
            $("#samePassword").attr("hidden", false);
        }

        if (isValid && ($("#npwd").val() == $("#rpwd").val())) {
            $("#submitPasswordChange").prop("disabled", false);
        } else {
            $("#submitPasswordChange").prop("disabled", true);
        }
        ;
    });
});
