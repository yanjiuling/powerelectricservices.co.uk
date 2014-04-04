<?php
function formSubmit($recipients)
{	
	global $globalSettings,$lang;
	
	include_once(SRV_ROOT."forms/Akismet.class.php");
	$akismet_key = "8555458f1288";
	
	if(isset($_POST['submit']))
	{	
		$errors = array(); // set the errors array to empty, by default
		$fields = array(); // stores the field values
		$rules = array(); // stores the validation rules

		switch($_POST['form'])
		{
			case "callback":
			$subject = "Call back request";
			$greeting = "You have received the following callback request";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Enter your name.";
			$rules[] = "required,phone,Enter your phone number.";
			$rules[] = "reg_exp,phone,^[\d|\+|\(]+[\)|\d|\s|-]*[\d]$,The phone number you entered was invalid.";
			$rules[] = "required,best_time,Specify a call time";
			$rules[] = "required,enquiry,Enter your message.";
			break;
			
			case "enquiry":
			$subject = "Online enquiry";
			$greeting = "You have received the following equiry.";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Enter your name.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			$rules[] = "required,enquiry,Enter your message.";
			break;

			case "newsletter":
			$subject = "Newsletter Subscription";
			$greeting = "You have received the following newsletter subcription.";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Enter your name.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			break;

			case "contact":
			$subject = "Online enquiry";
			$greeting = "You have received the following equiry.";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Please enter your name.";
			$rules[] = "required,email,Please enter your email address.";
			$rules[] = "valid_email,email,Please enter a valid email address.";
			$rules[] = "required,phone,Please enter your phone number.";
			break;

			case "complaint":
			$subject = "Online complaint";
			$greeting = "You have received the following complaint.";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,matterreference,Enter a reference number";
			$rules[] = "required,firstname,Enter your first name(s).";
			$rules[] = "required,lastname,Enter your surname.";
			$rules[] = "required,phone,Enter your phone number.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			$rules[] = "required,complaint,Enter your complaint.";
			break;

			case "payment":
			$rules[] = "required,desc,Select your payment type";
			$rules[] = "required,cartId,Enter the invoice number or your account reference.";
			$rules[] = "required,amount,Enter the value of your payment.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			break;

			case "residential_property_estimate":
			$subject = "Residential property: estimate request";
			$greeting = "You have received the following estimate request.";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Enter your name.";
			$rules[] = "required,phone,Enter your phone number.";
			$rules[] = "reg_exp,phone,^[\d|\+|\(]+[\)|\d|\s|-]*[\d]$,The phone number you entered was invalid.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			break;

			case "fi-claim-review":
			$subject = "Financial Instrument Claim Review";
			$greeting = "";
			$success = lang('SEND_SUCCESS');
			$rules[] = "required,name,Enter your name.";
			$rules[] = "required,phone,Enter your phone number.";
			$rules[] = "reg_exp,phone,^[\d|\+|\(]+[\)|\d|\s|-]*[\d]$,The phone number you entered was invalid.";
			$rules[] = "required,email,Enter your email address.";
			$rules[] = "valid_email,email,Enter a valid email address.";
			break;
		}		

		$errors = validateFields($_POST, $rules);

		if(isset($_POST['captcha']))
		{
			if($_SESSION['security_code'] == $_POST['captcha'] && !empty($_SESSION['security_code'])) 
			{
				unset($_SESSION['security_code']);
			}
			else
			{
				$errors[] = lang("ERR_CAPTCHA");
			}
		}

		switch($_POST['type'])
		{
			case "contact":


				$origin				= isset($_POST['origin'])?$_POST['origin']:'';
				$matterreference	= isset($_POST['matterreference'])?$_POST['matterreference']:'';
				$salutation 		= isset($_POST['salutation'])?$_POST['salutation']:'';
				$name 				= isset($_POST['name'])?$_POST['name']:'';
				$firstname			= isset($_POST['firstname'])?$_POST['firstname']:'';
				$lastname			= isset($_POST['lastname'])?$_POST['lastname']:'';
				$name 				= !($firstname == '' && $lastname == '')?$firstname.' '.$lastname:$name;
				$name				= $salutation.' '.$name;
				$name				= trim($name);
				$address 			= isset($_POST['address'])?$_POST['address']:'';
				$town 				= isset($_POST['town'])?$_POST['town']:'';
				$postcode 			= isset($_POST['postcode'])?$_POST['postcode']:'';
				$email 				= isset($_POST['email'])?$_POST['email']:'';
				$phone				= isset($_POST['phone'])?$_POST['phone']:'';
				$mobile				= isset($_POST['mobile'])?$_POST['mobile']:'';
				$action				= isset($_POST['action'])?$_POST['action']:'';
				$best_time			= isset($_POST['best_time'])?$_POST['best_time']:'';
				$address			= isset($_POST['address'])?$_POST['address']:'';
				$enquiry			= isset($_POST['enquiry'])?$_POST['enquiry']:'';
				$complaint			= isset($_POST['complaint'])?$_POST['complaint']:'';
				$nl_private			= isset($_POST['nl_private'])?$_POST['nl_private']:'';
				$nl_commercial		= isset($_POST['nl_commercial'])?$_POST['nl_commercial']:'';
				$newsletter 		= '';
				$newsletter 		.= $nl_private !='' ? $nl_private : '';
				$newsletter 		.= !($nl_private == '' && $nl_commercial == '') ? ', ' : '';
				$newsletter 		.= $nl_commercial !='' ? $nl_commercial : '';
				$servicearea		= isset($_POST['whatservicearea'])?$_POST['whatservicearea']:'';
				$office				= isset($_POST['whatbranch'])?$_POST['whatbranch']:'';
				$contactmethod		= isset($_POST['contactmethod'])?$_POST['contactmethod']:'';
				$buyingleasehold 	= isset($_POST['buyingleasehold'])?$_POST['buyingleasehold']:'';
				$buyingprice	 	= isset($_POST['buyingprice'])?$_POST['buyingprice']:'';
				$buyingcomments	 	= isset($_POST['buyingcomments'])?$_POST['buyingcomments']:'';
				$sellingleasehold	= isset($_POST['sellingleasehold'])?$_POST['sellingleasehold']:'';
				$sellingprice	 	= isset($_POST['sellingprice'])?$_POST['sellingprice']:'';
				$sellingcomments 	= isset($_POST['sellingcomments'])?$_POST['sellingcomments']:'';
				$file_attach 		= '';
				$permalink			= isset($_POST['permalink'])?$_POST['permalink']:SITE_URL;
				
				$spam = false;

				//Akismet
				$akismet = new Akismet(SITE_URL ,$akismet_key);
				$akismet->setCommentAuthor($name);
				$akismet->setCommentAuthorEmail($email);
				//$akismet->setCommentAuthorURL($url);
				
				$msg = '';
				if($enquiry !='') $msg = $enquiry;
				if($complaint !='') $msg = $complaint;
				if($buyingcomments.$sellingcomments !='') $message =$buyingcomments.' '.$sellingcomments;
				if($msg !='')
				{
					$akismet->setCommentContent($msg);
				}
				$akismet->setPermalink($permalink);
				
				if($akismet->isCommentSpam())
				{
				  $subject = "[POSSIBLE SPAM] ".$subject;
				  $spam = true;
				}				
				
				if (!empty($errors))
				{  
					$fields = stripslashes_array($_POST); // re-populate the form fields
					$message=lang("ERR_HEAD");
					errorBlock($errors,$message);
				}
				else 
				{

			
					$addresses = explode(",",$recipients);
	
					$html_content	 = "<p>$greeting</p>";
					$html_content	.= "<h2>Sender details</h2>";
					$html_content	.= "<p>";
					$html_content 	.= $origin != '' 		? 		"<strong>Page:</strong> ".stripslashes($origin)."<br/>\r\n" : "";
					$html_content 	.= $matterreference != '' 	? 	"<strong>Matter reference No.:</strong> ".stripslashes($matterreference)."<br/>\r\n" : "";
					$html_content 	.= $name != '' 			? 		"<strong>Name:</strong> ".stripslashes($name)."<br/>\r\n" : "";
					$html_content 	.= $address != '' 		? 		"<strong>Address:</strong><br/>".nl2br(stripslashes($address))."<br/>\r\n" : "";
					$html_content   .= $town != '' 			?		"<strong>Town:</strong> ".stripslashes($town)."<br/>\r\n" : "";
					$html_content   .= $postcode != '' 		? 		"<strong>Postcode:</strong> ".stripslashes($postcode)."<br/>\r\n" : "";
					$html_content   .= $phone != '' 		? 		"<strong>Phone:</strong> ".stripslashes($phone)."<br/>\r\n" : "";
					$html_content   .= $mobile != '' 		? 		"<strong>Mobile:</strong> ".stripslashes($mobile)."<br/>\r\n" : "";
					$html_content   .= $email != '' 		? 		"<strong>Email:</strong> ".stripslashes($email)."<br/>\r\n" : "";
					$html_content   .= $servicearea != '' 	? 		"<strong>Service area:</strong> ".stripslashes($servicearea)."<br/>\r\n" : "";
					$html_content   .= $office != '' 		? 		"<strong>Office:</strong> ".stripslashes($office)."<br/>\r\n" : "";
					$html_content   .= $contactmethod != '' ? 		"<strong>Preferred contact method:</strong> ".stripslashes($contactmethod)."<br/>\r\n" : "";
					$html_content   .= $action != '' 		? 		"<strong>Action:</strong> ".stripslashes($action)."<br/>\r\n" : "";
					$html_content   .= $newsletter != '' 	? 		"<strong>Newsletter(s):</strong> ".stripslashes($newsletter)."<br/>\r\n" : "";
					$html_content   .= $best_time != '' 	? 		"<strong>Best time to call:</strong> ".stripslashes($best_time)."<br/>\r\n" : "";
					$html_content   .= "</p>\r\n\r\n";		
					
					if($_POST['form'] == "residential_property_estimate")
					{
						if($buyingleasehold.$buyingprice.$buyingcomments != '')
						{
							$html_content	.= "<h2>Buying:</h2>\r\n\r\n<p>";
							$html_content   .= $buyingleasehold != '' ? "<strong>Leasehold:</strong> ".stripslashes($buyingleasehold)."<br/>\r\n" : "";
							$html_content   .= $buyingprice != '' ? "<strong>Price:</strong> ".stripslashes($buyingprice)."\r\n" : "";
							$html_content   .= "</p>\r\n\r\n";
							$html_content   .= $buyingcomments != ''	?	"<p>".stripslashes(nl2br($buyingcomments))."</p>" : "";
						}
						if($sellingleasehold.$sellingprice.$sellingcomments != '')
						{
							$html_content	.= "<h2>Selling:</h2>\r\n\r\n<p>";
							$html_content   .= $sellingleasehold != '' ? "<strong>Leasehold:</strong> ".stripslashes($sellingleasehold)."<br/>\r\n" : "";
							$html_content   .= $sellingprice != '' ? "<strong>Price:</strong> ".stripslashes($sellingprice)."\r\n" : "";
							$html_content   .= "</p>\r\n\r\n";
							$html_content   .= $sellingcomments != ''	?	"<p>".stripslashes(nl2br($sellingcomments))."</p>" : "";
						}
					}
	
					
					if($_POST['form'] == "fi-claim-review")
					{
						$fi_claim_bank			= isset($_POST['fi_claim_bank']) ? $_POST['fi_claim_bank'] : '';
						$fi_claim_add_prod		= isset($_POST['fi_claim_add_prod']) ? $_POST['fi_claim_add_prod'] : '';
						$fi_claim_guarantee		= isset($_POST['fi_claim_guarantee']) ? $_POST['fi_claim_guarantee'] : '';
						$fi_loan_dates			= isset($_POST['fi_loan_dates']) ? $_POST['fi_loan_dates'] : '';
						$fi_claim_name			= isset($_POST['fi_claim_name']) ? $_POST['fi_claim_name'] : '';
						$fi_claim_position		= isset($_POST['fi_claim_position']) ? $_POST['fi_claim_position'] : '';
						$fi_claim_experience		= isset($_POST['fi_claim_experience']) ? $_POST['fi_claim_experience'] : '';
						$fi_claim_advised		= isset($_POST['fi_claim_advised']) ? $_POST['fi_claim_advised'] : '';
						$fi_claim_fixed_rate		= isset($_POST['fi_claim_fixed_rate']) ? $_POST['fi_claim_fixed_rate'] : '';
						$fi_claim_break_clauses	= isset($_POST['fi_claim_break_clauses']) ? $_POST['fi_claim_break_clauses'] : '';
						$fi_claim_fixed_rate		= isset($_POST['fi_claim_fixed_rate']) ? $_POST['fi_claim_fixed_rate'] : '';
						$fi_claim_loss			= isset($_POST['fi_claim_loss']) ? $_POST['fi_claim_loss'] : '';
						$fi_claim_otherinfo		= isset($_POST['fi_claim_otherinfo']) ? $_POST['fi_claim_otherinfo'] : '';
						
						$html_content	.= "<h2>Claim Details:</h2>\r\n\r\n";
						
						$html_content	.= $fi_claim_bank!='' ? "<h3>With what bank did you take out your loan?</h3>\r\n<p>$fi_claim_bank</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_add_prod!='' ? "<h3>Was it a condition of your loan that you took an additional product to protect the interest rate?</h3>\r\n\r\n<p>$fi_claim_add_prod</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_guarantee!='' ? "<h3>Was a personal guarantee given in respect of any part of the loan or other products?</h3>\r\n\r\n<p>$fi_claim_guarantee</p>\r\n\r\n" : '';
						$html_content	.= $fi_loan_dates!='' ? "<h3>Please provide dates of the loan agreements and any additional products that were taken out</h3>\r\n\r\n<p>".nl2br($fi_loan_dates)."</p>\r\n\r\n" : '';
						
						if($fi_claim_name.$fi_claim_position !='')
						{
							$html_content	.= "<h3>Who in your company would have been the decision maker(s) in relation to purchasing the product?</h3>\r\n\r\n<p>";
							$html_content	.= "<strong>Name:</strong> $fi_claim_name";
							$html_content	.= "<br/><strong>Job title:</strong> $fi_claim_position";
							$html_content	.= "</p>\r\n\r\n";
						}
						
						$html_content	.= $fi_claim_experience!='' ? "<h3>What experience did the decision maker(s) have of financial instruments?</h3>\r\n\r\n<p>".nl2br($fi_claim_experience)."</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_advised!='' ? "<h3>What did those decision makers understand about the product you were purchasing and what was advised by the bank at the time?</h3>\r\n\r\n<p>".nl2br($fi_claim_advised)."</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_fixed_rate!='' ? "<h3>Did you think the loan was fixed rate?</h3>\r\n\r\n<p>$fi_claim_fixed_rate</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_break_clauses!='' ? "<h3>Were you told about any break clauses and their consequences?</h3>\r\n\r\n<p>$fi_claim_break_clauses</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_loss!='' ? "<h3>What do you consider your loss to be and how has it arisen</h3>\r\n\r\n<p>".nl2br($fi_claim_loss)."</p>\r\n\r\n" : '';
						$html_content	.= $fi_claim_otherinfo!='' ? "<h3>Is there any other information which you feel may be relevant to your decision to take out the loan?</h3>\r\n\r\n<p>".nl2br($fi_claim_otherinfo)."</p>\r\n\r\n" : '';
						
					}
					$html_content   .= $enquiry != '' 		? 		"<h2>Message:</h2>\r\n\r\n
												 					<p>".stripslashes(nl2br($enquiry))."</p>" : "";
					$html_content   .= $complaint != '' 	? 		"<h2>Complaint:</h2>\r\n\r\n
												 					<p>".stripslashes(nl2br($complaint))."</p>" : "";
					
					$h2t = new html2text($html_content);
					$plain_text = $h2t->get_text();
					
					$html = file_get_contents(SRV_ROOT.'admin/templates/mail/email_header.php') .
							$html_content .
							file_get_contents(SRV_ROOT.'admin/templates/mail/email_footer.php');
										
					$mail = new PHPMailer(true); 


					try 
					{
						if(isset($globalSettings['use_smtp']) && $globalSettings['use_smtp']=='true')
						{
							$mail->IsSMTP();
							$mail->Host = $globalSettings['smtp_hosts'];
							$mail->SMTPAuth = $globalSettings['smtp_auth'];
							$mail->Username = $globalSettings['smtp_user'];
							$mail->Password = $globalSettings['smtp_pass'];
							$mail->SMTPSecure = $globalSettings['smtp_security']; 
							$mail->Port       = $globalSettings['smtp_port'];
						}
						foreach($addresses as $recipient)
						{
							$mail->AddAddress($recipient);
						}
						$mail->SetFrom($globalSettings['admin_email'], $globalSettings['from_name']);
						$mail->AddReplyTo($globalSettings['admin_email'], $globalSettings['from_name']);
						$mail->Subject = $subject;
						$mail->AddEmbeddedImage(SRV_ROOT.'images/'.ELOGO, SESSNAME.'_logoimg', ELOGO);
						if($file_attach !='')
						{
							$mail->AddAttachment($file_attach);
						}

						$mail->MsgHTML($html);
						$mail->AltBody = $plain_text;
						if ($mail->Send())
						{
							flash_message("success", $success);
						}
						else
						{
							flash_message("error", "There was a problem sending your message. Please try again later");
						}
					} 
					catch (phpmailerException $e) 
					{
						flash_message("error", $e->errorMessage());
					}					
				}
			
			break;
			
			case 'login':
			
				include_once(SRV_ROOT."login/functions.php");
				
				switch($_POST['form'])
				{
					case 'forgot-pass':
					
						$fields = forgotPassword();
					
					break;
				}
				
			break;
				
		}
		return $fields;
	}
}
?>