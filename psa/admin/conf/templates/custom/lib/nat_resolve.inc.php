<?php

function nat_resolve($ipAddress)
{
	$nat_translation = array(
			"54.251.139.50" => "10.0.0.206",
			"54.251.139.25" => "10.0.0.108",
			"54.251.139.90" => "10.0.0.204",
			"54.251.139.29" => "10.0.0.205",
			"54.251.145.221" => "10.0.0.207",
		);
	/*

	$ipAddress->escapedPublicAddress = $ipAddress->escapedAddress;

	if (isset($nat_translation[$ipAddress->escapedAddress]))
		$ipAddress->escapedAddress = $nat_translation[$ipAddress->escapedAddress];

	$ipAddress->escapedPrivateAddress = $ipAddress->escapedAddress;
	*/

	if (isset($nat_translation[$ipAddress]))
		$ipAddress = $nat_translation[$ipAddress];

}

?>