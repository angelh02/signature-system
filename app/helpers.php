<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

function sendMailToSigners($documentJSON, $time)
{
    $document = json_decode($documentJSON);
    $signers = $document->document_signers;

    foreach($signers as $key => $signer){
        $emailData = [
            'subjectEmail' => 'Asignación como firmante',
            'recipientEmail' => $signer->user->email,
            'emailView' => 'email.signer-assignation', 
            'senderEmail' => 'correo-ejemplo@lerdo.edu.mx',
            'senderName' => 'Sistema De Firma Digital',
    
    
            'singer' => $signer->user,

            'document' => $document
        ];
    
        Mail::later($time, new \App\Mail\SendEmail($emailData));
    }
}

function sendMailToRemindSigner($signerJSON, $time)
{
    $signer = json_decode($signerJSON);
    $document = $signer->document_signers[0]->document;
    $emailData = [
        'subjectEmail' => 'Recordatorio para firmar documento',
        'recipientEmail' => $signer->user->email,
        'emailView' => 'email.remind-signer-assignation', 
        'senderEmail' => 'correo-ejemplo@lerdo.edu.mx',
        'senderName' => 'Sistema De Firma Digital',


        'singer' => $signer->user,

        'document' => $document
    ];

    Mail::later($time, new \App\Mail\SendEmail($emailData));
}

function sendMailToDocumentOwner($messageJson, $time)
{
    $messageData = json_decode($messageJson);
    $owner = $messageData->user;
    $document = $messageData->document;
    $message = $messageData->messageData; 
    $emailData = [
        'subjectEmail' => $message->subject,
        'recipientEmail' => $owner->email,
        'emailView' => 'email.document-owner-contact', 
        'senderEmail' => 'correo-ejemplo@lerdo.edu.mx',
        'senderName' => 'Sistema De Firma Digital',


        'owner' => $owner,

        'document' => $document,

        'content' => $message->description
    ];

    Mail::later($time, new \App\Mail\SendEmail($emailData));
}

function sendMailToSignConfirmation($signerJSON, $time)
{
    $signer = json_decode($signerJSON);
    $documents = [];
    foreach($signer->document_signers as $key => $document_signer){
        array_push($documents, $document_signer->document->name);
    }
    $emailData = [
        'subjectEmail' => 'Confirmación de firma',
        'recipientEmail' => $signer->user->email,
        'emailView' => 'email.sign-confirmation', 
        'senderEmail' => 'correo-ejemplo@lerdo.edu.mx',
        'senderName' => 'Sistema De Firma Digital',


        'singer' => $signer->user,

        'documents' => $documents
    ];

    Mail::later($time, new \App\Mail\SendEmail($emailData));
}

function sendMailToSignDocument($documentJSON, $time)
{
    $document = json_decode($documentJSON);
    $user = $document->user;
    $emailData = [
        'subjectEmail' => 'Documento firmado',
        'recipientEmail' => $user->email,
        'emailView' => 'email.document-signed', 
        'senderEmail' => 'correo-ejemplo@lerdo.edu.mx',
        'senderName' => 'Sistema De Firma Digital',


        'user' => $user,

        'document' => $document
    ];

    Mail::later($time, new \App\Mail\SendEmail($emailData));
}

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}