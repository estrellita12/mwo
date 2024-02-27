<?php
$mallid = "gpalsdl2003";
$client_id = "DnoHQGJsCdUieAyIhV8juB";
$client_secret_key = "Id3eEYfGCUY3unA7bIAhJL";
$service_key = "ejk71xRxhYrK2nnD+qzIWo0dHQ1b+kbCxGVs3CobhMw=";

function getCode(){
    //https://gpalsdl2003.cafe24api.com/api/v2/oauth/authorize?response_type=code&client_id=DnoHQGJsCdUieAyIhV8juB&redirect_uri=https://mwo.kr/cafe24.php&scope=mall.read_order
    $url = "https://gpalsdl2003.cafe24api.com/api/v2/oauth/authorize?response_type=code&client_id=DnoHQGJsCdUieAyIhV8juB&redirect_uri=https://mwo.kr/cafe24.php&scope=mall.read_order";

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        //CURLOPT_RETURNTRANSFER => true,
        //CURLOPT_FOLLOWLOCATION => true,
    ));
    $response = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        echo 'cURL Error #:' . $err;
    } else {
        //echo $response;
        echo "<br>";
        echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL,true);
    }
}

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
        return;
    } else {
        //echo $response;
        $response = json_decode($response,true);
        return $response['access_token'];
    }
}

function getOrderList($access_token){
    global $mallid;
    global $client_id;
    global $client_secret_key;
    $version = "2023-12-01";

    $timestamp = strtotime("-4 week");
    $start_date = date("Y-m-d", $timestamp);
    $end_date = date("Y-m-d");
        
    // https://25percentage.com/product/detail.html?product_no=754&ghost_mall_id=mirae
    $url = "https://{$mallid}.cafe24api.com/api/v2/admin/orders?start_date={$start_date}&end_date={$end_date}";
    $url = "https://{$mallid}.cafe24api.com/api/v2/admin/orders?inflow_path=mirae&start_date={$start_date}&end_date={$end_date}";
    //$url = "https://{$mallid}.cafe24api.com/api/v2/admin/orders?inflow_path=mwd&start_date={$start_date}&end_date={$end_date}";
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
        //echo 'cURL Error #:' . $err;
        return;
    } else {
        //echo $response;
        return $response;
    }
}
if(!empty($_GET['code'])){
    echo $_GET['code'];
    echo "<br>";
    echo $access_token;
    echo "<br>";
    echo "-------------";
    echo "<br>";
    $access_token = getAccessToken($_GET['code']);
    $arr = getOrderList($access_token);   
    echo $arr;
}


?>

