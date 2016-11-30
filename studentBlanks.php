<?php
/**
 * Created by PhpStorm.
 * User: jeron
 * Date: 10/6/16
 * Time: 2:30 PM
 */

$lines = file('lines.txt');
//for loop to add each line in file into array
foreach($lines as $line)
{
    $lineNumbersArray[] = $line;
}

for ($i = 0; $i < count($lineNumbersArray); $i++)
{
    $uniqueIDArray[] = uniqid();
}

/*
for ($i = 0; $i < count($uniqueIDArray); $i++)
{
    echo $uniqueIDArray[$i] . "\n";
}
*/

echo "<h1>Final:</h1>";

$file="answer.cpp";
$lineCount = 1;
$handle = fopen($file, "r");
$uniqueCounter = 0;
echo "<form action=\"studentBlanksGrade.php\" method=\"post\">";


while(!feof($handle)){
    if (in_array($lineCount, $lineNumbersArray)) {
        $line = fgets($handle);
        echo "<input type=\"text\" name=\"$uniqueIDArray[$uniqueCounter]\"><br>";
        //echo inputNumber($lineCount);
        //echo "<input type=\"text\" name=\"inputs\"><br>";
        $uniqueCounter++;
        $lineCount++;
    }else {
        $line = fgets($handle);
        echo $line . "<br>";
        $lineCount++;
    }
}

echo "<input type=\"submit\" value=\"Submit\"></form>";

/*
function inputNumber ($lineCount){
    return "<input type=\"text\" name=\"inputs$lineCount\"><br>";
}
*/
