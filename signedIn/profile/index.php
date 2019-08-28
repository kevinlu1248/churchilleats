<?php
require_once '../../includes/header.php';
?>

<?php
if (!$user) {
    echo "<script>window.location.replace('http://localhost:8888/churchilleats');</script>";
}

// $signup = $_GET['signup'];
// if ($signup === "failure") {
//     require_once "signupFailure.php";
// } elseif ($signup === "duplicateError") {
//     require_once "duplicateError.php";
// }
// unset($_GET['signup']);
?>

<script>
    <?php
    $test = print_r($_SESSION["user"], true);
    echo "console.log(`$test`);";
    ?>
</script>

<div id="entry" class="container p-5 m-x-3">
    <div class="row">
        <div id="editData" class="col-sm">
            <div id="editData-holder" class="row-4 text-white">
                <h3>
                    Personal Data Change
                </h3>
                <form id="personalDataChange" action="../../library/formActions/personalDataChange.php" method="POST">
                    <!-- <form id="signup" class="container text-center" action="../library/formActions/signup.php" method="POST"> -->
                    <div class="form-group">
                        <input type="text" placeholder="First and last name" class="form-control input-box" id="name"
                               autocomplete="name" name="name" value="<?php echo "$first $last"; ?>">
                    </div>
                    <p class="text-danger" id="nameError" hidden>Please enter your first and last name.</p>
                    <div class="form-group">
                        <input type="number" placeholder="Student ID" class="form-control input-box" min="100000"
                               max="99999999" id="studentId" name="studentId" value="<?php echo $user['studentID']; ?>">
                    </div>
                    <p class="text-danger" id="studentIDError" hidden>Please enter your first and last name.</p>
                    <div class="form-group">
                        <input type="email" placeholder="Email" class="form-control input-box" id="email" name="email"
                               value="<?php echo $user['email']; ?>">
                    </div>
                    <p class="text-danger" id="emailError" hidden>Please enter a valid email.</p>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control input-box" id="password"
                               name="password">
                    </div>
                    <p class="text-danger" id="dataChange-passwordError" hidden>Please enter your password.</p>
                    <button id="submitPersonalDataChange" type="submit" class="btn btn-primary" disabled>Change Personal
                        Data
                    </button>
                </form>
                </br>
                </br>
                <h3>
                    Password Change
                </h3>
                <form id="changePassword">
                    <div class="form-group" action="../library/formActions/passwordChange.php" method="POST">
                        <input type="password" placeholder="Current Password" class="form-control input-box"
                               maxlength="20" id="cpwd" autocomplete="current-password" name="cpwd">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="New Password" class="form-control input-box" maxlength="20"
                               id="npwd" autocomplete="new-password" name="npwd">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Repeat new password" class="form-control input-box"
                               maxlength="20" id="rpwd" autocomplete="new-password" name="rpwd">
                    </div>
                    <p class="text-danger" id="samePassword" hidden>Your passwords do not match</p>
                    <p class="text-danger" id="invalidity" hidden>Please complete all fields</p>
                    <button id="submitPasswordChange" type="submit" class="btn btn-primary" disabled>Change Password
                    </button>
                </form>
            </div>
        </div>

        <script src="profile.js"></script>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>
