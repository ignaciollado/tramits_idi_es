<?php

class Request {
	//String
	public $addresseeWorkflow;
	
	//String
	public $subject;
	
	//String
	public $message;
	
	//String
	public $reference;
	
	//String
	public $notificationUrl;
	
	//String
	public $returnUrl;
	
	//String
	public $stampName;
	
	//Boolean
	public $useDefaultStamp;
	
	//String
	public $publicAccessId;
	
	//Array of String
	public $internalNotification;
	
	//Date
	public $creationDate;
	
	//Date
	public $initDate;
	
	//Date
	public $expirationDate;
	
	//Date
	public $sendDate;
	
	//Boolean
	public $signWithCertificate;
	
	//UserEntity
	public $sender;
	
	//Array of AddresseeLine
	public $addresseeLines;
	
	//VerificationAccess
	public $verificationAccess;
	
	//Enum (String) = [FINISH, MEDIUM, ALL, NO]
	public $senderNotificationLevel;

	//Enum (String) = [ALL, CERTIFICATE_OTP_SMS, CERTIFICATE_ONLY]
	public $signatureLevel;
	
	//Array of Item
	public $metadatas;
	
	//Array of Document
	public $documentsToSign;
	
	//Array of Document
	//public $documentsAnnexes;
}

?>