<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
$theFileName = $_FILES['userfile']['name'];//'name' = original name of the  uploaded file
//$uploaddir = 'uploads/';
//$uploadfile = basename($_FILES['userfile']['name']);

echo '<pre>';
// move the file temp_name=phpjIEZV3 saved in /var/tmp/phpjIEZV3
// to current directory and save as $theFileName
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $theFileName)) {
    echo "File ".$theFileName." was successfully uploaded.\n";
} else {
    echo "Failed to upload file :( \n";
}

//echo 'Here is some more debugging info:';
//print_r($_FILES);

// compile the answer.exe file
// timeout 1 stops compiling after 1 second
exec("timeout 1 g++ ".$theFileName." -o answer.exe");
echo "<br>timeout 1 g++ ".$theFileName." -o answer.exe <br><br>";
// get the text from the text box for each test case
// put the text into variables
// The test cases will be saved to file and then 
// those files will be fed as input into 
// the executables ./exe < inputfile.txt
$testCase1 = $_POST['TestCase1'];
$testCase2 = $_POST['TestCase2'];
$testCase3 = $_POST['TestCase3'];
// get the instructorID and instructorPass
//$instructorID = $_POST['instructorID'];
//$instructorPass = $_POST['instructorPass'];
//echo "instructorID = ".$instructorID."<br>";
//echo "instructorPass = ".$instructorPass."<br>";
// show the variables in the browser
echo "Test Case1: <b>".$testCase1."</b><br>";
echo "Test Case2: <b>".$testCase2."</b><br>";
echo "Test Case3: <b>".$testCase3."</b><br><br>";
// write the testCases to Files
// each test file will be used for one sample program run
$command1 = "echo ".$testCase1." > TestCase1.txt";
$command2 = "echo ".$testCase2." > TestCase2.txt";
$command3 = "echo ".$testCase3." > TestCase3.txt";
// run the commands on the server
exec($command1);
exec($command2);
exec($command3);
// shows the commands and the files that they make in the browser
echo $command1."<br>";
echo "<b>TestCase1.txt:</b>";
echo file_get_contents('TestCase1.txt')."<br>";
echo $command2."<br>";
echo "<b>TestCase2.txt:</b>";
echo file_get_contents('TestCase2.txt')."<br>";
echo $command3."<br>";
echo "<b>TestCase3.txt:</b>";
echo file_get_contents('TestCase3.txt')."<br>";

// use the TestCase1.txt, TestCase2.txt,
// and  TestCase3.txt as user input for answer.exe
// save the output for each Test Case run into testOutputFile#.txt
// timeout 1 makes ./answer.exe run for only 1 second(in case of endless loop)
$command1b = "timeout 1 ./answer.exe < TestCase1.txt > testRunCase1Answer.txt";
echo $command1b."<br>"; // show command in browser
exec($command1b); // run command on server
echo "<b>testRunCase1Answer.txt:</b><br>";
echo file_get_contents('testRunCase1Answer.txt')."<br>";

$command2b = "timeout 1 ./answer.exe < TestCase2.txt > testRunCase2Answer.txt";
echo $command2b."<br>"; // show command in browser
exec($command2b); // run command on server
echo "<b>testRunCase2Answer.txt:</b><br>";
echo file_get_contents('testRunCase2Answer.txt')."<br>";

$command3b = "timeout 1 ./answer.exe < TestCase3.txt > testRunCase3Answer.txt";
echo $command3b."<br>"; // show command in browser
exec($command3b); // run command on server
echo "<b>testRunCase3Answer.txt:</b><br>";
echo file_get_contents('testRunCase3Answer.txt')."<br>";

//grep for lines that have @@@ and make into lines.txt
$commandGetLines = "grep -n '@@@' $theFileName |cut -f1 -d: > lines.txt";
exec($commandGetLines);
echo "Lines for blanks recorded!<br>";
exec ("rm original.cpp answer.exe");
echo "rm original.cpp answer.exe <br>";
print "</pre>";
?>
