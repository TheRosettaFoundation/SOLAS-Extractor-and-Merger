<?php

// load Tonic library
require_once 'lib/tonic.php';

// load service
require_once 'WebService/extractor.php';
require_once 'WebService/Merger.php';




// handle request
$request = new Request(array('baseUri' => ''));
try {
    $resource = $request->loadResource();
    $response = $resource->exec($request);

} catch (ResponseException $e) {
    switch ($e->getCode()) {
    case Response::UNAUTHORIZED:
        $response = $e->response($request);
        $response->addHeader('WWW-Authenticate', 'Basic realm="Tonic"');
        break;
    default:
        $response = $e->response($request);
    }
}
$response->output();

?>
