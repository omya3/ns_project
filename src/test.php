<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    
echo 'Temp File: ' . $_FILES['profile_image']['tmp_name'] . '<br>';
echo 'Temp File Owner: ' . fileowner($_FILES['profile_image']['tmp_name']) . '<br>';
echo 'Temp File Group: ' . filegroup($_FILES['profile_image']['tmp_name']) . '<br>';
echo 'Temp File Permissions: ' . substr(sprintf('%o', fileperms($_FILES['profile_image']['tmp_name'])), -4) . '<br>';

$upload_dir = '/opt/lampp/htdocs/ns_project/src/uploads/';
echo 'Upload Directory: ' . $upload_dir . '<br>';
echo 'Upload Directory Owner: ' . fileowner($upload_dir) . '<br>';
echo 'Upload Directory Group: ' . filegroup($upload_dir) . '<br>';
echo 'Upload Directory Permissions: ' . substr(sprintf('%o', fileperms($upload_dir)), -4) . '<br>';

if (is_writable($upload_dir)) {
    echo "Upload directory is writable.<br>";
} else {
    echo "Upload directory is NOT writable.<br>";
}

    $upload_dir = '/opt/lampp/htdocs/ns_project/src/uploads/';
    $image_path = $upload_dir . basename($_FILES['profile_image']['name']);
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path)) {
        echo "Image uploaded successfully!";
    } else {
        echo "Image upload failed.";
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_image">
    <button type="submit">Upload</button>
</form>
