<?php
require_once file_exists('../lib/tonic.php')==true? '../lib/tonic.php':"Converter/lib/tonic.php";
/**
 * @uri /dispatch.php/v0/extractor/{$filename}/{$jobid}/
 */


class ExtractionService extends Resource {

static public function endsWith($string, $input)
{ 
	
   // return ( $string{strlen($string)-1} === $query);
   return  (substr($string, (strlen($query)*-1)) === $query);
}

public static function extract($data,$filename,$jobid){
    
    //echo "in extractor <br>";
    
    shell_exec("mkdir uploads/$jobid && chmod 777 -R uploads/$jobid");
	
	// save file with name based off filename
	file_put_contents("./uploads/$jobid/$filename", $data);
	// convert file to xliff based on version	


	// Things that can be expected from GET: tikal version, target language, source language, file extension
	$versionImport =null;
	$targetLanguage = null;
	$sourceLanguage = null;
	$extension = null;

	if(isset($_GET['version']))	$versionImport =$_GET['version'];
	if(isset($_GET['target-language']))$targetLanguage = $_GET['target-language'];
	if(isset($_GET['source-language']))$sourceLanguage = $_GET['source-language'];
	
	// if we were given an extension
	if(isset($_GET['extension']))
	{
		$extension = $_GET['extension'];

		// if the original filename has an extension
		if( $pos = stripos($filename, ".", 1) != false)
		{
			$pos = stripos($filename, ".", 1);
			$filename = substr_replace($filename, ".".$extension, $pos);

		} else {

			$filename = $filename . "." . $extension;
		}
	}
	
	$argString = "";
	
	// add -nocopy to the arg string 
	$argString .= " -nocopy ";

	if ($targetLanguage != Null || trim($targetLanguage) != '') // if $targetLanguage is not null
	{
		$argString = " -tl {$targetLanguage}";
	} 

	if ($sourceLanguage != Null || trim($sourceLanguage) != '') // if $targetLanguage is not null
	{
		$argString .= " -sl {$sourceLanguage}";
	} 

	if ($versionImport == Null || trim($versionImport) == '') // if $versionImport is null
	{
		$version = 1.2;
	} else if ($versionImport != 2.0)
	{
		$version = 1.2;
	}
	
	shell_exec("tikel/xliff$version/tikal.sh {$argString} -x -ie UTF-8 uploads/$jobid/$filename");
        
        
        shell_exec("sudo chmod 777 ./uploads/$jobid/*");
        
        
	$xliff = file_get_contents("uploads/$jobid/$filename.xlf");
        //echo $xliff;
        return $xliff;
	
}

public function post($request, $filename, $jobid)
{
    $response = new Response($request);
    $response->addHeader('Content-type', 'text/xml');
    $response->code = Response::OK;

	$response->body = ExtractionService::extract($request->data, $filename, $jobid);
	//$response->body = $this->showForm($request->data);
    return $response;
}
 
}

?>
