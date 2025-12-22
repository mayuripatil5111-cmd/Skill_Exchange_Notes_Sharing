<?php include 'includes/connection.php'; ?>
<?php include 'includes/adminheader.php'; ?>

<?php 
// Admin should not upload
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("location: index.php");
    exit();
}
?>

<div id="wrapper">
<?php include 'includes/adminnav.php'; ?>

<div id="page-wrapper">
<div class="container-fluid">

<div class="row">
<div class="col-lg-12">
<h1 class="page-header">UPLOAD Skill or NOTE</h1>

<?php
if (isset($_POST['upload'])) {

    require "../gump.class.php";
    $gump = new GUMP();
    $_POST = $gump->sanitize($_POST);

    $gump->validation_rules([
        'title' => 'required|min_len,3|max_len,60',
        'description' => 'required|min_len,3|max_len,150',
    ]);

    $validated = $gump->run($_POST);

    if ($validated === false) {
        echo "<center style='color:red'>" . $gump->get_readable_errors(true) . "</center>";
    } else {

        $file_title = $validated['title'];
        $file_description = $validated['description'];
        $file_uploader = $_SESSION['username'];
        $file_uploaded_to = $_SESSION['course'];

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            echo "<script>alert('Please select a valid file');</script>";
        } else {

            $file = $_FILES['file'];
            $filename = $file['name'];
            $filesize = $file['size'];
            $tmp = $file['tmp_name'];

            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // ✅ Allowed extensions
            $allowedExt = ['pdf','doc','docx','ppt','txt','zip','mp4'];

            // ✅ 30MB limit
            if ($filesize > 31457280) {
                echo "<script>alert('File size must be less than 30MB');</script>";
            }
            elseif (!in_array($ext, $allowedExt)) {
                echo "<script>alert('Invalid file type');</script>";
            }
            else {

                $folder = 'allfiles/';
                $newname = uniqid() . '.' . $ext;

                if (move_uploaded_file($tmp, $folder.$newname)) {

                    $query = "INSERT INTO uploads
                    (file_name, file_description, file_type, file_uploader, file_uploaded_to, file)
                    VALUES
                    ('$file_title','$file_description','$ext','$file_uploader','$file_uploaded_to','$newname')";

                    if (mysqli_query($conn, $query)) {
                        echo "<script>
                        alert('File uploaded successfully. Awaiting admin approval.');
                        window.location.href='notes.php';
                        </script>";
                    } else {
                        echo "<script>alert('Database error');</script>";
                    }

                } else {
                    echo "<script>alert('Upload failed');</script>";
                }
            }
        }
    }
}
?>

<!-- ================= FORM ================= -->
<form id="uploadForm" method="POST" enctype="multipart/form-data">

<div class="form-group">
    <label>Skill or Note Title</label>
    <input type="text" name="title" class="form-control" required>
</div>

<div class="form-group">
    <label>Short Description</label>
    <input type="text" name="description" class="form-control" required>
</div>

<div class="form-group">
    <label>Select File</label>
    <p style="color:brown">
        Allowed: pdf, doc, docx, ppt, txt, zip, mp4 | Max: 30MB
    </p>
    <input type="file" name="file" class="form-control" id="fileInput" required>
</div>

<!-- VIDEO PREVIEW -->
<video id="videoPreview" controls style="display:none;width:100%;max-height:300px;margin-top:10px;"></video>

<button type="submit" name="upload" class="btn btn-primary">
    Upload Skill or Note
</button>

</form>

</div>
</div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- VIDEO PREVIEW SCRIPT -->
<script>
document.getElementById("fileInput").addEventListener("change", function () {
    const file = this.files[0];
    const video = document.getElementById("videoPreview");

    if (file && file.type === "video/mp4") {
        video.src = URL.createObjectURL(file);
        video.style.display = "block";
    } else {
        video.style.display = "none";
        video.src = "";
    }
});
</script>

</body>
</html>
