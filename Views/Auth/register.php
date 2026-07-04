<?php
session_start();
?>

<?php include "../../Includes/header.php"; ?>

<div class="auth-container">

<div class="auth-card">

<div class="logo">
StudyFlow
</div>

<div class="subtitle">

Create your account

</div>


<?php
if(isset($_SESSION['register_error'])){
?>
<div class="error-message">
    <?php
    echo $_SESSION['register_error'];
    unset($_SESSION['register_error']);
    ?>
</div>
<?php
}
?>

<form
action="../../Controllers/authController.php"
method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="fullname"
placeholder="Enter your full name">

</div>

<div class="input-group">

<label>Email</label>

<input
type="email"
name="email"
placeholder="Enter your email">

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Enter password">

</div>

<div class="input-group">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
placeholder="Confirm password">

</div>

<button type="submit" class="btn" name="register">
    Create Account
</button>

</form>

<div class="bottom-text">

Already have an account?

<a href="login.php">

Login

</a>

</div>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>