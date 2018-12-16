<?php

require_once __DIR__.'/vendor/autoload.php';


use PhpXmlRpc\Value;
use PhpXmlRpc\Request;
use PhpXmlRpc\Server;


function add ($xmlrpcmsg) 
{
    $a = $xmlrpcmsg->getParam(0)->scalarval(); // first parameter becomes variable $a
    $b = $xmlrpcmsg->getParam(1)->scalarval(); // second parameter becomes variable $b

    $result = $a+$b; // calculating result

    $xmlrpcretval = new xmlrpcval($result, "int"); // creating value object
    $xmlrpcresponse = new xmlrpcresp($xmlrpcretval); // creating response object

    return $xmlrpcresponse; // returning response
}

function sumAndDifference ($params) {

    // Parse our parameters.
    $xval = $params->getParam(0);
    $x = $xval->scalarval();
    $yval = $params->getParam(1);
    $y = $yval->scalarval();

    // Build our response.
    $struct = array('sum' => new xmlrpcval($x + $y, 'int'),
                    'difference' => new xmlrpcval($x - $y, 'int'));
    return new xmlrpcresp(new xmlrpcval($struct, 'struct'));
}

$sumAndDifference_sig = array(array('struct', 'int', 'int'));
$sumAndDifference_doc = 'Add and subtract two numbers';

$s = new Server(
  array(
    "sample.sumAndDifference" => array(
    	'function' => 'sumAndDifference',
    	'signature' => $sumAndDifference_sig,
    	'docstring' => $sumAndDifference_doc
    )
    
  ));
