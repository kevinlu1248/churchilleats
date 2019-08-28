<?php
require_once '../includes/header.php';
?>

<?php
if ($user) {
    echo "<script>window.location.replace('localhost');</script>";
}
// $signup = $_GET['signup'];
// if ($signup === "failure") {
//     require_once "signupFailure.php";
// } elseif ($signup === "duplicateError") {
//     require_once "duplicateError.php";
// }
// unset($_GET['signup']);
?>

<div id="entry" class="p-5 m-x-3">
    <div class="row" id="login-row">
        <div id="signup-holder" class="col-sm-4 d-inline-block signup-col float-center text-light">
            <h1 class="text-center mb-4">Login</h1>
            <form id="signup" action="/library/formActions/login.php" class="needs-validation" method="POST" novalidate>
                <!-- <form id="signup" class="container text-center" action="../library/formActions/signup.php" method="POST"> -->
                <!-- Toggle Switch -->
                <input id="fingerprint" type="text" name="fingerprint" hidden>
                <div class="form-group">
                    <label for="name">Student ID or email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-at"></i></div>
                        </div>
                        <input type="text" placeholder="Student ID or email" class="form-control input-box"
                               id="user-input" name="user"
                               pattern='^((\d{6,8})|(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})))$'
                               required>
                        <!-- ^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})|\d+)$ -->
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid student ID or email.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" placeholder="Password" class="form-control input-box" maxlength="20"
                               id="pwd" autocomplete="new-password" name="pwd" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please enter a password.
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <label class="checkbox-inline form-group text-center">
                        Remember me &nbsp
                        <input id="rememberMe" type="checkbox" name="rememberMe" checked>
                    </label>
                </div>
                <button id="submit" type="submit" class="btn btn-primary mt-3">Log in</button>
            </form>
        </div>
    </div>
</div>

<script src="login.js"></script>

<?php
require_once '../includes/footer.php';
?>
