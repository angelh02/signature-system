<?php

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