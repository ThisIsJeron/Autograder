<?php
/**
 * Created by PhpStorm.
 * User: jeron
 * Date: 10/6/16
 * Time: 2:30 PM
 */

$lines = file('linesbefore.txt');
foreach($lines as $line)
{
    $lineNumbersArray[] = $line;
}

echo "<h1>Final:</h1>";

$file="answer.cpp";
$lineCount = 0;
$handle = fopen($file, "r");
echo "<form action=\"studentBlanksGrade.php\" method=\"post\">";
while(!feof($handle)){
    if (in_array($lineCount, $lineNumbersArray)) {
        $line = fgets($handle);
        echo inputNumber($lineCount);
        //echo "<input type=\"text\" name=\"inputs\"><br>";
        $lineCount++;
    }else {
        $line = fgets($handle);
        echo $line . "<br>";
        $lineCount++;
    }
}

echo "<input type=\"submit\" value=\"Submit\"></form>";

function inputNumber ($lineCount){
    return "<input type=\"text\" name=\"inputs$lineCount\"><br>";
}