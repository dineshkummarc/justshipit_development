<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['profile'] = "user/profile";
$route['profile/(:any)'] = "user/profile/$1";
$route['profileUpdate'] = "user/profileUpdate";
$route['profileUpdate/(:any)'] = "user/profileUpdate/$1";

$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['changePassword/(:any)'] = "user/changePassword/$1";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

$route['callback'] = "quickbook/quickbookcallback";


$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";


/*customers*/
$route['customerListing'] = 'customer/customerListing';
$route['customerListing/(:num)'] = "customer/customerListing/$1";


$route['vendorListing'] = 'customer/vendorListing';
$route['vendorListing/(:num)'] = "customer/vendorListing/$1";

$route['addNewCustomer'] = 'customer/addNewCustomer';
$route['addNewCustomer/(:num)'] = "customer/addNewCustomer/$1";
$route['checkCustomerEmailExists'] = 'customer/checkCustomerEmailExists';
$route['saveNewCustomer'] = 'customer/saveNewCustomer';
$route['deleteCustomer'] = 'customer/deleteCustomer';
$route['editOldCustomer'] = 'customer/editOldCustomer';
$route['editOldCustomer/(:num)'] = "customer/editOldCustomer/$1";
$route['saveOldCustomer'] = "customer/saveOldCustomer"; 
$route['statecheck/(:any)'] = 'customer/getStateList/$1';
$route['getCustomerData/(:any)'] = 'customer/getCustomerData/$1';
$route['getCustomerDatawithShip/(:any)/(:any)/(:any)'] = 'customer/getCustomerDatawithShip/$1/$2/$3';


$route['checkCustomer'] = 'customer/checkCustomer';
$route['checkCustomerpopup'] = 'customer/checkCustomerpopup';
$route['checkCustomerpopup/(:num)'] = "customer/checkCustomerpopup/$1";
$route['customerquickbook'] = "customer/customerquickbook";
$route['callbackdata'] = "customer/callbackdata";


/*shipments*/
$route['shipquickbook'] = "shipment/shipquickbook";

$route['updateMAWBdatas'] = 'shipment/updateMAWBdatas';
$route['addTransferAlert'] = 'shipment/addTransferAlert';
$route['addRoutingAlert'] = 'shipment/addRoutingAlert';
$route['savespecialInstructions'] = 'shipment/savespecialInstructions';
$route['addVendorShipment'] = 'shipment/addVendorShipment';
$route['loadSelectedVendors'] = 'shipment/loadSelectedVendors';
$route['loadTransferAlert'] = 'shipment/loadTransferAlert';
$route['loadRoutingAlert'] = 'shipment/loadRoutingAlert';
$route['loadVendors'] = 'shipment/loadVendors';
$route['loadVendorType'] = 'shipment/loadVendorType';
$route['editVendorType'] = 'shipment/editVendorType';
$route['removeVendorType'] = 'shipment/removeVendorType';
$route['removeChargeCode'] = 'shipment/removeChargeCode';
$route['removeExtraChargeCode'] = 'shipment/removeExtraChargeCode';
$route['addChargeCode'] = 'shipment/addChargeCode';
$route['addExtraChargeCode'] = 'shipment/addExtraChargeCode';
$route['loadSelectedChargeCodes'] = 'shipment/loadSelectedChargeCodes';
$route['loadSelectedExtraChargeCodes'] = 'shipment/loadSelectedExtraChargeCodes';

$route['loadCloneOption'] = 'shipment/loadCloneOption';
$route['loadChargeCode'] = 'shipment/loadChargeCode';
$route['loadExtraChargeCode'] = 'shipment/loadExtraChargeCode';
$route['checkairportCode'] = 'shipment/checkairportCode';

$route['domesticShipment'] = 'shipment/domesticShipment';
$route['domesticShipment/(:num)'] = "shipment/domesticShipment/$1"; 

$route['addDomesticShipment'] = 'shipment/addDomesticShipment';
$route['editDomesticShipment'] = 'shipment/editDomesticShipment';
$route['deleteDomesticShipment'] = 'shipment/deleteDomesticShipment';
$route['deleteTransferAlert'] = 'shipment/deleteTransferAlert';
$route['deleteRoutingAlert'] = 'shipment/deleteRoutingAlert';
$route['editDomesticShipment/(:num)'] = "shipment/editDomesticShipment/$1";
$route['saveNewDomesticShipment'] = 'shipment/saveNewDomesticShipment';
$route['updateDomesticShipment'] = 'shipment/updateDomesticShipment';

$route['inernationalShipment'] = 'shipment/inernationalShipment';
$route['inernationalShipment/(:num)'] = "shipment/inernationalShipment/$1"; 

$route['getwaybillno'] = 'shipment/getwaybillno';


$route['airports'] = 'shipment/airports';
$route['airports/(:num)'] = "shipment/airports/$1";
$route['deleteAirport'] = 'shipment/deleteAirport';
$route['addAirport'] = 'shipment/addAirport';
$route['saveAirport'] = 'shipment/saveAirport';
$route['updateAirport'] = 'shipment/updateAirport';
$route['editAirport'] = 'shipment/editAirport';
$route['editAirport/(:num)'] = "shipment/editAirport/$1";

$route['loadAirports'] = 'shipment/loadAirports';
$route['ajaxAirportData/(:num)'] = 'shipment/ajaxAirportData/$1';

$route['ajaxCustomerData'] = 'customer/ajaxCustomerData';
$route['ajaxCustomerData/(:num)'] = 'customer/ajaxCustomerData/$1';

$route['ajaxVendorData'] = 'shipment/ajaxVendorData';
$route['ajaxVendorData/(:num)'] = 'shipment/ajaxVendorData/$1';


$route['loadExtraCharges'] = 'shipment/loadExtraCharges';
$route['loadSpecialInstructions'] = 'shipment/loadSpecialInstructions';

$route['dommawb/(:num)'] = "shipment/dommawb/$1";

$route['billLadingPdf'] = 'shipment/billLadingPdf';
$route['billLadingPdf/(:num)'] = "shipment/billLadingPdf/$1";

$route['deliveryAlertPdf'] = 'shipment/deliveryAlertPdf';
$route['deliveryAlertPdf/(:num)'] = "shipment/deliveryAlertPdf/$1";

$route['bolLabel'] = 'shipment/bolLabel';
$route['bolLabel/(:num)'] = "shipment/bolLabel/$1";

$route['pickupAlertPdf'] = 'shipment/pickupAlertPdf';
$route['pickupAlertPdf/(:num)'] = "shipment/pickupAlertPdf/$1";

$route['transferAlertPdf'] = 'shipment/transferAlertPdf';
$route['transferAlertPdf/(:num)'] = "shipment/transferAlertPdf/$1";

$route['mawbPdf'] = 'shipment/mawbPdf';
$route['mawbPdf/(:num)'] = "shipment/mawbPdf/$1";
$route['routingAlertPdf/(:num)'] = "shipment/routingAlertPdf/$1";
$route['dominvoicepdf/(:num)'] = "shipment/dominvoicepdf/$1";

$route['sendmail/(:any)/(:any)'] = 'shipment/sendmail/$1/$2';



$route['customercreateconfig'] = 'Qbdesktop/customercreateconfig';
$route['qbwc'] = 'Qbdesktop/customerdesktopqbwc';
$route['customerdesktopenque'] = 'Qbdesktop/customerdesktopenque';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
