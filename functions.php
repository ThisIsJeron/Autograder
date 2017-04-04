<?php
/**
  * shows the expectedProgram. This is used for
  * the "sample" programming assignments,
  * which students have to type exactly word for word
*/
function showExpectedProgram($expectedProgram)
{
  // show the sample program
  echo "<hr>";
  echo "<b>--- Expected Program/Answer File --- </b>($expectedProgram) <br>";
  echo "<pre>".file_get_contents($expectedProgram)."</pre>"."<br><hr>";
}

/* shows the studentFile. This is used for
  * the "sample" programming assignments,
  * which students have to type exactly word for word
*/
function showStudentProgram($studentFile)
{ 
  // show the student program
  echo "<hr>";
  echo "<b>*** Your Program: *** </b>($studentFile) <br>";
  echo "<pre>".file_get_contents($studentFile)."</pre>"."<br>";
}

/**
  * shows the differences file, result of compareDifferences()
*/
function showDifferences($differencesFileName)
{
  // read the file as a string
  $differences1 = file_get_contents($differencesFileName);
  // if there are no  differences
  if (strlen($differences1) == 0)
    echo "CONGRATULATIONS! Your test run matches the expected 100%<br>";
  // if there are differences, show them (with explanation)
  if (strlen($differences1) != 0)
  {
     echo "<h3> There are differences </h3>";
     echo "<pre>$differences1 </pre>"; 
     echo "<b> Explanation: </b> <br>";
     echo file_get_contents("diffExplanationTable");
  }
}

/**
  * checks if there are differences
  * returns true if there are differences
*/
function thereAreDifferences($differencesFileName)
{
  $differences1 = file_get_contents($differencesFileName);
  if (strlen($differences1) == 0)
     return "false";
  return "true";  
}

/**
  * compares answerFile to studentTestRun
  * sends the results of the comparison to differencesFile
*/
function compareDifferences($studentTestRun, $answerFile, $differencesFile)
{
  echo "<br> Comparing <b>$answerFile</b> with <b>$studentTestRun </b> <br>";
  echo "sending the results of comparison to <b>$differencesFile</b><br>";
  $command4 = "diff -c $answerFile $studentTestRun > $differencesFile";
  echo $command4."<br>";
  exec ($command4);
}

/**
*  checks to see if a student ID is in a file with ID's
*  returns "true" or "false"
*/
function idIsInFile($fileName, $studID)
{
  //echo "fileName: $fileName  , studentID: $studID <br>";
  // splits the file into lines and puts it into array
  $lines = file ( $fileName /*"IDs.cgi"*/);
  $numLines = count($lines);
  $studentID = $studID;//"217075";
  
  $found = 0;
  for ($i = 0; $i < $numLines; $i++)
  {
    //echo "<pre>line $i:  $lines[$i] </pre>";
    // split each line by any number of spaces
    $thingsPerLine = preg_split('#\s+#', $lines[$i], null, PREG_SPLIT_NO_EMPTY);
    //echo "thingsPerLine:".count($thingsPerLine);
    $aStudentID = $thingsPerLine[count($thingsPerLine)-1];
    //echo "<pre>Student ID: $aStudentID <pre> ";
    if ($studentID == $aStudentID)
    {
      $found++;//echo "M A T C H ! ! ! ! <br>";
      break;
    }
  }

  if ($found == 0)
    return "false";//header('Location: invalidID.html');
  else
    return "true";//echo "ID WAS FOUND!!";
}

/**
*  generate a student test run file name based on studentID
*  this is so that two students don't
*  have the same test run file name
*/
function generateStudentTestRunFilename($studID)
{
  $studentTestRunFileName = $studID."testRun.txt";
  return $studentTestRunFileName; 
}

/**
*  generate a student differences file name based on studentID
*  this is so that two students don't
*  have the same test run file name
*/
function generateStudentDifferencesFilename($studID)
{
  $studentTestRunFileName = $studID."testRun.txt";
  return $studentTestRunFileName;
}

// call the functions
echo "student id is in IDs.cgi: ".idIsInFile("FinishedIDs.cgi", "230352");
compareDifferences("answer.txt","230352testRun.txt","230352differences.txt");
showStudentProgram("230352testRun.txt");
showExpectedProgram("answer.txt");
showDifferences("230352differences.txt");
echo "there are differences: ". thereAreDifferences("230352differences.txt");

?>
