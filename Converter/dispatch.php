<?php
mb_internal_encoding("UTF-8");
// load Tonic library
require_once 'lib/tonic.php';

// load service
require_once 'WebService/extractor.php';
require_once 'WebService/Merger.php';




// handle request
$request = new Request(array('baseUri' => '/converter/Converter/dispatch.php/'));
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
