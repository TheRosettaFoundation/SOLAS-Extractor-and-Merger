<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require "regressionTests.php";
//echo "current working directory = ";
//$echo = shell_exec("pwd");
//echo $echo;

//file_put_contents("./uploads/1/thing.txt", $echo);

$data = file_get_contents("./uploads/3/pg100.html");
//print_r($data);
// then use it on functions

testExtractor($data, "4", "pg50.html");

//doStuffToXLIFF($data, "3");


?>
