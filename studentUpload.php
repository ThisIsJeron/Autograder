<?php
$studentID = $_POST['studentID'];
$studentPass = isset($_POST['studentPass']) ? $_POST['studentPass'] : ''; //http://stackoverflow.com/q/4261133
$studentIDs = file_get_contents('IDs.cgi');
$studentsPassed = file_get_contents("TheStudentsThatPassedTheCSS1Sp16FinalExam.cgi");

// if id was not found in the file with IDs
// go back to form that tells "invalid ID"
if ( foundID("IDs.cgi",$studentID) == "false")
  header('Location: invalidIDPage.html');

// if the student has already taken the test
// go back to form that tells "already submitted"
else if (foundID("TheStudentsThatPassedTheCSS1Sp16FinalExam.cgi",$studentID) == "true")
     header('Location: studentAlreadySubmitted.html'); 

else
{
        echo "ID $studentID was found<br>";
	/*
	// if id was not found in the file with IDs
	// go back to form that tells "invalid ID"
	if (strpos($studentIDs, $studentID) == false) 
	   header('Location: invalidIDPage.html');

	// if the student has already taken the test
	// go back to form that tells "already submitted"
	else if (strpos($studentsPassed, $studentID) == true)
	     header('Location: studentAlreadySubmitted.html'); 

	else
	   echo "ID $studentID was found<br>";
	*/
	$theFileName = $_FILES['userfile']['name'];// original file name of uploaded file

	echo '<pre>';
	// move the file temp_name=phpjIEZV3 saved in /var/tmp/phpjIEZV3
	// to the current directory and save as $theFileName
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $theFileName)) 
	    echo "<br>File <b>".$theFileName."</b> is valid, and was uploaded.\n";
	else {
        echo "Problem uploading the file :(! Are you sure you uploaded the file?\n";
        echo "<button onclick=\"goBack()\">Go Back</button>    
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>"; //WOAH YOU CAN PUT HTML IN PHP AND JUST ECHO IT?
    }
	// compile the student.exe file, and create StudentTestOutputFile1.txt
	compileAndRun();

	// compare the differences between testRunCase1Answer.txt and StudentTestOutputFile1.txt
	// send results of comparison to test1Differences.txt
	compareDifferences();

	// now read the test1Differences.txt contents and show them
	showDifferences();

	// show student test run next to expected test run
	showTestRuns();

	// record test differences
	recordDifferences($studentID);
}
function recordDifferences($studentID)
{
	$differences1 = file_get_contents('testRunCase1Differences.txt');
	if (strlen($differences1) == 0) // if there are no differences
	{ 
	    $studentIDs = file ( "IDs.cgi"); // file (" ") returns an array of lines
		$arrlength = count($studentIDs);
		//echo "Supposed to be here only if there are no differences <br>";
		//echo "<br>The number of lines in the IDs.cgi: ".$arrlength."<br>";
		for ($i = 0; $i < $arrlength; $i++) 
		{
		   // echo "studentIDs[i]=".$studentIDs[$i]."<br>";
		   //if ($studentID."\n" == $studentIDs[$i]) // ?? whhy didn't this work??? it was missing ."\n"
		   // if (foundID("TheStudentsThatPassedTheCSS1Sp16FinalExam.cgi",$studentID) == "false")
		    if (strpos($studentIDs[$i], $studentID) )
		    {
		      //"SOMEHOW IT GOT HERE???<br>"; 
		      echo "Congratulations, your program works 100% and your test has been recorded<br>";  
		      $myfile = fopen("TheStudentsThatPassedTheCSS1Sp16FinalExam.cgi", "a");
		      $txt = "$studentIDs[$i]";
		      fwrite($myfile, $txt);
		      fclose($myfile);
		      break;
		    }
		}
	}
}
// remove all the files used to clean up the server 
cleanup();

print "</pre>";

function showTestRuns(){
    // show testRunCase1Answer.txt
    echo "<hr>";
    echo "<b>Expected Test Run 1: </b> <br>";
    echo file_get_contents('testRunCase1Answer.txt')."<br>";
    // show StudentTestOutputFile1.txt
    echo "<b>Your Test Run 1: </b> <br>";
    echo file_get_contents('StudentTestOutputFile1.txt')."<br>";
    echo "<hr>";
    echo "<b>Expected Test Run 2: </b> <br>";
    echo file_get_contents('testRunCase2Answer.txt')."<br>";
    // show StudentTestOutputFile1.txt
    echo "<b>Your Test Run 2: </b> <br>";
    echo file_get_contents('StudentTestOutputFile2.txt')."<br>";
    echo "<hr>";
    echo "<b>Expected Test Run 3: </b> <br>";
    echo file_get_contents('testRunCase3Answer.txt')."<br>";
    // show StudentTestOutputFile1.txt
    echo "<b>Your Test Run 3: </b> <br>";
    echo file_get_contents('StudentTestOutputFile3.txt')."<br>";
    echo "<hr>";
}

