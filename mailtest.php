<?php

$to = 'infinitepitechnologies@gmail.com';
    $email = 'infinitepitechnologies@gmail.com';
    $subject = "LOANED LIBRARY BOOKS CROSSING DUE DATE !!";
	$message = "HI";
	$headers = "From:".$email;
	mail($to, $subject, $message, $headers);

	?>