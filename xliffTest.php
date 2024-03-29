<?php
require_once "doStuffToXLIFF_file.php";
require_once 'HTTP/Request2.php';
require_once 'settings.class.php';
require_once 'simple_html_dom.php';

$id = "401afb3f0a";

// Get the LocConnect URL from the .ini file
$urlSettings = new Settings();
$baseURL = $urlSettings->get('general.BASE_URL');
// I presume this class will just poll for jobs it needs to complete.
//get a job from the server, job requires an id and com, id = 8586365b9a (testing purposes)


function showDOMNode(DOMNode $domNode) {
    foreach ($domNode->childNodes as $node)
    {
        print $node->nodeName.':'.$node->nodeValue;
        if($node->hasChildNodes()) {
            showDOMNode($node);
        }
    }    
}

try {
    // Get the filename associated with the ID using get_extension
    $request = new HTTP_Request2($baseURL."/get_extension.php?id=$id");
    $request->setMethod(HTTP_Request2::METHOD_GET);
    $response = $request->send();
    
    if (200 == $response->getStatus()) 
    {
        // get the filename from the HTTP request by calling getBody(), then get rid of the content tags
        $filename=$response->getBody();
        $filename= str_replace('<content>', '', $filename);

        // Create a new DomDocument and load the XLIFF file into it using get_job
        $xliff = new DOMDocument();        
        $xliff->load($baseURL."/get_job.php?id=$id&com=EXT");
        
        // Look for the header tags in the file
        $headers = $xliff->getElementsByTagName( 'header' );
        
        if($headers==null||sizeof($headers)==0)
        {// creat a header element if it dose not exist
            echo "no header tags found";
        }
        else
        {
            // load the header Node into simpleXML
            $header = simplexml_import_dom($headers->item(0));
            // Get the main body of text from the XLIFF file found in the converted-file tag
            $text = $header->reference->{'internal-file'}->{'converted-file'};

            // Send the text, filename and id to the ExtractionService class to be extracted into XLIFF, then load into a DOMDocument
            $converted = new DOMDocument();
            $converted->loadXML(ExtractionService::extract($text, $filename, $id));
            
            // import the header Node into the scope of the XLIFF that has just been extracted
            $head=$converted->importNode($headers->item(0), true);
            // Insert the header Nodes just after the file tags and before the body tags
            $fileElem = $converted->getElementsByTagName( 'file' )->item(0);
            $fileElem->insertBefore($head,$converted->getElementsByTagName( 'body' )->item(0));

            // ***return the file
            echo $converted->saveXML();
        }
  
    } 
    else 
    {
       $res='Unexpected HTTP status: ' . $response->getStatus() . ' ' .
       $response->getReasonPhrase();
    }
        
} catch (HTTP_Request2_Exception $e) 
{
   $res='Error: ' . $e->getMessage();
}


?>
