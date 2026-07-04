<?php include "../../Includes/header.php"; ?>

<div class="auth-container">

<div class="auth-card">

<div class="logo">
StudyFlow
</div>

<div class="subtitle">

Welcome Back

</div>

<?php
if(isset($_SESSION['login_error'])){
?>
<div class="error-message">
    <?php
    echo $_SESSION['login_error'];
    unset($_SESSION['login_error']);
    ?>
</div>
<?php
}
?>

<form action="../../Controllers/authController.php" method="POST">

<div class="input-group">

<label>Email</label>

<input
type="email"
name="email"
placeholder="Enter your email"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Enter your password"
required>

</div>

<button
type="submit"
class="btn"
name="login">

Login

</button>

</form>

<div class="bottom-text">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>