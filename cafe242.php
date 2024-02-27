<?php
$mallid = "gpalsdl2003";
$client_id = "DnoHQGJsCdUieAyIhV8juB";
$client_secret_key = "Id3eEYfGCUY3unA7bIAhJL";
$service_key = "ejk71xRxhYrK2nnD+qzIWo0dHQ1b+kbCxGVs3CobhMw=";

function getCode(){
    $url = "https://gpalsdl2003.cafe24api.com/api/v2/oauth/authorize?response_type=code&client_id=DnoHQGJsCdUieAyIhV8juB&redirect_uri=https://mwo.kr/cafe24.php&scope=mall.read_order";

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
    ));
    $response = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        echo 'cURL Error #:' . $err;
    } else {
        //echo $response;
        echo "<br>";
        echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL,true);
        print_r(curl_getinfo($ch));
    }
}
getCode();

function getAccessToken($code){
    global $mallid;
    global $client_id;
    global $client_secret_key;
    $url = "https://{$mallid}.cafe24.com/api/v2/oauth/token";
    //$url = "https://25percentage.com/api/v2/oauth/token";
    $client_data = base64_encode($client_id.":".$client_secret_key);
    $data = array(
        "grant_type"=>"authorization_code",
        "code"=>$code,
        "redirect_uri"=>"https://mwo.kr/cafe24.php"
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic {$client_data}",
            "Content-Type: application/x-www-form-urlencoded",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) {
        echo 'cURL Error #:' . $err;
    } else {
        echo $response;
        $response = json_decode($response,true);
        print_r( $response);
        return $response['access_token'];
    }
}

function getOrderList($access_token){
    global $mallid;
    global $client_id;
    global $client_secret_key;
    $version = "2023-12-01";

    $url = "https://{$mallid}.cafe24api.com/api/v2/admin/orders?start_date=2024-01-01&end_date=2024-01-31";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer {$access_token}",
            "Content-Type: application/json",
            "X-Cafe24-Api-Version: {$version}"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) {
        echo 'cURL Error #:' . $err;
    } else {
        echo $response;
    }
}
/*
if(!empty($_GET['code'])){
    echo $_GET['code'];
    echo "<br>";
    $access_token = getAccessToken($_GET['code']);
echo $access_token;
    echo "<br>";
    echo "-------------";
    echo "<br>";
    getOrderList($access_token);   
}
*/

//https://gpalsdl2003.cafe24api.com/api/v2/oauth/authorize?response_type=code&client_id=DnoHQGJsCdUieAyIhV8juB&redirect_uri=https://mwo.kr/cafe24.php&scope=mall.read_order



?>

