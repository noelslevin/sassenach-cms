<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

?>

<?php

// File specific variables go here.

$pagetitle="Files";

?>

<?php include '../../includes/variables.php'; ?>
<?php include '../../includes/connection.php'; ?>
<?php include '../includes/header.php'; ?>

<h1>Files</h1>

<?php

    if (isset($_POST['Upload File'])); {

    $title = $_POST['title'];
    $title = addslashes($title);
    $description = $_POST['description'];
    $description = addslashes($description);

$date = date(Y). "/". date(m). "/";

$path1 = "../../".$uploads;
$path2 = basename($_FILES['uploadedfile']['name']);

$path2 = strtolower($path2);
$path2 = str_replace(" ", "-", $path2);
$path2 = str_replace("'", "", $path2);
$path2 = ereg_replace("[^A-Za-z0-9-][.]", "", $path2);

$url = $date.$path2;

$target_path = $path1.$url;
$size = ($_FILES['uploadedfile']['size']);
$size = $size / 1024;

if ($size > 1024) {

    $size = $size / 1024;
    $size = number_format($size, 2, '.', ',');
    $size .= " Mb";

}

else {
    $size = number_format($size, 0);
    $size .= " Kb";
}

$type = ($_FILES['uploadedfile']['type']);

if (!is_dir('../../'.$uploads.$date)) {

    mkdir('../../'.$uploads.$date, 0777, true);

}

if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

        echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been successfully uploaded.";

        $uploadquery = "INSERT INTO files (title, description, type, url, filesize) VALUES ('$title', '$description', '$type', '$url', '$size')";
        $uploadresult = mysql_query($uploadquery);
        if ($uploadresult) {
        
            echo "<p>The file was added to the uploads database.</p>";
        
        }
        
        else {
        
            echo "<p>The file was not added to the uploads database. The file is on the server but will not appear in this application. If this is the first time this has happened, just try uploading again.</p>";
        
        }
}

else{

    echo "There was an error uploading the file, please try again!";

}

}

?>

<?php include '../includes/footer.php'; ?>
