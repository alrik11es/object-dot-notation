<?php
include('../vendor/autoload.php');

$request = json_decode(file_get_contents('php://input'));
$data = \Alr\ObjectDotNotation\Data::load(json_decode($request->data));
$response = new stdClass();
$response->html = print_r($data->get($request->field),true);
if(empty($response->html)) {
    $response->html = '<i>null</i>';
}
echo json_encode($response);