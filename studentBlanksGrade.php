<?php
/**
 * Created by PhpStorm.
 * User: jeron
 * Date: 10/6/16
 * Time: 5:36 PM
 */

$lines = file('linesbefore.txt');
foreach($lines as $line)
{
    "inputs".$line = $_POST["inputs".$line];
}

echo $inputs9;
echo $inputs12;

//echo "<pre>"; print_r($lineNumbersArray);

/*
foreach($lineNumbersArray as $value){
    $value = $_POST[$value];
}
*/
?>