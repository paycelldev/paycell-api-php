<?php
include '../util.php';
include '../endpointConstants.php';
include '../model/registerCardRequest.php';
include '../model/requestHeader.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: access-control-request-origin,content-type');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $header = RequestHeader::createTestHeader();
    $request = new RegisterCardRequest(
        null, $header, $data["alias"], $data["cardToken"], $data["eulaId"], $data["isDefault"], $data["msisdn"], 
        isset($data["otp"]) ? $data["otp"] : null, 
        isset($data["otpValidationId"]) ? $data["otpValidationId"] : null, 
        isset($data["threeDSessionId"]) ? $data["threeDSessionId"] : null);
    
    if(isset($data["webCallMethod"]) && $data["webCallMethod"] == "REST"){
        echo post(RestEndpointConstants::$registerCard, $request);
    } else {
        echo json_encode(soap(SoapEndpointConstants::$provisionServices, "registerCard", $request));
    }
}

?>