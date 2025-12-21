<?php 
include 'includes/connection.php';
include 'includes/adminheader.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("location: index.php");
    exit;
}
?>

<div id="wrapper">

<?php include 'includes/adminnav.php'; ?>

<div id="page-wrapper">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    UPLOAD Skill or NOTE
                </h1>

<?php
if (isset($_POST['upload'])) {

    require "../gump.class.php";
    $gump = new GUMP();
    $_POST = $gump->sanitize($_POST); 

    $gump->validation_rules(array(
        'title'       => 'required|max_len,60|min_len,3',
        'description' => 'required|max_len,150|min_len,3',
    ));
    $gump->filter_rules(array(
        'title'       => 'trim|sanitize_string',
        'description' => 'trim|sanitize_string',
    ));

    $validated_data = $gump->run($_POST);

    if ($validated_data === false) {
        echo '<center><font color="red">' . $gump->get_readable_errors(true) . '</font></center>';
        $file_title = $_POST['title'];
        $file_description = $_POST['description'];
    } else {
        $file_title = $validated_data['title'];
        $file_description = $validated_data['description'];

        if (isset($_SESSION['id'])) {
            $file_uploader   = $_SESSION['username'];
            $file_uploaded_to = $_SESSION['course'];
        }

        // File upload handling
        $file = $_FILES['file']['name'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $validExt = array('pdf', 'txt', 'doc', 'docx', 'ppt', 'zip', 'mp4');

        if (empty($file)) {
            echo "<script>alert('Please attach a file');</script>";
        } else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000) {
            echo "<script>alert('File size is not proper. Maximum allowed: 30 MB');</script>";
        } else if (!in_array($ext, $validExt)) {
            echo "<script>alert('Not a valid file type');</script>";
        } else {
            $folder = 'allfiles/';
            $notefile = rand(1000, 1000000) . '.' . $ext;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $folder . $notefile)) {
                $query = "INSERT INTO uploads(file_name, file_description, file_type, file_uploader, file_uploaded_to, file) 
                          VALUES ('$file_title', '$file_description', '$ext', '$file_uploader', '$file_uploaded_to', '$notefile')";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                if (mysqli_affected_rows($conn) > 0) {
                    echo "<script>
                        alert('File uploaded successfully. It will be published after admin approval.');
                        window.location.href='notes.php';
                    </script>";
                } else {
                    echo "<script>alert('Error while uploading. Try again.');</script>";
                }
            } else {
                echo "<script>alert('Error moving uploaded file.');</script>";
            }
        }
    }
}
?>

<form role="form" action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Skill or Note Title</label>
        <input type="text" name="title" class="form-control" placeholder="Eg: Php Tutorial File" 
               value="<?php if(isset($file_title)) echo htmlspecialchars($file_title); ?>" required>
    </div>

    <div class="form-group">
        <label for="post_description">Short Note Description</label>
        <input type="text" name="description" class="form-control" placeholder="Eg: Php Tutorial File includes basic php programming ...." 
               value="<?php if(isset($file_description)) echo htmlspecialchars($file_description); ?>" required>
    </div>

    <div class="form-group">
        <label for="post_file">Select File</label>
        <font color="brown">(allowed file types: pdf, doc, docx, ppt, txt, zip, mp4 | max size: 30 MB)</font>
        <input type="file" name="file" required>
    </div>

    <button type="submit" name="upload" class="btn btn-primary">Upload Skill or Note</button>
    <br><br>
</form>

</div>
</div>
</div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