function showDifferences()
{
    $differences1 = file_get_contents('testRunCase1Differences.txt');
    $differences2 = file_get_contents('testRunCase2Differences.txt');
    $differences3 = file_get_contents('testRunCase3Differences.txt');
    if (strlen($differences1) != 0 || strlen($differences2) != 0 || strlen($differences3) != 0) // if there are differences
    {
        echo "<table border=1>";
        echo "<tr><td align=\"center\"><b>Test Run Differences:</b></td></tr>";
        echo "<tr><td><b>&lt;</b> means \"<b>expected answer</b>\"</td></tr><br>";
        echo "<tr><td><b>&gt;</b> means \"<b>found in your program</b>\"</td></tr><br>";
        echo "</table>";
  }

  else
    echo "CONGRATULATIONS! Your test run matches the expected 100%<br>";
  /*
  //echo $differences1."<br>";
  if (strlen($differences1) == 0) // if there are no differences
  {
      echo "<br>Congratulations, your program is 100% correct<br>";
      $myfile = fopen("studentScores.cgi", "a");
      $txt = "$studentID passed\n";
      fwrite($myfile, $txt);
      fclose($myfile);
  }
  */
  echo "<br>";

  if (strlen($differences1) != 0)
     echo "test case 1: <br>";
      echo $differences1."<br>";
    if (strlen($differences2) != 0)
        echo "test case 2: <br>";
        echo $differences2."<br>";
    if (strlen($differences3) != 0)
        echo "test case 3: <br>";
        echo $differences3."<br>";
}

function compareDifferences()
{
  echo "<b><br>Comparing Student Test Run with Test Run Answer </b> <br>";
  $command4 = "diff testRunCase1Answer.txt StudentTestOutputFile1.txt > testRunCase1Differences.txt";
  //echo $command4."<br>";
  exec ($command4);

  $command5 = "diff testRunCase2Answer.txt StudentTestOutputFile2.txt > testRunCase2Differences.txt";
  //echo $command5."<br>";
  exec ($command5);

  $command6 = "diff testRunCase3Answer.txt StudentTestOutputFile3.txt > testRunCase3Differences.txt";
  //echo $command6."<br>";
  exec ($command6);
  echo "<hr>";
}

function compileAndRun()
{
  $theFileName = $_FILES['userfile']['name'];
  // compile the student.exe file
  exec("timeout 1 g++ ".$theFileName." -o student.exe");
  echo "<br><b>Compiling the student file</b><br>";
  //echo "timeout 1 g++ ".$theFileName." -o student.exe<br>";

  // feed the TestCase#.txt files into the program and make
  // testOutputFile#.txt to save each testCase run
  $command1b = "timeout 1 ./student.exe < TestCase1.txt > StudentTestOutputFile1.txt";
  echo "<br><b>Running the student file</b><br>";
  //echo $command1b."<br>"; // show command in browser
  exec($command1b); // run command on server

  $command2b = "timeout 1 ./student.exe < TestCase2.txt > StudentTestOutputFile2.txt";
  //echo $command2b."<br>"; // show command in browser
  exec($command2b); // run command on server

  $command3b = "timeout 1 ./student.exe < TestCase3.txt > StudentTestOutputFile3.txt";
  //echo $command3b."<br>"; // show command in browser
  exec($command3b); // run command on server
}

function cleanup()
{
  $command7 = "rm testRunCase1Differences.txt testRunCase2Differences.txt testRunCase3Differences.txt";
  $command8 = "rm StudentTestOutputFile1.txt StudentTestOutputFile2.txt StudentTestOutputFile3.txt";
  $command9 = "rm student.exe student.cpp";
  echo "<br>Cleaning up the files on the server... <br>Report complete!";
  // echo $command7."<br>";
  // echo $command8."<br>";
  // echo $command9."<br>";
  exec ($command7);
  exec ($command8);
  exec ($command9);
}

function foundID($fileName, $studID)
{
        //echo "fileName: $fileName  , studentID: $studID <br>";
        $lines = file ( $fileName /*"IDs.cgi"*/);
        $numLines = count($lines);
        $studentID = $studID;//"217075";
        $found = 0;

        for ($i = 0; $i < $numLines; $i++)
        {
          //echo "<pre>line $i:  $lines[$i] </pre>";
          // split by any number of spaces
          $thingsPerLine = preg_split('#\s+#', $lines[$i], null, PREG_SPLIT_NO_EMPTY);
          //echo "thingsPerLine:".count($thingsPerLine);
          $aStudentID = $thingsPerLine[count($thingsPerLine) - 1];
          //echo "<pre>Student ID: $aStudentID <pre> ";
          if ($studentID == $aStudentID)
          {
            $found++;//echo "M A T C H ! ! ! ! <br>";
            break;
          }
        }
        if ($found == 0)
          return "false";//header('Location: invalidIDPage.html');
        else
          return "true";//echo "ID WAS FOUND!!";
}
?>
