<?php

require_once __DIR__.'/vendor/autoload.php';

use PhpXmlRpc\Client as PXRClient;


$inAr = array("Dave" => 24, "Edd" => 45, "Joe" => 37, "Fred" => 27);

$p = array();
foreach ($inAr as $key => $val) {
    $p[] = new PhpXmlRpc\Value(
        array(
            "name" => new PhpXmlRpc\Value($key),
            "age" => new PhpXmlRpc\Value($val, "int")
        ),
        "struct"
    );
}

$v = new PhpXmlRpc\Value($p, "array");

$req = new PhpXmlRpc\Request('examples.sortByAge', array($v));
$client = new PhpXmlRpc\Client("http://phpxmlrpc.sourceforge.net/server.php");

$resp = $client->send($req);

if (!$resp->faultCode()) {
    print "The server gave me these results:<pre>";
    $value = $resp->value();
    foreach ($value as $struct) {
        $name = $struct["name"];
        $age = $struct["age"];
        print htmlspecialchars($name->scalarval()) . ", " . htmlspecialchars($age->scalarval()) . "\n";
    }

    print "<hr/>For nerds: I got this value back<br/><pre>" .
        htmlentities($resp->serialize()) . "</pre><hr/>\n";
} else {
    print "An error occurred:<pre>";
    print "Code: " . htmlspecialchars($resp->faultCode()) .
        "\nReason: '" . htmlspecialchars($resp->faultString()) . '\'</pre><hr/>';
}