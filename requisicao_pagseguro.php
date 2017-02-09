<?php
$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

//$data = 'email=seuemail@dominio.com.br&amp;token=95112EE828D94278BD394E91C4388F20&amp;currency=BRL&amp;itemId1=0001&amp;itemDescription1=Notebook Prata&amp;itemAmount1=24300.00&amp;itemQuantity1=1&amp;itemWeight1=1000&amp;itemId2=0002&amp;itemDescription2=Notebook Rosa&amp;itemAmount2=25600.00&amp;itemQuantity2=2&amp;itemWeight2=750&amp;reference=REF1234&amp;senderName=Jose Comprador&amp;senderAreaCode=11&amp;senderPhone=56273440&amp;senderEmail=comprador@uol.com.br&amp;shippingType=1&amp;shippingAddressStreet=Av. Brig. Faria Lima&amp;shippingAddressNumber=1384&amp;shippingAddressComplement=5o andar&amp;shippingAddressDistrict=Jardim Paulistano&amp;shippingAddressPostalCode=01452002&amp;shippingAddressCity=Sao Paulo&amp;shippingAddressState=SP&amp;shippingAddressCountry=BRA';
/*
Caso utilizar o formato acima remova todo código abaixo até instrução $data = http_build_query($data);
*/

$data['email'] 						= !empty($_POST['email']) ? $_POST['email'] : 'elcior@grupoaudax.com.br';
$data['token'] 						= !empty($_POST['token']) ? $_POST['token'] : 'F9B570DBED97418F8C036FEFA34F30EC';
$data['currency'] 					= !empty($_POST['currency']) ? $_POST['currency'] : 'BRL';
$data['itemId1'] 					= !empty($_POST['itemId1']) ? $_POST['itemId1'] : '0001_webcarretas';
$data['itemDescription1'] 			= !empty($_POST['itemDescription1']) ? $_POST['itemDescription1'] : 'Impulsionamento de Campanha';
$data['itemAmount1'] 				= !empty($_POST['itemAmount1']) ? $_POST['itemAmount1'] : '1.00';
$data['itemQuantity1'] 				= !empty($_POST['itemQuantity1']) ? $_POST['itemQuantity1'] : '1';
$data['itemWeight1'] 				= !empty($_POST['itemWeight1']) ? $_POST['itemWeight1'] : '1.00';
$data['reference'] 					= !empty($_POST['reference']) ? $_POST['reference'] : 'REF12345';
$data['senderName'] 				= !empty($_POST['senderName']) ? $_POST['senderName'] : '';
$data['senderAreaCode'] 			= !empty($_POST['senderAreaCode']) ? $_POST['senderAreaCode'] : '';
$data['senderPhone'] 				= !empty($_POST['senderPhone']) ? $_POST['senderPhone'] : '';
$data['senderEmail'] 				= !empty($_POST['senderEmail']) ? $_POST['senderEmail'] : '';
$data['shippingType'] 				= !empty($_POST['shippingType']) ? $_POST['shippingType'] : '0';
$data['shippingAddressStreet'] 		= !empty($_POST['shippingAddressStreet']) ? $_POST['shippingAddressStreet'] : '';
$data['shippingAddressNumber'] 		= !empty($_POST['shippingAddressNumber']) ? $_POST['shippingAddressNumber'] : '';
$data['shippingAddressComplement'] 	= !empty($_POST['shippingAddressComplement']) ? $_POST['shippingAddressComplement'] : '';
$data['shippingAddressDistrict'] 	= !empty($_POST['shippingAddressDistrict']) ? $_POST['shippingAddressDistrict'] : '';
$data['shippingAddressPostalCode'] 	= !empty($_POST['shippingAddressPostalCode']) ? $_POST['shippingAddressPostalCode'] : '';
$data['shippingAddressCity'] 		= !empty($_POST['shippingAddressCity']) ? $_POST['shippingAddressCity'] : '';
$data['shippingAddressState'] 		= !empty($_POST['shippingAddressState']) ? $_POST['shippingAddressState'] : '';
$data['shippingAddressCountry'] 	= !empty($_POST['shippingAddressCountry']) ? $_POST['shippingAddressCountry'] : 'BRA';
$data['redirectURL'] 				= 'http://www.sounoob.com.br/paginaDeAgracedimento';

$data = http_build_query($data);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$xml= curl_exec($curl);

if($xml == 'Unauthorized'){
//Insira seu código de prevenção a erros

	header('Location: erro.php?tipo=autenticacao');
exit;//Mantenha essa linha
}
curl_close($curl);

$xml= simplexml_load_string($xml);
if(count($xml -> error) > 0){
//Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.

	header('Location: erro.php?tipo=dadosInvalidos');
	exit;
}
header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);