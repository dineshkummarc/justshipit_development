<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/config.php';

//$Driver = QuickBooks_Driver_Singleton::getInstance();
		$Driver = QuickBooks_Driver_Factory::create($dsn);	
		$sql = " SELECT * from my_customer_table";
		$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
				while ($arr = $Driver->fetch($res))
				{
					var_dump($arr);
				}
		
		
var_dump($res);
die();
require_once '/home/justship/public_html/development/qbdesktop/QuickBooks/Driver/Sql/Mysqli.php';

if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}else{
	 echo "Connected";
	}
	//$ac = new QuickBooks_Driver_Sql_Mysqli($dsn);
	var_dump($this->_conn);
?>