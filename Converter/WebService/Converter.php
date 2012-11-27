<?php 
 
/**
 * @uri /dispatch.php/v0/Converter/{$directory}
 */
class ConverterService extends Resource {

static public function endsWith($string, $query)
{ 
	
   // return ( $string{strlen($string)-1} === $query);
   return  (substr($string, (strlen($query)*-1)) === $query);
}

public function get($request,$directory){

	
	shell_exec("cd temp/TikelStuff && ./tikal.sh -x inputFiles/myFile.html");
	//shell_exec("./tikal.sh -x inputFiles/myFile.html");
	//shell_exec("mkdir hello")
	//shell_exec("cd ../temp");
	//shell_exec("cd ../../..");
    // done!
    $response = new Response($request);
    //$response->addHeader('Content-type', 'text/xml');
    $response->code = Response::OK;

 	//$fileName = $_POST['file'];
	//$fileNumber = $_POST['fileName'];


	//$response->body = $directory;
	//shell_exec('cd inputFiles/');
	
	//$response->body = shell_exec('cat temp/TikelStuff/inputFiles/myFile.html.xlf');
	$response->body = $directory; 
   // echo shell_exec('cat temp/TikelStuff/inputFiles/myFile.html.xlf');
    return $response;
}
 
}
 
?>
