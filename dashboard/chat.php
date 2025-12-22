<?php
include 'includes/connection.php';
include 'includes/adminheader.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$me = $_SESSION['username'];
$other = $_GET['user'];
?>

<div id="wrapper">
<?php include 'includes/adminnav.php'; ?>

<div id="page-wrapper">
<div class="container-fluid">

<h3 class="page-header">💬 Chat with <?php echo $other; ?></h3>

<div style="border:1px solid #ddd; padding:15px; height:350px; overflow-y:scroll; background:#f9f9f9;">

<?php
$query = "SELECT * FROM messages 
          WHERE (sender='$me' AND receiver='$other') 
             OR (sender='$other' AND receiver='$me')
          ORDER BY sent_at ASC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['sender'] == $me) {
        echo "<p style='text-align:right;'>
        <span class='label label-primary'>You</span><br>
        {$row['message']}
        </p>";
    } else {
        echo "<p>
        <span class='label label-success'>{$row['sender']}</span><br>
        {$row['message']}
        </p>";
    }
}
?>

</div>

<br>

<form method="POST">
<textarea name="msg" class="form-control" placeholder="Type your message..." required></textarea>
<br>
<button name="send" class="btn btn-success">Send</button>
</form>

<?php
if (isset($_POST['send'])) {
    $msg = mysqli_real_escape_string($conn, $_POST['msg']);
    mysqli_query($conn, "INSERT INTO messages (sender, receiver, message)
                          VALUES ('$me', '$other', '$msg')");
    header("Location: chat.php?user=$other"); // reload chat
}
?>

</div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
