<?php if (!defined("AT_DIR")) die('!!!'); ?>
<div class="main_wrapper">
	<h1><?php _e( 'Payment System (BETA)', AT_TEXTDOMAIN ); ?></h1>


	<?php echo sprintf( __( 'You\'re going to promote %s with paid service.', AT_TEXTDOMAIN ), '<strong>' . $cars['post_title'] . '</strong>' ); ?>

	<p>&nbsp;</p>

	<?php
/**-------------------Alteração Elcior Audax - Nov/2016----------------------------**/
/**
 * @script: trata os dados enviados pelo formulario em prepare.php. os guarda no banco e os envia para o pagseguro.
 * 
 */
	if(isset($_POST['token'])){
		$email						= !empty($_POST['email']) ? $_POST['email'] : 'elcior@grupoaudax.com.br';
		$token						= !empty($_POST['token']) ? $_POST['token'] : 'F9B570DBED97418F8C036FEFA34F30EC';
		$currency					= !empty($_POST['currency']) ? $_POST['currency'] : 'BRL';
		$itemId1					= !empty($_POST['itemId1']) ? $_POST['itemId1'] : '0001_webcarretas';
		$itemDescription1			= !empty($_POST['itemDescription1']) ? $_POST['itemDescription1'] : 'Impulsionamento de Campanha';
		$itemAmount1				= !empty($_POST['itemAmount1']) ? $_POST['itemAmount1'] : '1.00';
		$itemQuantity1				= !empty($_POST['itemQuantity1']) ? $_POST['itemQuantity1'] : '1';
		$itemWeight1				= !empty($_POST['itemWeight1']) ? $_POST['itemWeight1'] : '1.00';
		$reference					= !empty($_POST['reference']) ? $_POST['reference'] : 'REF12345';
		$senderName					= !empty($_POST['senderName']) ? $_POST['senderName'] : '';
		$senderAreaCode				= !empty($_POST['senderAreaCode']) ? $_POST['senderAreaCode'] : '';
		$senderPhone				= !empty($_POST['senderPhone']) ? $_POST['senderPhone'] : '';
		$senderEmail				= !empty($_POST['senderEmail']) ? $_POST['senderEmail'] : '';
		$shippingType				= !empty($_POST['shippingType']) ? $_POST['shippingType'] : '0';
		$shippingAddressStreet		= !empty($_POST['shippingAddressStreet']) ? $_POST['shippingAddressStreet'] : '';
		$shippingAddressNumber		= !empty($_POST['shippingAddressNumber']) ? $_POST['shippingAddressNumber'] : '';
		$shippingAddressComplement	= !empty($_POST['shippingAddressComplement']) ? $_POST['shippingAddressComplement'] : '';
		$shippingAddressDistrict	= !empty($_POST['shippingAddressDistrict']) ? $_POST['shippingAddressDistrict'] : '';
		$shippingAddressPostalCode	= !empty($_POST['shippingAddressPostalCode']) ? $_POST['shippingAddressPostalCode'] : '';
		$shippingAddressCity		= !empty($_POST['shippingAddressCity']) ? $_POST['shippingAddressCity'] : '';
		$shippingAddressState		= !empty($_POST['shippingAddressState']) ? $_POST['shippingAddressState'] : '';
		$shippingAddressCountry		= !empty($_POST['shippingAddressCountry']) ? $_POST['shippingAddressCountry'] : 'BRA';
	}

	global $wpdb;
	//Verifica se o email já existe no banco de dados. Se não existe, cadastrar os dados do usuário.
	$retorno_senderemail = $wpdb->get_var("SELECT senderEmail FROM web_carretas_clientes_pagseguro WHERE senderEmail = '$senderEmail'");
	if( !($retorno_senderemail) ){

		$wpdb->insert( 
			'web_carretas_clientes_pagseguro', 
			array('senderName' 				=> $senderName,
				'senderAreaCode' 			=> $senderAreaCode,
				'senderPhone' 				=> $senderPhone,
				'senderEmail' 				=> $senderEmail,
				'shippingAddressStreet' 	=> $shippingAddressStreet,
				'shippingAddressNumber'		=> $shippingAddressNumber,
				'shippingAddressComplement' => $shippingAddressComplement,
				'shippingAddressDistrict' 	=> $shippingAddressDistrict,
				'shippingAddressPostalCode' => $shippingAddressPostalCode,
				'shippingAddressCity' 		=> $shippingAddressCity,
				'shippingAddressState' 		=> $shippingAddressState
			), 
			array( '%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
			)
		);
	}

	//Verifica se o email foi enviado recursivamente pelo formulário, se sim mostrar o botão de redirecionamento do pagSeguro. Senão, exibir o formulário de cadastro de informações
	if(empty($_POST['senderEmail'])) {
		/*echo '<h2 style="color: red">Confirme os dados abaixo e clique no botão para ser reedirecionado.</h2>';*/
		/**-------------------Alteração Elcior Audax - Nov/2016----------------------------**/
	?>
	<!-- INICIO FORMULARIO BOTAO PAGSEGURO 
	<form action="https://pagseguro.uol.com.br/pre-approvals/request.html" method="post">
		// NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO 
		<input type="hidden" name="code" value="D04ED42A3E3ED1F444595FBDEB2A10D1" />
		<input type="hidden" name="iot" value="button" />
		<input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/assinaturas/120x53-assinar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
	</form>
	// FINAL FORMULARIO BOTAO PAGSEGURO -->
		<form action="#" method="POST">
			<h2>Preencha o formulário com suas informações.</h2>
	<?php } else { ?>
		<form action="requisicao_pagseguro.php" method="POST">
			<h2>Confirme suas informações. Você será redirecionado a página do PagSeguro para finaliza a assinatura do impulsionamento.</h2>
	<?php } ?>
			<!--<h2><?php // _e( 'Select Plan', AT_TEXTDOMAIN ); ?></h2>
			<?php // _e( 'Please specify your plan', AT_TEXTDOMAIN ); ?>-->
			
			<div class="form-group hidden">
		    	<input type="email" class="form-control" id="email" name="email" value="elcior@grupoaudax.com.br" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="token" name="token" value="F9B570DBED97418F8C036FEFA34F30EC" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="currency" name="currency" value="BRL" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="itemId1" name="itemId1" value="0001_webcarretas" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="itemDescription1" name="itemDescription1" value="Impulsionamento de Campanha" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="itemAmount1" name="itemAmount1" value="1.00" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="itemQuantity1" name="itemQuantity1" value="1" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="itemWeight1" name="itemWeight1" value="1.00" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="reference" name="reference" value="REF12345" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="senderName">Nome Completo</label><br>
		    	<input type="text" class="form-control" id="senderName" name="senderName" value="<?php if(!empty($senderName)) echo $senderName; ?>" required >
		 	</div>
		 	<div class="row">
			 	<div class="form-group col-md-3">
			    	<label class="control-label" for="senderAreaCode">DDD</label><br>
			    	<input type="text" class="form-control" id="senderAreaCode" name="senderAreaCode" value="<?php if(!empty($senderAreaCode)) echo $senderAreaCode; ?>" maxlength="2" required >
			 	</div>	 	
			 	<div class="form-group col-md-9">
			    	<label class="control-label" for="senderPhone">Telefone</label><br>
			    	<input type="text" class="form-control" id="senderPhone" name="senderPhone" value="<?php if(!empty($senderPhone)) echo $senderPhone; ?>" required >
			 	</div>
			</div>
		 	<div class="form-group">
		    	<label class="control-label" for="senderEmail">Email</label><br>
		    	<input type="email" class="form-control" id="senderEmail" name="senderEmail" value="<?php if(!empty($senderEmail)) echo $senderEmail; ?>" required >
		 	</div>		
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="shippingType" name="shippingType" value="0" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressStreet">Endereço</label><br>
		    	<input type="text" class="form-control" id="shippingAddressStreet" name="shippingAddressStreet" value="<?php if(!empty($shippingAddressStreet)) echo $shippingAddressStreet; ?>" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressNumber">Número</label><br>
		    	<input type="text" class="form-control" id="shippingAddressNumber" name="shippingAddressNumber" value="<?php if(!empty($shippingAddressNumber)) echo $shippingAddressNumber; ?>" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressComplement">Complemento</label><br>
		    	<input type="text" class="form-control" id="shippingAddressComplement" name="shippingAddressComplement" value="<?php if(!empty($shippingAddressComplement)) echo $shippingAddressComplement; ?>" >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressDistrict">Bairro</label><br>
		    	<input type="text" class="form-control" id="shippingAddressDistrict" name="shippingAddressDistrict" value="<?php if(!empty($shippingAddressDistrict)) echo $shippingAddressDistrict; ?>" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressPostalCode">CEP</label><br>
		    	<input type="text" class="form-control" id="shippingAddressPostalCode" name="shippingAddressPostalCode" value="<?php if(!empty($shippingAddressPostalCode)) echo $shippingAddressPostalCode; ?>" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressCity">Cidade</label><br>
		    	<input type="text" class="form-control" id="shippingAddressCity" name="shippingAddressCity" value="<?php if(!empty($shippingAddressCity)) echo $shippingAddressCity; ?>" required >
		 	</div>
		 	<div class="form-group">
		    	<label class="control-label" for="shippingAddressState">Estado</label><br>
		    	<input type="text" class="form-control" id="shippingAddressState" name="shippingAddressState" value="<?php if(!empty($shippingAddressState)) echo $shippingAddressState; ?>" maxlength="2" required >
		 	</div>
		 	<div class="form-group hidden">
		    	<input type="text" class="form-control" id="shippingAddressCountry" name="shippingAddressCountry" value="BRA" required >
		 	</div>

			<input type="submit" value="<?php _e( 'Order now', AT_TEXTDOMAIN ); ?>" />
		</form>	
	<p>&nbsp;</p>
	<?php
	}
	?>

</div>