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
 * Require some configuration stuff
 */ 
 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/config.php';


//require_once dirname(__FILE__, 4) .'/QuickBooks/Driver/Sql/Mysqli.php';

$config = array();

$Driver = QuickBooks_Driver_Factory::create($dsn);	
// Handle the form post
if (isset($_POST['submitted']))
{
	 $sql = "
		INSERT INTO
			my_customer_table
		(
			name, 
			fname, 
			lname
		) VALUES (
			'" . $_POST['name'] . "', 
			'" . $_POST['fname'] . "', 
			'" . $_POST['lname'] . "'
		)";
		
	//$areturn = $mydrive->_query($sql);
	$errnum = 0;
				$errmsg = '';
				$res = $Driver->query($sql, $errnum, $errmsg);
	// Get the primary key of the new record
	
	$id = $Driver->last();
	
	// Queue up the customer add 
	$Queue = new QuickBooks_WebConnector_Queue($dsn);
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $id);
	
	die('Great, queued up a customer!');
}
