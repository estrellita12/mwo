<?php
$com_id = 'majorgolf';
$auth_key = 'dZudbGruSGZbNS6rWKdSdH8BNMT5F7SPb7';
$partner_key = 'h54w643g3453452';
$domain_key = '4h455g23423dhfdg';

$timestamp = strtotime("Now");
$today = date("Ymd", $timestamp);

$timestamp = strtotime("-1 days");
$d_one = date("Ymd", $timestamp);

$timestamp = strtotime("-2 days");
$d_two = date("Ymd", $timestamp);

$timestamp = strtotime("-3 days");
$d_three = date("Ymd", $timestamp);

function post_data($url,$fields){
    $post_field_string = http_build_query($fields, '', '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string );
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

function set_product($gs_id){
    $sql = " select * from shop_goods where index_no=".$gs_id;
    $gs = sql_fetch( $sql );

    $sql = " select * from shop_goods_option where gs_id=".$gs_id;
    $res = sql_query ($sql);
    $opt = "선택:";
    for($i=0;$row=sql_fetch_array( $res );$i++){
        if($i!=0){
            $opt .= ",";
        }
        $opt_val = str_replace(chr(30)," ", $row['io_id']);
        $opt .= $opt_val;
    }
    
    $arr = array(
        'partner_key'=>'h54w643g3453452',
        'domain_key'=>'4h455g23423dhfdg',
        'action'=>'set_product',
        'name'=>$gs['gname'],
        'supply_code'=>'',
        'options'=>$opt,
        'stock_manage'=>'1',
        'brand'=>$gs['brand_nm'],
        'link_id'=>'JS'.$gs['gcode'],
        'origin'=>$gs['origin'],
        'maker'=>$gs['maker'],
        'barcode'=>'',
        'org_price'=>$gs['normal_price'],
        'supply_price'=>$gs['supply_price'],
        'shop_price'=>$gs['goods_price'],
        'img'=>'https://mwo.kr/data/goods/'.$gs['simg1'],
        'multi_category'=>'',
        'product_desc'=>$gs['memo'],
        'market_price'=>'',
        'extra_column1'=>'',
        'extra_column2'=>'',
        'extra_column3'=>''
    );
    $res = post_data('https://estrellita.org/test/curl_post.php', $arr);
    return $res;
}

function get_order_info(){
    
    $arr = array(
        'partner_key'=>'h54w643g3453452',
        'domain_key'=>'4h455g23423dhfdg',
        'action'=>'get_order_info',
        'date_type'=>'',
        'start_date'=>'',
        'end_date'=>''
    );
    $res = post_data('https://estrellita.org/test/curl_post.php', $arr);
    return $res;
}







?>
