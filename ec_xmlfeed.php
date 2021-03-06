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

require_once ("install_sql.php");

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
    {
        InstallSql::install_sql_struct();


        return parent::install()
            && $this->registerHook('displayMyAccountBlock')
            && $this->registerHook('displayCustomerAccount'); // TODO: Change the autogenerated stub

    }

function hookdisplayMyAccountBlock($params){

    $url_xmlfeed= $this->context->link->getModuleLink('ec_xmlfeed', 'xmlfeed', array(), Configuration::get('PS_SSL_ENABLED'));


    $this->context->smarty->assign([

        'url_xmlfeed' => $url_xmlfeed
    ]);

    return $this->display(__FILE__, '/views/templates/front/my_account_block.tpl');
}
    function hookdisplayCustomerAccount($params){


        $url_xmlfeed= $this->context->link->getModuleLink('ec_xmlfeed', 'xmlfeed', array(), Configuration::get('PS_SSL_ENABLED'));


        $this->context->smarty->assign([

            'url_xmlfeed' => $url_xmlfeed
        ]);

        return $this->display(__FILE__, '/views/templates/front/customer_account.tpl');



    }

    public function makeToken($salt='') {
        return md5(_COOKIE_KEY_.$salt);
    }
}
