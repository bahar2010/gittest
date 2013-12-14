<?php
class WwdController extends Zend_Controller_Action {
	private $wwd_session;
	private $wwdconfig;
	function init() {
		require_once(dirname(APPLICATION_PATH) . '/WAPI_php/WAPI.php');
		$this->wwdconfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/wwdconfig.xml');
		$this->wwd_session = new Zend_Session_Namespace('wwd_session');
		if(!isset($this->wwd_session->rs_domain)) {
			$this->wwd_session->rs_domain = array();
		}
	}
	
	public function indexAction() {
		$this->init();
		//Suggest array
		$extensions = array('.com', '.net', '.us', '.org', '.me', '.biz');
		

		if ($this->_request->isPost()) {
			$domain = $this->getRequest()->getPost('domain');
			$extension = $this->getRequest()->getPost('extension');
			if (!empty($domain)) {
				$client = new WildWest_Reseller_Client(
					WildWest_Reseller_Client::WSDL_PRODUCTION, 
					$this->wwdconfig->account, $this->wwdconfig->password
				);

				try {
					$domain = htmlentities(trim($domain));
					$array = array("{$domain}{$extension}");

					//add resently search domain to list    
					$this->wwd_session->rs_domain = $array;
					$this->view->result = $client->CheckAvailability($array);

					//Suggest array formation
					$suggested_list = array();
					foreach ($extensions as $value) {
						if($value !== $extension) {
							$suggested_list[] = $domain . $value; 
						}    
					}
					$this->view->suggested_result = $client->CheckAvailability($suggested_list);
					$this->view->rs_search = $this->wwd_session->rs_domain;
				} catch (Exception $e) {
					//Log Exception
				}
			}			
		}
	}
	
	function domainParse($domain_name) {
		$tmp = explode('.', $domain_name);
		$c = count($tmp);
		if ($c <= 1) {
			return false;
		}
		$tld = $tmp[$c -1];
		$tmp = array_slice($tmp, 0, $c - 1);
		$sld = implode('.',$tmp);
		return array('tld' => $tld, 'sld' => $sld);
	}
		
	function get_productId($tld) {
		$tld = strtolower($tld);
		$product_Enum = array(
			'biz' => 350076, 
			'me' => 9140, 
			'com' => 350001, 
			'net' => 350030, 
			'us' => 350126, 
			'org' => 350150
		);
		if (isset($product_Enum[$tld])) {
			return $product_Enum[$tld];
		} else {
			return false;
		}
	}
	
	
	public function addtocartAction() {
		$this->wwd_session = new Zend_Session_Namespace('wwd_session');
		if (!isset($this->wwd_session->domainList)) {
			$this->wwd_session->domainList = array();
		}
		
		if ($this->_request->isPost()) {
			$domain = $this->getRequest()->getPost('domain');
			if (isset($domain)) {
				$domain = trim($domain);
				if (!in_array($domain, $this->wwd_session->domainList)) {
					$this->wwd_session->domainList[] = $domain;
				}
			}
		}
	}
	
