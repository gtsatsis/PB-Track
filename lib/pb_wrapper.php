<?php
class PBTrackGetCode {
	public $indentifiers;

	public function __construct($order_id, $email){
		$url = 'https://parceltracking.pb.com/orderapi/order-mgmt/services/unsecured/public/orders/'. $order_id .'/parcel-identifiers?emailId='.md5($email);
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_HTTPGET, true);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));
		$result = curl_exec($cURL);
		curl_close($cURL);

		$this->indentifiers = json_decode($result, true);
	}

	public function get_order_package_ids(){
		return $this->identifiers['parcelIdentifiers'];
	}
}

class PBTrack {

	public $track_result;

	public function __construct($track_code){
		$url = 'https://parceltracking.pb.com/ptsapi/track-packages/'.$track_code;

		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_HTTPGET, true);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));
		$result = curl_exec($cURL);
		curl_close($cURL);

		$this->track_result = json_decode($result, true);
	}

	/* Full Compilation of Generic Info */

	public function get_general_package_info(){
		return [
			'package_identifier' => $this->track_result['packageIdentifier'],
			'order_id' => $this->track_result['orderId'],
			'carrier' => $this->track_result['carrier'],
			'partner_code' => $this->track_result['partnerCode'],
			'service' => $this->track_result['service'],
			'weight_readable' => $this->track_result['weight'] . ' ' . $this->track_result['weightUnit'],
			'weight' => $this->track_result['weight'],
			'weight_unit' => $this->track_result['weightUnit']
		];
	}

	/* Generic Info Functions */

	public function get_identifier(){
		return $this->track_result['packageIdentifier'];
	}

	public function get_order_id(){
		return $this->track_result['orderId'];
	}

	public function get_carrier(){
		return $this->track_result['carrier'];
	}

	public function get_partner_code(){
		return $this->track_result['partnerCode'];
	}

	public function get_service(){
		return $this->track_result['service'];
	}

	/* Weight Functions */

	public function get_weight(){
		return $this->track_result['weight'];
	}

	public function get_weight_unit(){
		return $this->track_result['weightUnit'];
	}

	public function get_weight_readable(){
		return $this->track_result['weight'] . ' ' . $this->track_result['weightUnit'];
	}

	/* Address-Related Functions */

	public function get_all_addresses(){
		return [
			'sender_address' => [
				$this->track_result['senderLocation']
			],
			'destination_address' => [
				$this->track_result['destinationLocation']
			]
		];
	}	

	public function get_sender_address(){
		return $this->track_result['senderLocation'];
	}

	public function get_destination_address(){
		return $this->track_result['destinationLocation'];
	}

	/**
	*	This section has sender address related functions, skip down for delivery/destination address
	*/

	public function get_sender_city(){
		return $this->track_result['senderLocation']['city'];
	}

	public function get_sender_region(){
		return $this->track_result['senderLocation']['countyOrRegion'];
	}

	public function get_sender_postcode(){
		return $this->track_result['senderLocation']['postalOrZipCode'];
	}

	public function get_sender_country(){
		return $this->track_result['senderLocation']['country'];
	}

	/**
	*	This section has delivery/destination address related functions
	**/

	public function get_destination_city(){
		return $this->track_result['destinationLocation']['city'];
	}

	public function get_destination_region(){
		return $this->track_result['destinationLocation']['countyOrRegion'];
	}

	public function get_destination_postcode(){
		return $this->track_result['destinationLocation']['postalOrZipCode'];
	}

	public function get_destination_country(){
		return $this->track_result['destinationLocation']['country'];
	}

	/* Current Item Location Functions */

	public function get_current_status(){
		return $this->track_result['currentStatus'];
	}

	public function get_current_status_eventcode(){
		return $this->track_result['currentStatus']['eventCode'];
	}

	public function get_current_status_package_status(){
		return $this->track_result['currentStatus']['packageStatus'];
	}

	public function get_current_status_event_description(){
		return $this->track_result['currentStatus']['eventDescription'];
	}

	public function get_current_status_event_leg(){
		return $this->track_result['currentStatus']['eventLeg'];
	}

	public function get_current_status_event_type(){
		return $this->track_result['currentStatus']['eventType'];
	}

	public function get_current_status_event_date(){
		return $this->track_result['currentStatus']['eventDate'];
	}

	public function get_current_status_event_time(){
		return $this->track_result['currentStatus']['eventTime'];
	}

	public function get_current_status_event_date_time(){
		return $this->track_result['currentStatus']['eventDate'] . ' ' . $this->track_result['currentStatus']['eventTime'];
	}

	public function get_current_status_event_location(){
		return $this->track_result['currentStatus']['eventLocation'];
	}

	public function get_current_status_event_location_country(){
		return $this->track_result['currentStatus']['eventLocation']['country'];
	}

	public function get_current_status_authorized_agent(){
		return $this->track_result['currentStatus']['authorizedAgent'];
	}

	/* Scan History Functions */

	public function get_scan_history(){
		return $this->track_result['scanHistory'];
	}
}
?>