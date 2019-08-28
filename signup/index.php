<?php
require_once '../includes/header.php';
?>

<?php
if ($user) {
    echo "<script>window.location.replace('http://localhost:8888/churchilleats');</script>";
}

$signup = $_GET['signup'];
if ($signup === "failure") {
    require_once "signupFailure.php";
} elseif ($signup === "duplicateError") {
    require_once "../banners/duplicateError.php";
}
?>

<div id="entry" class="p-5 m-x-3">
    <div class="row" id="signup-row-container">
        <div id="signup-holder" class="col-sm-4 d-inline-block signup-col text-light">
            <h1 class="text-center">Sign up</h1>
            <form id="signup" class="needs-validation" action="../library/formActions/signup.php" method="POST"
                  novalidate>
                <!-- <form id="signup" class="container text-center" action="../library/formActions/signup.php" method="POST"> -->
                <!-- Toggle Switch -->
                <label for="fingerprint"></label><input id="fingerprint" type="text" name="fingerprint" hidden>
                <div class="form-group">
                    <label for="name">First and Last Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-font"></i></div>
                        </div>
                        <input type="text" placeholder="First and last name" class="form-control input-box" id="name"
                               autocomplete="name" name="name" pattern="[a-zA-Z]+ [a-zA-Z]+" required>

                        <div class="invalid-feedback">
                            Please provide a valid full name.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Student ID</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fab fa-slack-hash"></i></div>
                        </div>
                        <input type="number" placeholder="6 to 8 digit student ID" class="form-control input-box"
                               min="100000" max="99999999" id="studentId" name="studentId" required>
                        <div class="invalid-feedback">
                            Student ID must be between 6 to 8 digits.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="far fa-envelope"></i></div>
                        </div>
                        <input type="email" placeholder="Enter a valid email" class="form-control input-box" id="email"
                               autocomplete="email" name="email" value="<?php echo $_GET["email"]; ?>" required>
                        <div class="invalid-feedback">
                            Please enter a valid email.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" placeholder="6 to 20 characters" class="form-control input-box"
                               minlength="6" maxlength="20" id="pwd" autocomplete="new-password" name="pwd" required>
                        <div class="invalid-feedback">
                            Please enter a password between 6 to 20 characters.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Retype Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-redo"></i></div>
                        </div>
                        <input type="password" placeholder="Retype your password" class="form-control input-box"
                               minlength="6" maxlength="20" id="rpwd" autocomplete="password" name="rpwd" required>
                        <div class="invalid-feedback">
                            Your passwords do not match.
                        </div>
                    </div>
                </div>
                <!-- <p class="text-danger" id="validPassword">Your password must be between 8-20 characters</p> -->
                <!-- <div class="form-group">
                    <label for="name">Repeat Password</label>
                    <input type="password" placeholder="Please repeat your password" class="form-control input-box" maxlength="20" id="rpwd" autocomplete="new-password" name="rpwd" required>
                    <div class="invalid-feedback">
                        Your passwords do not match.
                    </div>
                </div> -->
                <div class="text-center">
                    <label class="checkbox-inline form-group">
                        I am a teacher &nbsp
                        <input id="isTeacher" class="checkbox-inline" type="checkbox" name="isTeacher">
                    </label>
                    &nbsp | &nbsp
                    <label class="checkbox-inline form-group">
                        Remember me &nbsp
                        <input id="rememberMe" class="checkbox-inline" type="checkbox" name="rememberMe" checked>
                    </label>
                    <button id="submit" type="submit" class="btn btn-primary float-center">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="signup.js"></script>

<?php
require_once '../includes/footer.php';
?>
