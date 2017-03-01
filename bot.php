<?php

require 'post.php';

$text = 'New Iridium post received at ' . $transmit_time;
$attachments = array(
	array(
		'color' => '#3498DB',
		'fields' => array(
			'title' => 'GPS information',
			'value' =>  '*Position* ' . $data[0] . ' N, ' . $data[1] . ' E\n*Altitude* ' . $data[2] . ' m'
		)
	),
	array(
		'color' => '#D00000',
		'fields' => array(
			'title' => 'Follow live!',
			'value' => '<https://dev.coderagora.com/iridium/|Live tracking>\n<https://www.google.com/maps/preview/@' . $data[0] . ',@' . $data[1] . ',8z|Google Maps>'
		)
	)
);

print_r( $text );
print_r( $attachments );
print_r( json_encode( $text, $attachments ) );

$ch = curl_init( 'https://hooks.slack.com/services/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' );
curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $text, $attachments ) );
// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
// curl_setopt( $ch, CURLOPT_HEADER, 0 );
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_exec( $ch );
