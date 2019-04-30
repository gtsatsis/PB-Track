<?php
/* Include the PB Tracking API Wrapper */
include '../lib/pb_wrapper.php';

$pb = new PBTrack($_GET['code']); // Assumes ?code= is a valid Pitney Bowes tracking number.

/**
 *  Let's say that for example, I want to get the package tracking number, as well as the sender's region and country.
 *	Example is as follows:
 */

$response = [
	'tracking_number' => $pb->get_identifier(),
	'sender_address' => [
		'region' => $pb->get_sender_region(),
		'country' => $pb->get_sender_country()
	]
];
header('Content-Type: application/json'); // Add proper Content-Type header
echo json_encode($response);
?>