$(document).ready(function () {
    console.log("automatic login initiated");
    setTimeout(function () {
        Fingerprint2.get(function (components) {
            var values = components.map(function (component) {
                return component.value
            });
            var murmur = Fingerprint2.x64hash128(values.join(''), 31);
            $.ajax({
                method: "POST",
                url: "/churchilleats/library/formActions/autoLogin.php",
                data: {fingerprint: murmur},
                error: function (a, b, error) {
                    console.log(error);
                }
            })
                .done(function (result) {
                    console.log(result);
                    if (result == "1") {
                        location.reload();
                    }
                })
        })
    }, 200);
});
