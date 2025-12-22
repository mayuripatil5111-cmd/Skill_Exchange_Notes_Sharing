<?php
include 'includes/connection.php';
include 'includes/adminheader.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];
?>

<div id="wrapper">
<?php include 'includes/adminnav.php'; ?>

<div id="page-wrapper">
<div class="container-fluid">

<h2 class="page-header">📥 Inbox</h2>

<?php
$query = "SELECT sender, MAX(sent_at) AS last_msg 
          FROM messages 
          WHERE receiver='$user'
          GROUP BY sender
          ORDER BY last_msg DESC";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p>No messages yet.</p>";
}

while ($row = mysqli_fetch_assoc($result)) {
    $sender = $row['sender'];
    echo "
    <div class='panel panel-default'>
        <div class='panel-body'>
            <b>$sender</b>
            <a href='chat.php?user=$sender' class='btn btn-sm btn-primary pull-right'>
                Open Chat
            </a>
        </div>
    </div>";
}
?>

</div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
