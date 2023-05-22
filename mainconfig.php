<?php

date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '128M');

/* CONFIG */
$config['web'] = array(
	'maintenance' => 0, // 1 = yes, 0 = no
	'title' => 'Reseller Papadzul',
	'meta' => array(
		'description' => 'Reseller Papadzul adalah website social media marketing Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia Jasa Social Media. Seperti Jasa penambah Followers, Likes, Views, dll.',
		'keywords' => 'smm panel',
		'author' => 'Papadzul Smm Panel'
	),
	'base_url' => 'https://www.domainanda.com/', // Cukup ubah domainanda.com
	'register_url' => 'https://www.domainanda.com/auth/register.php', // Cukup ubah domainanda.com
	'kontak_whatsapp' => '6287711712252' // Diawali 62
);

$config['register'] = array(
	'price' => array(
		'member' => 10000,
		'reseller' => 30000,
	),
	'bonus' => array(
		'member' => 5000,
		'reseller' => 10000,
	)
);

$config['db'] = array(
	'host' => 'localhost',
	'name' => 'db_name',
	'username' => 'db_username',
	'password' => 'db_password'
);
/* END - CONFIG */

require 'lib/db.php';
require 'lib/model.php';
require 'lib/function.php';

session_start();
$model = new Model();
