<h2 class="button-menu text-center mb-0 ">
    <a href="/login" class="btn btn-outline-dark header-form-buttons">
        <i class="fas fa-sign-in-alt"></i>&nbsp;Login
    </a>
    <br/>
    <a href="/signup" class="btn btn-outline-dark header-form-buttons text-primary">
        <i class="fas fa-user-plus"></i>&nbsp;Sign up
    </a>
</h2>

<!-- <form class="form-inline my-2 my-lg-0 float-right" action="/myattendance.ca/library/formActions/login.php" method="POST">
    <input id="signin_fingerprint" type="text" name="fingerprint" hidden>
    <input id="signin_email" class="form-control mr-sm-2" thiddenhiddenype="text" placeholder="Email" name="email">
    <input id="signin_password" class="form-control mr-sm-2" type="password" placeholder="Password" name="password" autocomplete="current-password">
    <button id="login" class="btn btn-outline-primary mr-sm-2" type="submit" disabled>Login</button>
    <a class="btn btn-primary my-2 my-sm-0 l-3" href="signup">Sign Up</a>
</form>

<script>
    $(document).ready(function() {
        var fingerprint = $("#fingerprint");
        setTimeout(function () {
            Fingerprint2.get(function (components) {
                var values = components.map(function (component) { return component.value });
                var murmur = Fingerprint2.x64hash128(values.join(''), 31);
                fingerprint.val(murmur);
                console.log(fingerprint.val());
            })
        }, 200);

        var email = $("#email");
        var password = $("#password");
        var login = $("#login");

        var checkValidity = function() {
            var formIsValid = fingerprint.val() && email.val() && password.val();
            if (formIsValid) {
                login.prop("disabled", false); //enabling
            } else {
                login.prop("disabled", true);
            }
        }

        email.keyup(checkValidity);
        password.keyup(checkValidity);
    });
</script>
 -->
