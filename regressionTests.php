<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "./Converter/WebService/Merger.php";
require_once "./Converter/WebService/extractor.php";


function testExtractor($xliffFile, $jobid, $filename){

    $ExtractioninitalTime = time();
    
    //$extension = getExtension()
    $code = Response::OK;
    $result = ExtractionService::extract($xliffFile, $filename, $jobid);
    
    $ExtractionendTime = time();
    
    print_r("Extraction time = ");
    print_r($ExtractionendTime - $ExtractioninitalTime);
    
    $initalTime = time();
    
    // $result should now be the converted xliff file
    
   $LoadinitalTime = time();
    print_r("<br>hello there<br>");
    
    $xml = new DOMDocument(); 

    $xml->load("./uploads/$jobid/$filename.xlf");
    
    
    $LoadendTime = time();
    
    print_r("<br>time taken to load = ");
    print_r($LoadendTime - $LoadinitalTime);
    print_r("<br>");
    
    // current time
    $validateinitalTime = time();
    
    if (!$xml->schemaValidate('./XSD/xliff-core-1.2-transitional.xsd')) { 
        echo "invalid transitional<p/>";
    } 
    else { 
       echo "validated transitional<p/>"; 
    } 
    // current time
    $validateendTime = time();
    print_r("<br>time taken to validate= ");
    print_r($validateendTime - $validateinitalTime);
    
//    if (!$xml->schemaValidate('./XSD/xliff-core-1.2-strict.xsd')) { 
//        echo "invalid strict<p/>";
//    } 
//    else { 
//       echo "validated strict<p/>"; 
//    } 

    $endTime = time();
    print_r("<br>Validation time taken = ");
    print_r($endTime - $initalTime);
    




//Save amended XLIFF DOMDocument object to file 					
					

}

?>
