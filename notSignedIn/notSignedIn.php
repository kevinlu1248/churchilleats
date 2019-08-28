<div class="col float-center text-white" id="signup-container">
    <h1 id="signup-up-now" class="display-4">
        Sign up now!
    </h1>
    <form class="form-inline mb-2" action="/signup" method="GET">
        <div id="signup-email-container" class="input-group mr-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-envelope"></i></div>
            </div>
            <label class="sr-only" for="signup-email">Email</label>
            <input id="signup-email" type="email" placeholder="Email" class="form-control mr-1" name="email">
        </div>
        <button id="submit-email-signup" type="submit" class="btn btn-primary" href="signup" disabled>Sign up</button>
    </form>
    <h7 id="login-info-text" class="mute">
        or <a href="/login" id="">log in</a>.
    </h7>
</div>

<script>
    $(document).ready(function () {
        var submit = $("#submit-email-signup");
        $("#signup-email").keyup(function () {
            if ($("#signup-email").val()) {
                submit.removeAttr('disabled');
            }
        });

        // submit.click(function() {
        //     var val = $("#signup-email").val();
        //     var url = document.URL + "signup";
        //     window.location.replace(url);
        // });
    });
</script>

<!-- <div class="col-lg-12">
    <div id="title" class="col-12 d-inline-block text-center align-middle">
        <h1 id="title-text" class="text-primary">
            Sign up now!
        </h1>
        <input type="text" name="email" placeholder="Email" id="signup-email">
    </div>
</div>
 -->
