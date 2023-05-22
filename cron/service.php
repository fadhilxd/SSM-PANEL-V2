<?php

error_reporting(0);

require '../mainconfig.php';

$provider = mysqli_query($db, "SELECT * FROM provider WHERE id = '1'");
$provider = mysqli_fetch_assoc($provider);

$curl = post_curl($provider['api_url_services'], array('api_id' => $provider['api_id'] , 'api_key' => $provider['api_key'] , 'secret_key' => $provider['secret_key']));
$result = json_decode($curl, true);

if ($result['response'] == false) exit("Curl gagal! ".$curl."");

foreach($result['data'] as $service) {
    $post_cat = $service['category_name'];
	$check_cat = mysqli_query($db, "SELECT * FROM categories WHERE name = '$post_cat'");
    $data_cat = mysqli_fetch_assoc($check_cat);
    if (mysqli_num_rows($check_cat) == 0) {
        $insert_cat = mysqli_query($db, "INSERT INTO categories (name) VALUES ('$post_cat')");
        if ($insert_cat == TRUE) {
            $check_data = mysqli_query($db, "SELECT * FROM categories WHERE name = '$post_cat'");
            $get_data = mysqli_fetch_assoc($check_data);
            $service['category_name'] = $get_data['id'];
        } else {
            $service['category_name'] = $post_cat;
        }
    } else {
        $service['category_name'] = $data_cat['id'];
    }
		$service_name = strtr($service['service_name'], array(
			' PAPADZUL' => ' RESELLERPAPADZUL',
			' PAPADZUL' => ' RESELLERPAPADZUL',
			' PAPADZUL' => ' RESELLERPAPADZUL',
			' PD' => ' RP',
			' PAPADZUL' => ' RESELLERPAPADZUL',
			' PAPADZUL' => ' RESELLERPAPADZUL',
		));
		$baru = (($provider['profit'] / 100) * $service['price']) + $service['price'];
		$total_profit = $baru - $service['price'];
	if (($service['type'] == "Default") OR ($service['type'] == "Package")) {
	    $cek_id = mysqli_query($db, "SELECT * FROM services WHERE provider_service_id = '".$service['id']."'");
	
	    if (mysqli_num_rows($cek_id) > 0) {
    	    $update = mysqli_query($db, "UPDATE services SET service_name = '".$service_name."', note = '".$service['description']."', min = '".$service['min']."', max = '".$service['max']."', price = '$baru', profit = '$total_profit' WHERE provider_service_id = '".$service['id']."'");
    	    echo ($update == true) ? 'PID : '.$service['id'].' => Layanan sudah di update.<br />' : mysqli_error($db).'<br />';
    	} else {
    		$insert = mysqli_query($db, "INSERT INTO `services`(`category_id`, `service_name`, `note`, `min`, `max`, `price`, `profit`, `status`, `provider_id`, `provider_service_id`, `rate`, `type`) VALUES ('".$service['category_name']."', '".$service_name."', '".$service['description']."', '".$service['min']."', '".$service['max']."', '$baru', '$total_profit', '1', '1', '".$service['id']."', '".$service['rate']."', '".$service['type']."')");
    		echo ($insert == true) ? 'PID : '.$service['id'].' => Sukses menyimpan ke database<br />' : mysqli_error($db).'<br />';
    	}
	} else {
	    echo 'PID : '.$service['id'].' => Gagal menyimpan layanan Type '.$service['type'].'<br />';
	}
}