<?php

use Doctrine\DBAL\Connection;
use \FluidXml\FluidXml;
use \FluidXml\FluidNamespace;
use function \FluidXml\fluidxml;
use function \FluidXml\fluidns;
use function \FluidXml\fluidify;

/**
 * Class Ec_XmlfeedXmlfeedModuleFrontController
 */
class Ec_XmlfeedXmlfeedModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = true;

    /** @var bool */
    public $ajax;

    public function initContent()
    {
        parent::initContent();

        $id_customer=$this->context->customer->id;
        $token_xml=$this->module->makeToken($id_customer);
        $url_generate_small= $this->context->link->getModuleLink('ec_xmlfeed', 'generate', array('token'=>$token_xml,'id_customer'=>$id_customer,'format'=>'smallxml'), Configuration::get('PS_SSL_ENABLED'));
        $url_generate_full= $this->context->link->getModuleLink('ec_xmlfeed', 'generate', array('token'=>$token_xml,'id_customer'=>$id_customer,'format'=>'Ceneo'), Configuration::get('PS_SSL_ENABLED'));
        $url_rss= $this->context->link->getModuleLink('ec_xmlfeed', 'generate', array('token'=>$this->module->makeToken(0),'format'=>'facebook'), Configuration::get('PS_SSL_ENABLED'));


        $this->context->smarty->assign('header_title','Eksport Xml');
        $this->context->smarty->assign('url_generate_small',$url_generate_small);
        $this->context->smarty->assign('url_generate_full',$url_generate_full);
        $this->context->smarty->assign('url_generate_rss',$url_rss);
        $this->context->smarty->assign('token_xml',$token_xml);
        $this->context->smarty->assign('id_customer',$id_customer);

        $this->setTemplate('module:ec_xmlfeed/views/templates/front/xmlfeed.tpl');
    }




}