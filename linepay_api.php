<!-- localhost/subject/linepay_api/linepay_api.php -->

<?php
//所需要的參數
$channel_ID = '1656156735';//your line sandbox ID
$channel_serect = 'db7730900a9602c7bc6a846d8f2e4962';//your line sandbox serect
$R_URI = 'https://sandbox-api-pay.line.me/v2/payments/request';//Request API URI
$productName = $_POST['productName'];
$amount = $_POST['amount'];
//api所需要的request_body
$r_body = json_encode(array(
    "productName" => $productName,
    "amount" => $amount,
    "currency" => "TWD",
    "orderId" => "testorderID",
    "confirmUrl" => 'http://localhost/subject/linepay_api/order.html'
    ) 
);
//api所需要的header
$_header = array(
    'Content-Type: application/json',
    'X-LINE-ChannelId: ' . $channel_ID,
    'X-LINE-ChannelSecret: ' . $channel_serect
);
//使用curl函式來進行連線
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $R_URI);
curl_setopt($curl, CURLOPT_HTTPHEADER, $_header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $r_body);
$temp = curl_exec($curl);
curl_close($curl);
//將response進行處理單獨取出付款網址並導向付款網址
$result = json_decode($temp,true);
echo "<br/>" . "<br/>";
$url = $result['info']['paymentUrl']['web'];
header("Location: $url");

?>