	public function orderdomainAction() 
	{
		$this->init();
		$this->view->domainList = $this->wwd_session->domainList;
		
		if ($this->_request->isPost())
		{
			$domainList = $this->getRequest()->getPost('domains');
			$wapi = new WAPI($this->wwdconfig->soap_server, array('trace' => true));

			//inint credential. 
			$cred = new Credential();
			$cred->Account = $this->wwdconfig->account;
			$cred->Password = $this->wwdconfig->password;

			//check available domains.
			$CheckAvailability = new CheckAvailability();
			$CheckAvailability->sCLTRID = sha1(uniqid(null, true));
			$CheckAvailability->credential = $cred;
			$CheckAvailability->sDomainArray = $domainList;

			$strXML = $wapi->CheckAvailability($CheckAvailability)->CheckAvailabilityResult;
			$oXML = simplexml_load_string($strXML);
			
			$available_domains  = array(); 
			foreach ($oXML->domain as $item) {

				$ds_name = (string)$item->attributes()->name[0];
				$ds_avail = (int)$item->attributes()->avail[0];
				switch($ds_avail) {
					case -1:
						break;
					case 0:
						break;
					case 1:
						$tmp = $this->domainParse($ds_name);
						if ($tmp) {
							$available_domains[] = $tmp;
						}
						break;
				}
			}

			if (count($available_domains) <= 0) {
				die ('All domain(s) are not available to register.');
			}
			
			//create new shopper.
			if (empty($this->wwd_session->shopperAccount)) {
				$newShopper = new CreateNewShopper();
				$newShopper->sCLTRID = sha1(uniqid(null, true));
				$newShopper->credential = $cred;
				$newShopper->sPwd = $this->wwdconfig->shopper->sPwd;
				$newShopper->sEmail = $this->wwdconfig->shopper->sEmail;
				$newShopper->sFirstName = $this->wwdconfig->shopper->sFirstName;
				$newShopper->sLastName = $this->wwdconfig->shopper->sLastName;
				$newShopper->sPhone = $this->wwdconfig->shopper->sPhone;
				
				$strXML = $wapi->CreateNewShopper($newShopper)->CreateNewShopperResult;
				$oXML = simplexml_load_string($strXML);
				if ((int)$oXML->result->attributes()->code[0] == 1000) {
					$this->wwd_session->shopperAccount = (string)$oXML->resdata->shopper->attributes()->user[0];	
				} else {
					die ($oXML->result->msg);
				}
			}	
						
			//create new shopper.
			if (empty($this->wwd_session->shopperAccount)) {
				$newShopper = new CreateNewShopper();
				$newShopper->sCLTRID = sha1(uniqid(null, true));
				$newShopper->credential = $cred;
				$newShopper->sPwd = $this->wwdconfig->shopper->sPwd;
				$newShopper->sEmail = $this->wwdconfig->shopper->sEmail;
				$newShopper->sFirstName = $this->wwdconfig->shopper->sFirstName;
				$newShopper->sLastName = $this->wwdconfig->shopper->sLastName;
				$newShopper->sPhone = $this->wwdconfig->shopper->sPhone;
				
				$strXML = $wapi->CreateNewShopper($newShopper)->CreateNewShopperResult;
				$oXML = simplexml_load_string($strXML);
				if ((int)$oXML->result->attributes()->code[0] == 1000) {
					$this->wwd_session->shopperAccount = (string)$oXML->resdata->shopper->attributes()->user[0];	
				} else {
					die ($oXML->result->msg);
				}
			}	

			//Shopper Info				
			$shopper = new WildWest_Reseller_Shopper();
			$shopper->user		= $this->wwd_session->shopperAccount;
			$shopper->pwd		= $this->wwdconfig->shopper->sPwd;
			$shopper->email		= $this->wwdconfig->shopper->sEmail;
			$shopper->firstname = $this->wwdconfig->shopper->sFirstName;
			$shopper->lastname	= $this->wwdconfig->shopper->sLastName;
			$shopper->phone		= $this->wwdconfig->shopper->sPhone;

			//Contact Info
			$contactInfo = new WildWest_Reseller_ContactInfo();
			$contactInfo->fname = $this->wwdconfig->registrant->fname;
			$contactInfo->lname = $this->wwdconfig->registrant->lname;
			$contactInfo->email = $this->wwdconfig->registrant->email;
			$contactInfo->sa1   = $this->wwdconfig->registrant->sa1;
			$contactInfo->city  = $this->wwdconfig->registrant->city;
			$contactInfo->sp    = $this->wwdconfig->registrant->sp;
			$contactInfo->phone = $this->wwdconfig->registrant->phone;
			$contactInfo->pc    = $this->wwdconfig->registrant->pc;
			$contactInfo->cc    = $this->wwdconfig->registrant->cc;
		
			//nexus info
			$nexus = new WildWest_Reseller_Nexus();
			$nexus->category = $this->wwdconfig->nexus->category;
			$nexus->use      = $this->wwdconfig->nexus->use;
			
			//Domainname server.
			//$ns1 = new WildWest_Reseller_NS();		
			//$ns2 = new WildWest_Reseller_NS();
			
			//Product Id from WWD's product.
			$domainArray = array();
			for ($i = 0, $c = count($available_domains); $i < $c; $i++) {
				$order = new WildWest_Reseller_OrderItem();
				$order->productid	= $this->get_productId($available_domains[$i]['tld']);
				$order->quantity	= 1;
				$order->duration	= 1;

				$registration             = new WildWest_Reseller_DomainRegistration();
				$registration->order      = clone $order;
				$registration->registrant = clone $contactInfo;
				$registration->admin      = clone $contactInfo;
				$registration->tech       = clone $contactInfo;
				$registration->billing    = clone $contactInfo;
				$registration->period     = 1;
				$registration->sld        = $available_domains[$i]['sld'];
				$registration->tld        = $available_domains[$i]['tld'];
				$registration->nexus     = clone $nexus;
				//$registration->nsArray    = array($ns1, $ns2);
				$registration->autorenewflag = 1;
				$domainArray[] = $registration;
			} 

			$orderDomainsRequest = new OrderDomains();
			$orderDomainsRequest->sCLTRID = sha1(uniqid(null, true));
			$orderDomainsRequest->credential = $cred;
			$orderDomainsRequest->shopper = $shopper;
			$orderDomainsRequest->items = $domainArray;

			//Order domain query.
			$strXML = $wapi->OrderDomains($orderDomainsRequest)->OrderDomainsResult;
			//print_r(htmlentities($wapi->__getLastRequestHeaders()));
			//echo '<br />--------------------<br />';
			//print_r($wapi->__getLastResponse());exit();
			$oXML = simplexml_load_string($strXML);
			$reg_status = (int)$oXML->result->attributes()->code[0];
			$this->view->error = array();
			if ($reg_status == 1000) {
				$this->view->error['code'] = 0;
				$this->wwd_session->domainList = array();
			} else {
				$this->view->error['code'] = 1;
				$this->view->error['msg'] = (string)$oXML->resdata->error->attributes()->msg;
			}
		}
	}
	
	function checkproccessAction() {
			//check order status.
			$this->init();
			$wapi = new WAPI($this->wwdconfig->soap_server, array('trace' => true));

			//inint credential. 
			$cred = new Credential();
			$cred->Account = $this->wwdconfig->account;
			$cred->Password = $this->wwdconfig->password;
		
			$poll = new poll();
			$poll->sCLTRID = sha1(uniqid(null, true));
			$poll->credential = $cred;
			$strXML = $wapi->poll($poll)->PollResult;
			echo "<br />" . $strXML;
	}
}
?>
