<?php
ini_set("soap.wsdl_cache_enabled", "0");

$wsdlUrl = "http://localhost/soaptest/service.php?wsdl";

try {
    $client = new SoapClient($wsdlUrl, [
        'trace' => true,
        'exceptions' => true
    ]);



    $response = $client->__soapCall('GetBookList', array(
        "request" =>
            array(
                "username" => "akartals",
                "password" => "123456",
                "type" => "roman"
            )
    ));

    if (isset($response->result)) {
        $xml = simplexml_load_string(data: $response->result);
        echo "Kitap listesi:<br/>";
        foreach ($xml->kitap as $kitap) {
            echo "Isim: " . (string) $kitap->kitapIsim . ", ID: " . (string) $kitap->kitapId . "<br/>";
        }
    } else {
        echo "Error: " . $response->error . "<br/>";
    }

} catch (SoapFault $fault) {
    echo "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})<br/>";
    echo "Request :\n" . $client->__getLastRequest() . "<br/>";
    echo "Response:\n" . $client->__getLastResponse() . "<br/>";
    echo "ErrorLine:\n " . $fault->getLine();
} catch (Exception $ex) {
    echo "Bir hata olustu: " . $ex->getMessage() . "<br/>";
}
?>