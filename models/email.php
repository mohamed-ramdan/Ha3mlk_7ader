<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('Mail.php');

$recipients = 'mertloka@hotmail.com';

$headers['From']    = 'mertloka@hotmail.com';
$headers['To']      = 'joe@example.com';
$headers['Subject'] = 'Test message';

$body = 'Test message';

$params['sendmail_path'] = '/usr/lib/sendmail';

// Create the mail object using the Mail::factory method
$mail_object =& Mail::factory('sendmail', $params);

$mail_object->send($recipients, $headers, $body);
?> 