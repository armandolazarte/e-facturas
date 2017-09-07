<?php
namespace common\models;

//require("./sendgrid-php/sendgrid-php.php");
include(dirname(__FILE__) .DIRECTORY_SEPARATOR.'sendgrid-php'.DIRECTORY_SEPARATOR.'sendgrid-php.php');
//require(realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'sendgrid-php'.DIRECTORY_SEPARATOR.'sendgrid-php.php');



use Yii;
use SendGrid;
use yii\validators\EmailValidator;
use yii\helpers\Url;

class Email  
{
	

	
	public static function sendMultipleWithTransport($from, $email, $subject, $body, $arrayMails, $transport_email, 
		$transport_pass, $transport_smtp, $transport_port, $arrayEmailsReplyTo)
	{

		if ($arrayMails == null) {
			$arrayMails = array();
		}
		
		$arrayMails = array_unique($arrayMails);
		/*
		if (Yii::$app->user->identity->empresaid == 41) {
			echo '<br><br><br><br><br>';
			echo '['. $from .']';
			echo '<br><br>';
			echo '['. $email .']';
			echo '<br><br>';
			echo '['. $subject .']';
			echo '<br><br>';
			print_r($arrayMails);
			echo '<br><br>';
			print_r($arrayEmailsReplyTo);
			echo '<br><br>';			
			echo '['. $transport_email .']';
			echo '<br><br>';
			echo '['. $transport_pass .']';
			echo '<br><br>';
			echo '['. $transport_smtp .']';			
			echo '<br><br>';
			echo '['. $transport_port .']';			
			exit();
		}
		*/
		
		
		//if (Yii::$app->user->identity->empresaid == 41) {
			//$email = 'rdevicenzi@gmail.com';
			//$arrayMails = array();//['rdevicenzi@gmail.com'];
			//print_r($email);
			//exit();
		//}
				

	
		$transporte = [
				'class' => 'Swift_SmtpTransport',
				'host' => trim($transport_smtp),
				'username' => trim($transport_email),
				'password' => $transport_pass,
				'port' => ($transport_port),
				'encryption' => 'tls',
		];
		
		$mailer = Yii::$app->mailer;
		
		$mailer->setTransport($transporte);
		
		$mailer->compose()
			->setFrom([$transport_email => $from])
			->setTo(trim($email))
			->setBcc($arrayMails)
			->setReplyTo($arrayEmailsReplyTo)
			->setSubject($subject)
			->setHtmlBody($body)
			->send();
		
		
	}

	public static function sendMultiple($from, $email, $subject, $body, $arrayMails, $arrayEmailsReplyTo, $modo_envio_fe)
	{

		$arrayMails = ($arrayMails == null) ? array() : $arrayMails;
		$arrayMails = array_unique($arrayMails);		

		if ($modo_envio_fe == 'SI') {

			$ReplyTo = (isset($arrayEmailsReplyTo[0])) ? $arrayEmailsReplyTo[0] : 'no-reply@notificacion-fe.com' ;

			$API_KEY = '';
			
			$FROM_EMAIL = $ReplyTo; //'no-reply@fe.com';

			$TO_EMAIL = $email;

			$from = new SendGrid\Email($from, $FROM_EMAIL);
			$to = new SendGrid\Email(null, $TO_EMAIL);
			$content = new SendGrid\Content("text/html",$body);
			$mail = new SendGrid\Mail($from, $subject, $to, $content);
			//$mail->personalization[0]->addBcc($arrayMails[0]);			

			$sg = new \SendGrid($API_KEY);

			$response = $sg->client->mail()->send()->post($mail);

			
			foreach ($arrayMails as $key => $email) {
				$TO_EMAIL = $email;
				//$from = new SendGrid\Email($from, $FROM_EMAIL);
				$to = new SendGrid\Email(null, $TO_EMAIL);
				$content = new SendGrid\Content("text/html",$body);
				$mail = new SendGrid\Mail($from, $subject, $to, $content);
				
				//$sg = new \SendGrid($API_KEY);

				$response = $sg->client->mail()->send()->post($mail);				
			}
		
		/*			
			if ($response->statusCode() == 202) {
				echo 'done';
			} else {
				echo 'false';
			}
			echo $response->body();
			print_r($response->headers());
		*/


		}
		else {
			Email::sendMultiple_old($from, $email, $subject, $body, $arrayMails, $arrayEmailsReplyTo);
		}



	}
	
