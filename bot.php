<?php

require 'post.php';
$data = explode( ',', $data );

$lat = $data[0];
$lon = $data[1];
$alt = $data[2];
$Tin = $data[3];
$Tex = $data[4];
$alb = $data[5];
$gps = $data[6];
$chk = $data[7];

$text = 'New Iridium post received at ' . $transmit_time;
$attachments = array(
	array(
		'color' => '#3498DB',
		'fields' => array(
			array(
				'title' => 'GPS position',
				'value' => $lat . ", " . $lon,
				'short' => true 
			),
			array(
				'title' => 'Altitude',
				'value' => $alt . " m",
				'short' => true
			),
			array(
				'title' => 'Interior Temperature',
				'value' => $Tin . " C",
				'short' => true
			),
			array(
				'title' => 'Exterior Temperature',
				'value' => $Tex . " C",
				'short' => true
			),
			array(
				'title' => 'Barometric Altitude',
				'value' => $alb . " m",
				'short' => true
			),
			array(
				'title' => 'Number of GPS satellites',
				'value' => $gps,
				'short' => true
			),
			array(
				'title' => 'Check',
				'value' => $chk,
				'short' => true
			)
		)
	),
	array(
		'color' => '#D00000',
		'fields' => array(
			array(
				'title' => 'Follow live!',
				'value' => "<https://dev.coderagora.com/iridium/|Iridium Live Tracking>\n<https://www.google.com/maps/place/" . $lat . "+" . $lon . "|Google Maps>"
			)
		)
	)
);

$json_data = json_encode( array( 'text' => $text, 'attachments' => $attachments ) );
print_r( $json_data );

$urls = array( 'https://hooks.slack.com/services/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', 'https://hooks.slack.com/services/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' );

foreach ( $urls as $url ) {
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen( $json_data )
	));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_exec( $ch );
}
