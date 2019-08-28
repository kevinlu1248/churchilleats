$(document).ready(function () {
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    // var submit = $("#submit");
    // var murmur = "";
    //
    // var validateUser = function() {
    //     var user = $('#user-input').val();
    //     re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //     if (re.test(String(user).toLowerCase())) {
    //         $("#validUser").hide();
    //     } else if (/^\d+$/.test(user) && user.length > 5 && user.length < 9) {
    //         $("#validUser").hide();
    //     } else {
    //         $("#validUser").show();
    //     }
    // }
    //
    // var checkPassword = function() {
    //   var pwd = $('#pwd').val();
    //   if (pwd) {
    //       $("#password-entered").hide();
    //   } else {
    //       $("#password-entered").show();
    //   }
    // }
    //
    // var checkValidity = function() {
    //     var formIsValid = $('#signup-holder .text-danger:visible').length == 0;
    //     if (formIsValid) {
    //         submit.prop("disabled", false);
    //     } else {
    //         submit.prop("disabled", true);
    //     }
    // }
    //
    // $('#user').keyup(validateUser);
    // $("#pwd").keyup(checkPassword);
    //
    // $(":input").keyup(checkValidity);

    // $("#pwd", "Password must be at 6-20 characters long and include letters and numbers").tooltip();

    setTimeout(function () {
        Fingerprint2.get(function (components) {
            var values = components.map(function (component) {
                return component.value
            });
            murmur = Fingerprint2.x64hash128(values.join(''), 31);
            $("#fingerprint").val(murmur);
            console.log($("#fingerprint").val());
        });
    });
});
