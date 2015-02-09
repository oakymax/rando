<?php

define("__ROOT__", realpath(__DIR__ . "/.."));

try {

    include(__ROOT____.'/init.php');

    $router = new Router();
    $router->execute();

} catch(RandoHTTPException $e) {

    /* handle application exceptions
     * to provide correct response header */
    header_status( $e->httpCode() );
    die(json_encode(['message' => $e->getMessage()]));

} catch(Exception $e) {

    /* handle other exceptions */
    header_status( "500" );
    die(json_encode(['message' => $e->getMessage()]));

}

