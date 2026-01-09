
<!-- db.php  -->
<?php
$conn = new mysqli("localhost", "root", "", "crud_db");

if ($conn->connect_error) {
    die("Connection failed");
}
?>

<!-- ///////////////add.php////////////////// -->

<?php
include "db.php";

if (isset($_POST['submit'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, email) VALUES ('$name','$email')";
    $conn->query($sql);

    header("Location: index.php");
}
?>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    <button name="submit">Add</button>
</form>

<!-- ////////////////////////////////index.php//////////////////////////////// -->
 <?php
include "db.php";
$result = $conn->query("SELECT * FROM users");
?>

<a href="add.php">➕ Add New</a><br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id'] ?>">✏ Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" 
           onclick="return confirm('Delete?')">❌ Delete</a>
    </td>
</tr>
<?php } ?>
</table>


<!-- ///////////////////////////////////edit.php////////////////////////////////////////////// -->


<?php
include "db.php";

$id = $_GET['id'];

if (isset($_POST['update'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    header("Location: index.php");
}

$data = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<form method="POST">
    Name: <input type="text" name="name" value="<?= $data['name'] ?>"><br><br>
    Email: <input type="email" name="email" value="<?= $data['email'] ?>"><br><br>
    <button name="update">Update</button>
</form>

<!-- /////////////////////////////////////delete.php ///////////////////////////////// -->

<?php
include "db.php";

$id = $_GET['id'];

$conn->query("DELETE FROM users WHERE id=$id");

header("Location: index.php");
?>





<!-- //////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////// -->


<!-- ////////////////db.php/////////////////////// -->
<?php
$conn = mysqli_connect("localhost", "root", "", "datas");
if (!$conn) {
    die("Database connection failed");
}
session_start();
?>

<!-- ////////////////////////////register.php///////////////////////////// -->
<?php
include "db.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn,
        "INSERT INTO users (username,password)
         VALUES ('$username','$password')");

    header("Location: login.php");
}
?>

<h3>Register</h3>

<form method="post">
    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <button name="register">Register</button>
</form>

<a href="login.php">Login</a>


<!-- //////////////////////////////////////login.php//////////////////////////////////////////// -->
<?php
include "db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,
        "SELECT * FROM users
         WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($check) == 1) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
    } else {
        echo "Wrong username or password";
    }
}
?>

<h3>Login</h3>

<form method="post">
    Username:
    <input type="text" name="username" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <button name="login">Login</button>
</form>

<a href="register.php">Register</a>

<!-- ////////////////////////////////////////////index.php//////////////////////////////////////////// -->
<?php
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>

<h2>Welcome <?= $_SESSION['user'] ?></h2>

<a href="logout.php">Logout</a>

<!-- /////////////////////////////////logout.php///////////////////////////////////////// -->
<?php
session_start();
session_destroy();
header("Location: login.php");
?>
