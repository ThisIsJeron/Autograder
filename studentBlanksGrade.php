<?php
/**
 * Created by PhpStorm.
 * User: jeron
 * Date: 10/6/16
 * Time: 5:36 PM
 */

//$lines = file('linesbefore.txt');
foreach($lines as $line)
{
    'inputs'.$line = $_GET['inputs'.$line];
}
