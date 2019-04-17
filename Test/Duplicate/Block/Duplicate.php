<?php
namespace Test\Duplicate\Block;

class Duplicate extends \Magento\Framework\View\Element\Template
{
    protected $_page;

    protected $_storeManager;

    protected $_scopeConfig;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Cms\Model\Page $page,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)


	{
		parent::__construct($context);
		$this->_page = $page;
		$this->_storeManager = $storeManager;
		$this->_scopeConfig = $scopeConfig;
	}

	public function metaTag()
	{
	    $issue = $this->checkPageInStores($this->_page->getIdentifier());

	    if($issue){
	        $storeLanguage = $this->getStoreLanguage();
	        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
	        $cmsPageUrl = $this->_page->getIdentifier();
	        return __('<link rel="alternate" hreflang="'.$storeLanguage.'" href="'.$baseUrl . $cmsPageUrl.'" />');
	    }
	    return true;
	}

	private function checkPageInStores($identifier){

	    $stores = $this->_storeManager->getStores();
	    // To return true or false
	    $inMultiStores = false;
	    // Counter to know if this page exists in multiple stores
	    $count = 0;
	    foreach($stores as $store){
	        $exists = $this->_page->checkIdentifier($identifier, $store->getId());
	        // Check if exists is 1 then add to counter 1
	        if($exists){
	            $count ++;
	        }
	    }
	    // if counter is more than 1 = exists in more than a one store then change the var to true
	    if($count > 1){
	        $inMultiStores = true;
	    }

	    return $inMultiStores;
	}

	private function getStoreLanguage(){

	    return $this->_scopeConfig->getValue('storelang/general/store_language',
	        \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
	        $this->_storeManager->getStore()
	        );


	}

}