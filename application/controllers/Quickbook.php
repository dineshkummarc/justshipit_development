<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

use QuickBooksOnline\API\DataService\DataService;

class Quickbook extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
    }

	function quickbookcallback(){
		
		$dataService = DataService::Configure(array(
			'auth_mode' => 'oauth2',
			'ClientID' => $this->aQuickConfig['client_id'],
			'ClientSecret' =>  $this->aQuickConfig['client_secret'],
			'RedirectURI' => $this->aQuickConfig['oauth_redirect_uri'],
			'scope' => $this->aQuickConfig['oauth_scope'],
			'baseUrl' => $this->aQuickConfig['base_url'],
			'QBORealmID' => $this->aQuickConfig['qbo_realm_id']
		));
		
		$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
		if(!empty($_SERVER['QUERY_STRING'])){
			$parseUrl = $this->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

			/*
			 * Update the OAuth2Token
			 */
			if(!empty($parseUrl['code']) && !empty($parseUrl['realmId'])){
				$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
				
				$dataService->updateOAuth2Token($accessToken);
				$_SESSION['sessionAccessTokenQB'] = $accessToken;
				
				echo  "<script type='text/javascript'>";
				//echo 'document.getElementById("accessTokenMsg").innerHTML = "Connected to Quickbook!";';
				//echo 'document.getElementById("accessTokenMsg").style.color = "green";';
				echo "window.close();";
				echo "window.opener.location.reload();";
				
				echo "</script>";
			}else{
				 redirect('/dashboard');
			}
		}else{
			 redirect('/dashboard');
		}
	} 
	
	function parseAuthRedirectUrl($url)
	{
		parse_str($url,$qsArray);
	
		return array(
			'code' => $qsArray['code'],
			'realmId' => $qsArray['realmId']
		);
	}
}

?>