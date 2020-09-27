<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

declare(strict_types=1);

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\Module\Ec_Xmlfeed\Entity;
class Ec_Xmlfeed extends Module
{
    public function __construct()
    {
        $this->name = 'ec_xmlfeed';
        $this->author = 'kmkm2';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('XMLFeed', array(), 'Modules.Ec_Xmlfeed.Admin');
        $this->description = $this->trans(
            'Moduł do generowania plików XML',
            array(),
            'Modules.Ec_Xmlfeed.Admin'
        );

        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
    }

    public function install()
    {   $sql="CREATE TABLE  IF NOT EXISTS "._DB_PREFIX_."xml_map_fields ( `id_xml_map_fields` INT NOT NULL AUTO_INCREMENT , `shop_field_name` VARCHAR(255) NOT NULL , `xml_field_path_name` VARCHAR(255) NOT NULL , `position` INT NOT NULL , `active` INT NOT NULL , PRIMARY KEY (`id_xml_map_fields`)) ENGINE = InnoDB;";
        Db::getInstance()->execute($sql);

        $sql="CREATE TABLE  IF NOT EXISTS "._DB_PREFIX_."xml_feeds ( `id_xml_feeds` INT NOT NULL AUTO_INCREMENT ,  `feed_name` VARCHAR(255) NOT NULL ,  `xml_inject_path` VARCHAR(255) NOT NULL ,  `active` TINYINT(1) NOT NULL ,    PRIMARY KEY  (`id_xml_feeds`)) ENGINE = InnoDB;";
        Db::getInstance()->execute($sql);

        return parent::install(); // TODO: Change the autogenerated stub

    }

    public function getContent()
    {

    }
}