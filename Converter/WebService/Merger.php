<?php
require_once file_exists('lib/tonic.php')==true? 'lib/tonic.php':"Converter/lib/tonic.php";
require_once file_exists('settings.class.php')?'settings.class.php':'../settings.class.php';


/**
 * @uri v0/merger/{$jobid}
 */


class MergerService extends Resource {
//$version = 0;

static public function endsWith($string, $input)
{ 
	
   // return ( $string{strlen($string)-1} === $query);
   return  (substr($string, (strlen($query)*-1)) === $query);
}

static public function merge($data, $jobid, &$code)
{
    
        
    $versionImport =null;
	if(isset($_GET['version']))	$versionImport =$_GET['version'];


	if ($versionImport == Null || trim($versionImport) == '') // if $versionImport is null
	{
		$version = 1.2;
	} else if ($versionImport != 2.0)
	{
		$version = 1.2;
	}

	//echo getcwd();
	
	$xmlDoc = new DOMDocument(); 

        $urlSettings = new Settings();
        $uploads = $urlSettings->get('general.uploads');
        echo $uploads;
        echo $jobid;
	// check jobid exists
	if( file_exists($uploads."$jobid"))
	{
                       // echo "\nfound file in uploads/$jobid";
			// check name of file from xliff

			$xmlDoc->loadXML( $data); 
			//print_r($xmlDoc->saveXML());
			
			$fileElements = $xmlDoc->getElementsByTagName( "file" ); 


			if ($fileElements->length!=0) 
			{
                            
				
				$fileElement = $fileElements->item(0);
				$fileName = $fileElement->getAttribute("original");
                                //echo "\nfound file name $fileName \n";

				// check if the original filename from the xliff document exists
				if( file_exists("$fileName"))
				{	
                                        shell_exec("sudo chmod 777 ".$uploads."$jobid/*");
					
                                        // make a backup of the xlf document	
					file_put_contents("{$fileName}.xlf_backup", file_get_contents("$fileName.xlf"));				
					
                                        // remove original xlf document, don't worry a back was made above.
                                        shell_exec("rm $fileName.xlf");
                                        
                                        
					// put the new translated xliff data in the .xlf file 
					file_put_contents("$fileName.xlf", $data);

                                        
                                        
					// make a backup of the original file								
					file_put_contents("{$fileName}_backup", file_get_contents("$fileName"));				

					// merge using the new translated xliff document
                                        
					shell_exec ("./tikel/xliff$version/tikal.sh -m  -ie UTF-8 -oe UTF-8 $fileName.xlf");
                                        

					$lastIndex = strrpos($fileName, ".");
					
					$fileName = substr_replace($fileName, ".out.", $lastIndex, 1);

					return file_get_contents("$fileName");


				}

			}
                        
                        return "error, could not match xliff with original file";
                        $response->code = 500;
        }
                        
                        
}

public function post($request, $jobid)
{			
        // done!
        $response = new Response($request);
        $response->addHeader('Content-type', 'text/xml; charset=utf-8');
        $code = Response::OK;
        $response->body = MergerService::merge($request->data, $jobid, $code);
        $response->code = $code;
        
    
        return $response;
}
 
}

?>
