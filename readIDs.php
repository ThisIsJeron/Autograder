<?php

if ( foundID("IDs.cgi",217075) == "true" )
  echo "ID WAS FOUND!!";
else 
  header('Location: invalidIDPage.html');

function foundID($fileName, $studID)
{
	//echo "fileName: $fileName  , studentID: $studID <br>";
	$lines = file ( $fileName /*"IDs.cgi"*/); 
	$numLines = count($lines);
	$studentID = $studID;//"217075";
	$found = 0;

	for ($i = 0; $i < $numLines; $i++){
	  //echo "<pre>line $i:  $lines[$i] </pre>";
	  // split by any number of spaces
	  $thingsPerLine = preg_split('#\s+#', $lines[$i], null, PREG_SPLIT_NO_EMPTY);
	  //echo "thingsPerLine:".count($thingsPerLine);
	  $aStudentID = $thingsPerLine[count($thingsPerLine)-1];
	  //echo "<pre>Student ID: $aStudentID <pre> ";
	  if ($studentID == $aStudentID){
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
