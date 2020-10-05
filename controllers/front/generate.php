<?php

use \FluidXml\FluidXml;
use \FluidXml\FluidNamespace;
use function \FluidXml\fluidxml;
use function \FluidXml\fluidns;
use function \FluidXml\fluidify;

/**
 * Class Ec_XmlfeedGenerateModuleFrontController
 */
class Ec_XmlfeedGenerateModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = false;

    /** @var bool */
    public $ajax;

    public function display()
    {
      $repProducts= $this->container->get('xmlfeed_xml_feeds_xml_data_mapper_product');


      $entityManager = $this->container->get('doctrine.orm.entity_manager');
      $testRepository = $entityManager->getRepository(PrestaShop\Module\Ec_Xmlfeed\Entity\XmlFeeds::class);
      $feed = $testRepository->findOneBy(array('feed_name' => 'Ceneo'));
        $fields = $feed->getFields();

        $count=0;
        $current_node=null;
        $xml=null;
        foreach ($fields as $field){
            if($count==0){
                $current_node=$xml=  FluidXml::new($field->getXmlFieldPathName(), [/* options */]);
               $count++;
               continue;
            }

       $path=$field->getXmlFieldPathName();

        if(preg_match("/^@/", $path)){
            $current_node->setAttribute(ltrim( $path,"@"),'1');
        }
else{
    $explode_path=explode('/',$path);
    $t= explode('/',$path);
    array_pop($t);;
    $q_dir=implode('/',$t);
    $current_node= $xml->query('/'.$q_dir.'[last()]');
    $current_node= $current_node->add(end($explode_path),true);
}


$count++;
    }
      echo  $xml->xml();



    }


}