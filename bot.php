<?php

require 'post.php';

$text = 'New Iridium post received at ' . $transmit_time;
$attachments = array(
	array(
		'color' => '#3498DB',
		'fields' => array(
			array(
				'title' => 'GPS information',
				'value' =>  '*Position* ' . $data[0] . ' N, ' . $data[1] . ' E\n*Altitude* ' . $data[2] . ' m'
			)
		)
	),
	array(
		'color' => '#D00000',
		'fields' => array(
			array(
				'title' => 'Follow live!',
				'value' => '<https://dev.coderagora.com/iridium/|Live tracking>\n<https://www.google.com/maps/@' . $data[0] . ',@' . $data[1] . ',15z|Google Maps>'
			)
		)
	)
);
$json_data = json_encode( array( 'text' => $text, 'attachments' => $attachments ) );
print_r( $text );
print_r( $attachments );
print_r( $json_data );

$ch = curl_init( 'https://hooks.slack.com/services/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' );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen( $json_data )
));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_exec( $ch );
