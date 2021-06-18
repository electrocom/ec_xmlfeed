<?php

use Doctrine\DBAL\Connection;
use \FluidXml\FluidXml;
use \FluidXml\FluidNamespace;
use function \FluidXml\fluidxml;
use function \FluidXml\fluidns;
use function \FluidXml\fluidify;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FacebookFeed;

use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedGenerator;
/**
 * Class Ec_XmlfeedGenerateModuleFrontController
 */
class Ec_XmlfeedGenerateModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = false;

    /** @var bool */
    public $ajax;
    private $xml=null;
    private $xmlDataMaps;
    private $formatxml=null;
    private $id_customer=0;

public function postProcess() {
        parent::postProcess();

        $this->id_customer = (int)Tools::getValue('id_customer');
        $xTokenOk = Tools::getValue('token') == $this->module->makeToken($this->id_customer);
        if(!$xTokenOk){
            die('bad xtoken1');
        }

        $this->formatxml=Tools::getValue('format');
        if(empty($this->formatxml)){
            die('bad xml format');
        }

    }

public function display()
    {
        set_time_limit(0);


        $feedGenerator = new FeedGenerator($this->formatxml);

        $feedGenerator->getXml();
die();
    }


private function builCustomXml(){

    if (!$this->context->customer->isLogged()){
        die('ACCESS DENIED');
    }


    $this->xmlDataMaps= $this->get('xmlfeed_xml_feeds_xml_data_mapper'); // Dane produktów
    $repFeeds= $this->container->get('xmlfeed_xml_feeds_repository'); //nazwy generowanych struktu
    $feedStruct = $repFeeds->getFeed($this->formatxml);
    if(empty($feedStruct)){
        die('bad xml format');
    }
    set_time_limit ( 180 ) ;
    $xmlStruct = $feedStruct->getFields();


    $this->buildXmlTree($xmlStruct,'',$this->xmlDataMaps);


    header("Content-type: text/xml");
    echo $this->xml->xml();

}

private function buildXmlTree( &$xmlStruct,$xpath='',$current_data=null)
    {

        foreach ($xmlStruct as $key =>$field)
        {
            $path=$field->getXmlFieldPathName();
            $is_arr=0;
            $path=str_replace('[]','',$path,$is_arr);

            if($xpath!=''&&!strstr($path,$xpath))
                continue;



            if($is_arr)
            {
            $tmp=$current_data->getval($field->getShopFieldName());

                foreach ($tmp as $key2=>$value)
                {
                    $field->getShopFieldName();
                    $this->addToXmlTree($path);
                    $this->buildXmlTree($xmlStruct,$path.'/',$tmp);
                }
                return;
            }else {
                $v=empty($field->getCustomValue())?$current_data->getval($field->getShopFieldName()):$field->getCustomValue();
                $this->addToXmlTree($path, $v,$field->getCdata());
            }


        }
    }


private function addToXmlTree($path,$data='',$cdata=0)
    {

        if ($this->xml == null) {
            $current_node = $this->xml = FluidXml::new($path);
            return;
        }

        if($data=='')
            $data=null;
        $explode_path = explode('/', $path);
        $t = explode('/', $path);
        array_pop($t);

        $t = array_map(function ($str) {
            return $str . '[last()]';
        }, $t);
        $q_dir = implode('/', $t);
        $q_dir . end($explode_path) . PHP_EOL;
        $current_node = $this->xml->query('/' . $q_dir . '[last()]');

        if (strstr($path, "@"))
            $current_node-> attr (substr($path, strpos($path, "@") + 1), $data);
        else
            if($cdata)
            $current_node->add(end($explode_path),  true)->setCdata($data);
            else
            $current_node->add(end($explode_path),  true)->setText($data);
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