	public static function sendMultiple_old($from, $email, $subject, $body, $arrayMails, $arrayEmailsReplyTo)
	{
		
		$arrayMails = ($arrayMails == null) ? array() : $arrayMails;
		$arrayMails = array_unique($arrayMails);		

		
					
				$ARRAY_MAIL_FROM = [				
						'notificacion.airtech@gmail.com',
						'notificacion.airtech.fe@gmail.com',
						'test.envio.facturas@gmail.com',	
						'mail.notificacion.fe@gmail.com',
						'notificacion.fe.mail@gmail.com',
						'fe.mail.notificacion@gmail.com',
						'empresas.fe.no.reply@gmail.com',
						'airtech.notificacion.fe@gmail.com',
						'noticacion.facturas.airtech@gmail.com',
						'facturas.envios.airtech@gmail.com',
						'facturas.envios.airtech@gmail.com',
						'airtech.fe.envios@gmail.com',
						'airtech.fe.envios@gmail.com',
						'fe.envios.airtech@gmail.com',
						'fe.envios.airtech@gmail.com',

					];
				shuffle($ARRAY_MAIL_FROM);
				
				$transport_smtp = 'smtp.gmail.com';
				$transport_email = $ARRAY_MAIL_FROM[0];
				$transport_pass = 'gangrela1234';
				$transport_port = '587';

				if (Yii::$app->user->identity->empresaid == 41) {
					$transport_email = 'airtech.notificacion.fe@gmail.com';
					//$transport_email = 'no-reply@airtech-it.com.ar';
					//$transport_smtp = 'smtp-relay.gmail.com';
				}						

				$transporte = [
						'class' => 'Swift_SmtpTransport',
						'host' => trim($transport_smtp),
						'username' => trim($transport_email),
						'password' => $transport_pass,
						'port' => ($transport_port),
						'encryption' => 'tls',
				];
				
				$mailer = Yii::$app->mailer;
				
				$mailer->setTransport($transporte);
				
				$mailer->compose()
					->setFrom([$transport_email => $from])
					->setTo(trim($email))
					->setBcc($arrayMails)
					->setReplyTo($arrayEmailsReplyTo)
					->setSubject($subject)
					->setHtmlBody($body)
					->send();


		//###########################################################################################
		//###########################################################################################
		
		/*

		$mail = Yii::$app->mailer->compose();
		$mail->setFrom([\Yii::$app->params['supportEmail'] => $from]);
		$mail->setSubject(trim($subject));
		$mail->setHtmlBody($body);
		foreach($arrayMails as $receiver){
			$mail->setTo(trim($receiver));
			$mail->send();
		}

		*/
	}
	
	
	
	
	public static function validate($email) 
	{
		$validator = new EmailValidator();
		
		if ($validator->validate($email)) {
			return true;
		}
		
		return false;
	}
	public static function bodyTemplate($nombre, $comprobante_nro, $facturaLink, $punto_venta, $mensaje = null) {
		
		$btn_label = 'Ver Factura';
		$titulo = 'Estimado/a <b>'. strtoupper(trim($nombre)) .'</b>';
		$contenido = 'Le comunicamos que ya tiene a su disposici&oacute;n el'
					. ' comprobante electr&oacute;nico ' . '<b>' . $comprobante_nro . '</b>';
		
		$mensajeHTML = '<br><br>' . $mensaje . '<br><br>';
		
		$contenido = ($mensaje !== null && $mensaje !== '') ? $contenido .= $mensajeHTML : $contenido;
		
		$logoURL = Url::base('http') . '/uploads/' . Yii::$app->user->identity->empresaid . '_' . $punto_venta . '_modelo_3.jpg';
		$logoURL_b = Url::base('http') . '/uploads/' . Yii::$app->user->identity->empresaid . '_modelo_3.jpg';
// 		$logoURL = 'http://empresas.e-facturas.com.ar:85/uploads/' . Yii::$app->user->identity->empresaid . '_modelo_3.jpg';
		
		//*usamos la funcion php "fopen" con el atributo para leer archivo "r"*//
		
		$existeLogoURL = @fopen($logoURL,"r");
		if (!$existeLogoURL) {
			$existeLogoURL = @fopen($logoURL_b,"r");
			$logoURL = $logoURL_b;
		}
		
		$logoHTML = '<tr><td style="text-align: center;"><img src="' . $logoURL . '"/></td></tr>';
		// SI NO EXISTE EL LOGO NO SE MUESTRA NINGUNA IMAGEN
		$logoEmpresa = ($existeLogoURL) ? $logoHTML : '';
		
		$body = '<table style="background-color: #f6f6f6; width: 100%; font-family: sans-serif;" >
				    <tr>
				        <td></td>
				        <td style="display: block !important; 
							max-width: 500px !important;
									width: 500px;
									margin: 0 auto !important;		
									clear: both !important;
									">
				            <div style="max-width: 600px;
										margin: 0 auto;
										display: block;
										padding: 20px;
										">
				                <table style="background: #fff;
												border: 1px solid #e9e9e9;
												border-radius: 3px;
												width: 100%; 
												cellpadding: 0; 
												cellspacing: 0
												">
				                    <tr>
				                        <td style="padding: 20px;">
				                            <table  cellpadding="0" cellspacing="0">
												' . $logoEmpresa . '
				                                <tr>
				                                    <td style="padding: 0 0 20px;">
				                                        <br>
														'. $titulo .'
				                                    </td>
				                                </tr>
				                                <tr>
				                                    <td style="padding: 0 0 20px;">'
				                                    .  $contenido
				                                    .'</td>
				                                </tr>
				                                <tr>
				                                    <td style="padding: 0 0 20px; text-align: center">
				                                    	<br>
				                                        <a href="'. $facturaLink .'" target="_blank"
				                                        		onmouseover="this.style.backgroundColor='. "'#3cb0fd'" .'"
				                                        		onmouseout="this.style.backgroundColor='. "'#329ce3'" .'" 
															style="
				                                        		text-decoration: none;
																	text-align: center;
																	cursor: pointer;
																	  color: #ffffff;
																	  font-size: 18px;
																	  background: #329ce3;
																	  padding: 10px 20px 10px 20px;
																	  text-decoration: none;
				                                        			border-radius: 4px;
														">
														'. $btn_label .'</a>
				                                    </td>
				                                </tr>
				                              </table>
				                        </td>
				                    </tr>
				                </table>
				                <div style="width: 100%; color: #333;">
				                    <table width="100%">
				                        <tr>
				                            <td style="text-align: center;">
											En caso de no poder acceder a la factura, haga <a href="'. $facturaLink 
											.'" target="_blank" style="text-decoration: none; color: #329ce3; font-weight:bold;">click aqu&iacute;</a>
											</td>
				                        </tr>
				                    </table>
				                </div></div>
				        </td>
				        <td></td>
				    
				    </tr>


				</table>
				';
		
// 		echo $body;
// 		exit();
		
		return $body;
	}
	
}
