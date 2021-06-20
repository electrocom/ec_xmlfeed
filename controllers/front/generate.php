<?php
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use \FluidXml\FluidXml;

use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedGenerator;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedFilterCriteria;
/**
 * Class Ec_XmlfeedGenerateModuleFrontController
 */
class Ec_XmlfeedGenerateModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = false;

    /** @var bool */
    public $ajax;

    private $formatxml=null;
    private $id_customer=0;

public function postProcess() {
        parent::postProcess();
        $this->id_customer = (int)Tools::getValue('id_customer');
if( empty($this->id_customer)){
    \Context::getContext()->customer->logout();
}else{
    $xTokenOk = Tools::getValue('token') == $this->module->makeToken($this->id_customer);

    if(!$xTokenOk){
        die('bad xtoken1');
    }

    $this->logInbyIdCustomer($this->id_customer);
}





        $this->formatxml=Tools::getValue('format');
        if(empty($this->formatxml)){
            die('bad xml format');
        }

    }

public function display()
    {        $entityManager = $this->container->get('doctrine.orm.entity_manager');


        $repFeeds= $this->container->get('xmlfeed_xml_feeds_repository'); //nazwy generowanych struktu
        $feedData= $repFeeds->getFeed($this->formatxml);

      //  $filter= $serializer->deserialize($feedData->getFilter(),FeedFilterCriteria::class, 'json');

       //$filter= new FeedFilterCriteria();
        //$filter->idsCategories=array(13,11);
        //$feedStruct->setFilter( json_encode($filter));
    //    $entityManager->persist($feedStruct);
        //$entityManager->flush();



        $feedGenerator = new FeedGenerator($feedData);

        $feedGenerator->getXml();
die();
    }



private function logInbyIdCustomer($id_customer){

    if(!$id_customer || $id_customer < 0){
        die('bad $id_customer');
    }

    $customer = new Customer($id_customer);
    if (!Validate::isLoadedObject($customer)){
        die('bad customer object');
    }
    $customer->logged = 1;
    $this->context->customer = $customer;
    $this->context->cookie->id_customer = $customer->id;
    $this->context->cookie->customer_lastname = $customer->lastname;
    $this->context->cookie->customer_firstname = $customer->firstname;
    $this->context->cookie->logged = 1;
    $this->context->cookie->check_cgv = 1;
    $this->context->cookie->is_guest = $customer->isGuest();
    $this->context->cookie->passwd = $customer->passwd;
    $this->context->cookie->email = $customer->email;
}

}