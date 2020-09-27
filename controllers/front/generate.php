<?php


class Ec_XmlfeedGenerateModuleFrontController extends ModuleFrontController
{
    /** @var bool If set to true, will be redirected to authentication page */
    public $auth = false;

    /** @var bool */
    public $ajax;

    public function display()
    {
        $yourService = $this->get('xmlfeed_xml_map_fields_repository');
        $t=$yourService->getXmlMapFields();
        echo print_r($t,1);
    }


}