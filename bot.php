<?php
    date_default_timezone_set("Asia/Jakarta");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $start_msg = $_ENV['START_MSG']; 

if($message == "/start"){
    send_message($chat_id,$message_id, "***Hola $firstname \nPara usar pone así  !dni xxxxxx el número \n$start_msg***");
}

//Bin Lookup
if(strpos($message, "!dni") === 0){
    $bin = substr($message, 5);
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "http://bot.netvone.xyz:25565/dni/".$dni,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
    "sec-fetch-dest: document",
    "sec-fetch-site: none",
    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
   ],
   ]);

 $result = curl_exec($curl);
 curl_close($curl);
 $data = json_decode($result, true);
 $nombres = $data['data']['nombres'];
 $cuil = $data['data']['cuil'];
 $ciudad = $data['data']['ciudad'];
 $piso = $data['data']['piso'];
 $provincia = $data['data']['provincia'];
 $apellido = $data['data']['apellido'];
 $EMISION = $data['data']['EMISION'];
 $numero = $data['data']['numero'];
 $pais = $data['data']['pais'];
 $municipio = $data['data']['municipio'];
 $cpostal = $data['data']['cpostal'];
 $VENCIMIENTO = $data['data']['VENCIMIENTO'];
 $calle = $data['data']['calle'];
 $idciudadano = $data['data']['idciudadano'];
 $EJEMPLAR = $data['data']['EJEMPLAR'];
 $fechaNacimiento = $data['data']['fechaNacimiento'];
 $ID_TRAMITE_PRINCIPAL = $data['data']['ID_TRAMITE_PRINCIPAL'];
 $departamento = $data['data']['departamento'];
 $mensaf = $data['data']['mensaf'];
 $result1 = $data['result'];

    if ($result1 == true) {
    send_message($chat_id,$message_id, "***✅ DNI VALIDADO BY 
DNI: $dni
Nombre: $nombres $apellido
Cuil: $cuil
Nacimiento: $fechaNacimiento
Numero de Tramite: $ID_TRAMITE_PRINCIPAL
Id Ciudadano: $idciudadano
Emi y venc: $EMISION $VENCIMIENTO
Ejemplar: $EJEMPLAR
Fallecimiento: $mensaf
Calle: $calle
Altura: $numero
Piso: $piso
Departamento: $departamento
Provincia: $provincia
Ciudad: $ciudad
Municipio: $municipio
Codigo Postal: $cpostal
Checked By @$username ***");
    }
else {
    send_message($chat_id,$message_id, "*** ⛔ No Hay Sistema intenta Nuevamente en 10 Minutos ⚠️***");
}
}
    function send_message($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text&parse_mode=Markdown");
    }
?>
