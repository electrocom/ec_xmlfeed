<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use Doctrine\DBAL\Connection;

class XmlBuilder{

    public function __construct(
        Connection $connection,
        $databasePrefix

    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

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


}