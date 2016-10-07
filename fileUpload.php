<?php
// In PHP versions earlier than 4.1.0, $
// HTTP_POST_FILES should be used instead
// of $_FILES.
$theFileName = $_FILES['userfile']['name'];//'name' = original name of the  uploaded file
//$uploaddir = 'uploads/';
//$uploadfile = basename($_FILES['userfile']['name']);

echo '<pre>';
// move the file temp_name=phpjIEZV3 saved in /var/tmp/phpjIEZV3
// to current directory and save as $theFileName
// if the file was uploaded successfully
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $theFileName)) 
{
    echo "The file ".$theFileName." was successfully uploaded! \n :)";
    sleep(2); // wait for 2 seconds
    header("Location: http://www.stoykov.us/phpStuff/sinead"); // Redirect browser
	exit();
}
else 
    echo "Failed to upload file :( \n";

echo '</pre>';
//echo 'Here is some more debugging info:';
//print_r($_FILES);

?>
