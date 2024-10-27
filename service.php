<?php
ini_set("soap.wsdl_cache_enabled", "0");
include("./helpers/database.php");
if (isset($_GET['wsdl']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
    header("Content-Type: text/xml");
    readfile('test.wsdl');
    exit;
}

class RequestStructure
{
    public $username;
    public $password;
    public $type;
}

function authenticateUser($mysqli, $username, $password)
{
    try {
        if ($stmt = $mysqli->prepare("SELECT accountStatus FROM users WHERE username = ? AND userPassword = ?")) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                return $row['accountStatus'] == 1;
            }
        }
    } catch (Exception $ex) {
        return false;
    }
    return false;
}

function getBookList($userInput)
{
    global $mysqli;
    if (!authenticateUser($mysqli, $userInput->username, $userInput->password)) {
        return ['error' => "Kullanici adi veya parola hatali."];
    }

    try {
        $query = "SELECT name,id FROM books WHERE tur = ? ORDER BY id DESC";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("s", $userInput->type);
            $stmt->execute();
            $result = $stmt->get_result();

            $xml = new SimpleXMLElement('<kitapListesi/>');
            while ($row = $result->fetch_assoc()) {
                $kitapXml = $xml->addChild('kitap');
                $kitapXml->addChild('kitapIsim', htmlspecialchars($row['name']));
                $kitapXml->addChild('kitapId', htmlspecialchars($row['id']));
            }

            return (object) [
                'result' => $xml->asXML()
            ];
        }
    } catch (Exception $ex) {
        return (object) [
            'error' => "Islem sirasinda bir hata olustu."
        ];
    }
}


$server = new SoapServer("test.wsdl", [
    'classmap' => [
        'RequestStructure' => 'RequestStructure',
    ]
]);
$server->addFunction('getBookList');
$server->handle();
