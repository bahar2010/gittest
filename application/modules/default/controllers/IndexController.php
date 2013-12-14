<?php
class IndexController extends Zend_Controller_Action {
	private $wwd_session;
	private $wwdconfig;
	private $_exts; 
	function init() {
		require_once(dirname(APPLICATION_PATH) . '/WAPI_php/WAPI.php');
		$this->wwdconfig = new Zend_Config_Xml(APPLICATION_PATH . '/configs/wwdconfig.xml');
		$this->wwd_session = new Zend_Session_Namespace('wwd_session');
		if(!isset($this->wwd_session->rs_domain)) {
			$this->wwd_session->rs_domain = array();
		}
	}
	
	public function indexAction() {
		
		
		$this->view->headTitle()->append('your one stop for Profession' );

		$sliders = new Dashboard_Model_DbTable_Sliders();
		$this->view->sliders = $sliders->fetchAll();
				
		$domains = new Dashboard_Model_DbTable_Domains();
		$this->view->domains = $domains->fetchAll();
		
		$hostings = new Dashboard_Model_DbTable_Hostings();
		$this->view->hostings = $hostings->fetchAll();
		
		$homepageprojects = new Dashboard_Model_DbTable_Homepageprojects();
		$this->view->homepageprojects = $homepageprojects->fetchAll();
		
		$homepageservices = new Dashboard_Model_DbTable_Homepageservices();
		$this->view->homepageservices = $homepageservices->fetchAll();
		
        $data = new Default_Model_DbTable_domainPrices();
        $this->view->data = $data->fetchAll();
		
		
		$data1 = new Default_Model_DbTable_intdomainPrices();
        $intdomainprice =  $data1->fetchAll();
        $this->view->data1= $intdomainprice;
    
		
		$this->init();
		//Suggest array
		$extensions = array('.com', '.net', '.us', '.co.uk','.biz');
		

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
	
	
	public function paymentAction() {
		
		
		$this->view->headTitle()->append('payment for you order here');
		

		
	}
	
	public function domaincheckAction() {
		
		
		$this->view->headTitle()->append('Avilability of your searched Domain Name');		
		
		$this->init();
		//Suggest array
		$extensions = array('.com', '.net', '.us', '.co.uk','.biz');
		

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
					
										
					
					$domainPriceTable = new Default_Model_DbTable_domainPrices();
					$allDomainPrices = $domainPriceTable->getAllDomainPrices();
					$domains_prices = array();
					$dm = strtoupper("{$domain}{$extension}");
					$domains_prices[$dm] = isset($allDomainPrices[$extension]['price']) ? $allDomainPrices[$extension]['price'] : '';

					//Suggest array formation
					$suggested_list = array();
					foreach ($extensions as $value) {
						if($value !== $extension) {
							$suggested_list[] = $domain . $value;
							$dm =  strtoupper("{$domain}{$value}");
							$domains_prices[$dm] = isset($allDomainPrices[$value]['price']) ? $allDomainPrices[$value]['price'] : '';
						}    
					}
					$this->view->suggested_result = $client->CheckAvailability($suggested_list);
					$this->view->rs_search = $this->wwd_session->rs_domain;
					$this->view->domains_prices = $domains_prices;				

				} catch (Exception $e) {
					echo $e->getMessage();exit();
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
				$this->wwd_session->domainList[] = trim($domain);
			}
		}
	}
	
	public function orderdomainAction() 
	{
		$this->init();
		$this->view->domainList = $domainList = $this->wwd_session->domainList;
		
		$domains_prices = array();
		if (count($this->wwd_session->domainList)) {
			//get all domain prices
			$domainPriceTable = new Default_Model_DbTable_domainPrices();
			$allDomainPrices = $domainPriceTable->getAllDomainPrices();
			$default = array(
				'price'  => '',
				'price_2years' => '',
				'price_3years' => '',
				'price_5years' => '',
				'price_5years' => '',
				'price_10years' => ''
			);
			foreach ($this->wwd_session->domainList as $domain) {
				$ext = $this->getDomainExtension($domain);
				$domains_prices[$domain] = isset($allDomainPrices[$ext]) ? $allDomainPrices[$ext] : $default;
			}	
		}
		$this->view->domains_prices = $domains_prices;

		
		if ($this->_request->isPost())
		{
			$domainList = $this->getRequest()->getPost('domains');
			$wapi = new WAPI($this->wwdconfig->soap_server, array('trace' => true));

			//inint credential. 
			$cred = new Credential();
			$cred->Account = $this->wwdconfig->account;
			$cred->Password = $this->wwdconfig->password;
			/*
			$ns = array();
			$ns[0] = new NS();
			$ns[0]->name = "ns1.example.com";
			$ns[1] = new NS();
			$ns[1]->name = "ns2.example.com";		
			*/

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

			//Order domains process.	
			$shopper = new Shopper();
			$shopper->user = $this->wwd_session->shopperAccount;
			$shopper->pwd = $this->wwdconfig->shopper->sPwd;
			$shopper->email = $this->wwdconfig->shopper->sEmail;
			$shopper->firstname = $this->wwdconfig->shopper->sFirstName;
			$shopper->lastname = $this->wwdconfig->shopper->sLastName;
			$shopper->phone = $this->wwdconfig->shopper->sPhone;

			//Contact Info
			$registrant = new ContactInfo();
			$registrant->fname = $this->wwdconfig->registrant->fname;
			$registrant->lname =  $this->wwdconfig->registrant->lname;
			$registrant->email =  $this->wwdconfig->registrant->email;
			$registrant->sa1 =  $this->wwdconfig->registrant->sa1;
			$registrant->city =  $this->wwdconfig->registrant->city;
			$registrant->sp =  $this->wwdconfig->registrant->sp;
			$registrant->pc =  $this->wwdconfig->registrant->pc;
			$registrant->cc =  $this->wwdconfig->registrant->cc;
			$registrant->phone =  $this->wwdconfig->registrant->phone;

			//nexus info
			$nexus = new Nexus();
			$nexus->category = $this->wwdconfig->nexus->category;
			$nexus->use = $this->wwdconfig->nexus->use;

			//Product Id from WWD's product.

			$domainArray = array();
			for ($i = 0, $c = count($available_domains); $i < $c; $i++) {
				$domainArray[$i] = new DomainRegistration();
				$domainArray[$i]->order = new OrderItem();

				//product ID from the catalog of the item being purchased.
				$domainArray[$i]->order->productid = $this->get_productId($available_domains[$i]['tld']);
				$domainArray[$i]->order->quantity = 1;
				$domainArray[$i]->order->duration = 1;
				//$domainArray[$i]->order->riid = "usDom";

				$domainArray[$i]->sld = $available_domains[$i]['sld'];
				$domainArray[$i]->tld = $available_domains[$i]['tld'];
				$domainArray[$i]->period = 1;

				$domainArray[$i]->registrant = $registrant;	
				$domainArray[$i]->admin = clone $registrant;
				$domainArray[$i]->billing = clone $registrant;
				$domainArray[$i]->tech = clone $registrant;

				//$domainArray[$i]->nsArray = $ns;
				$domainArray[$i]->nexus = $nexus;	
				$domainArray[$i]->autorenewflag = 1;
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
				$this->view->error['msg'] = $oXML->result->msg;
			}
		}
	}
		
	function checkproccessAction() {
			//check order status.
			$poll = new poll();
			$poll->sCLTRID = sha1(uniqid(null, true));
			$poll->credential = $cred;
			$strXML = $wapi->poll($poll)->PollResult;
			echo "<br />" . $strXML;
	}
	
	
	protected function getDomainExtension($domain) {
		$domain_price_tb = new Default_Model_DbTable_domainPrices();
		if (!isset($this->_exts)) {
			$this->_exts = $domain_price_tb->getAllSupportedDomains();
		}
		$dm_extension = null;
		foreach ($this->_exts as $ext) {
			$substr = substr($domain, -strlen($ext));
			if (strtoupper($substr) == strtoupper($ext)) {
				$dm_extension = $ext;
				break;
			}
		}
		return $dm_extension;
	}
	
	
	public function findAction() {
		
		
		$this->view->headTitle()->append('your one stop for Profession' );
	
	}
	
	public function huntAction() {
		
		
		$this->view->headTitle()->append('your one stop for Profession' );
	
	}
	
	public function discoverAction() {
		
		
		$this->view->headTitle()->append('your one stop for Profession' );
	
	}
	
	
	
	
	
}
?>
