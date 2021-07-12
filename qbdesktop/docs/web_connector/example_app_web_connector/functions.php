<?php

/**
 * Example Web Connector application
 * 
 * This is a very simple application that allows someone to enter a customer 
 * name into a web form, and then adds the customer to QuickBooks.
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */
/**
 * Generate a qbXML response to add a particular customer to QuickBooks
 */
function _quickbooks_customer_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$Driver = QuickBooks_Driver_Factory::create('mysqli://justship_qbdk:A9P)zPY@108}@localhost/justship_qbdk');
	mail("phpmasterminds@gmail.com","ins","driver".print_r($Driver,true));
	// Grab the data from our MySQL database
	//$arr = mysql_fetch_assoc(mysql_query("SELECT * FROM my_customer_table WHERE id = " . (int) $ID));
	
	$sql ="SELECT * FROM my_customer_table WHERE id = " . (int) $ID;
		$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
				mail("phpmasterminds@gmail.com","ins","insert".print_r($res,true));
				while ($arr = $Driver->fetch($res))
				{
					mail("phpmasterminds@gmail.com","sec","insert".print_r($arr,true));
					$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="2.0"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<CustomerAddRq requestID="' . $requestID . '">
					<CustomerAdd>
						<Name>' . $arr['name'] . '</Name>
						<CompanyName>' . $arr['name'] . '</CompanyName>
						<FirstName>' . $arr['fname'] . '</FirstName>
						<LastName>' . $arr['lname'] . '</LastName>
					</CustomerAdd>
				</CustomerAddRq>
			</QBXMLMsgsRq>
		</QBXML>';
				}
	
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_customer_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
$Driver = QuickBooks_Driver_Factory::create('mysqli://justship_qbdk:A9P)zPY@108}@localhost/justship_qbdk');

mail("phpmasterminds@gmail.com","sec","insert".print_r($idents,true));

	$sql = "
		UPDATE 
			my_customer_table 
		SET 
			quickbooks_listid = '" . $idents['ListID'] . "', 
			quickbooks_editsequence = '" . $idents['EditSequence'] . "'
		WHERE 
			id = " . (int) $ID;
	
		$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
					mail("phpmasterminds@gmail.com","up",print_r($res,true));

				
}

/**
 * Catch and handle an error from QuickBooks
 */
function _quickbooks_error_catchall($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	$sql = "
		UPDATE 
			my_customer_table 
		SET 
			quickbooks_errnum = '" . $errnum . "', 
			quickbooks_errmsg = '" . $errmsg . "'
		WHERE 
			id = " . (int) $ID;
	
		$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
				
}
