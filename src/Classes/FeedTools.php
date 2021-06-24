<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use PrestaShop\PrestaShop\Adapter\Shop\Context;


class FeedTools
{


   public function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }

    public  function getTitle(){
        $sql='SELECT l.`title` FROM ps_meta m INNER JOIN ps_meta_lang l ON m.`id_meta` = l.`id_meta` WHERE (l.`id_lang` = 1) AND (l.`id_shop` = 1) AND (m.`configurable`=1) AND (m.page=\'index\')';
        return  \Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }
    public  function getDescription(){
        $sql='SELECT l.`description` FROM ps_meta m INNER JOIN ps_meta_lang l ON m.`id_meta` = l.`id_meta` WHERE (l.`id_lang` = 1) AND (l.`id_shop` = 1) AND (m.`configurable`=1) AND (m.page=\'index\')';
        return  \Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }

    public function getBaseUrl(){
        return _PS_BASE_URL_ . __PS_BASE_URI__;
    }

   public  function CheckIsLogged()
    {
        if (Context::getContext()->customer->isLogged()) {
            Context::getContext()->customer->logout();
            die ('Błąd użytkownik zalogowany');


        }
    }


public function getProductImagesLink   ($product){
$allimg=$product->getWsImages();
$link = \Context::getContext()->link;
$images_link=array();
$img_cunter=0;
foreach($allimg as $img) {
if($img_cunter>5)
break;
$images_link[] = $link->getImageLink($product->link_rewrite[1], $img['id'], 'large_default');
$img_cunter++;
}

return $images_link;
   }


    function getCategoryPath($id_category,$witoutlast=0){

        $context = \Context::getContext();
        $home=false;
        $path='';
        $url_base='';
        $category = \Db::getInstance()->getRow('
		SELECT id_category, level_depth, nleft, nright
		FROM '._DB_PREFIX_.'category
		WHERE id_category = '.(int)$id_category);
        if (isset($category['id_category'])) {
            $sql = 'SELECT c.id_category, cl.name, cl.link_rewrite,c.level_depth
					FROM '._DB_PREFIX_.'category c
					LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = c.id_category'.\Shop::addSqlRestrictionOnLang('cl').')
					WHERE c.nleft <= '.(int)$category['nleft'].'
						AND c.nright >= '.(int)$category['nright'].'
						AND cl.id_lang = '.(int)$context->language->id.
                ($home ? ' AND c.id_category='.(int)$id_category : '').'
						AND c.id_category != '.(int)\Category::getTopCategory()->id.'
					GROUP BY c.id_category
					ORDER BY c.level_depth ASC
					LIMIT '.(!$home ? (int)$category['level_depth'] + 1 : 1);

            $categories = \Db::getInstance()->executeS($sql);
            $full_path = '';
            $n = 0;
            $n_categories = (int)count($categories);



            foreach ($categories as $category) {

                if($category['level_depth']>3)
                    continue;

               // if($witoutlast&&$n<$n_categories)
                //    continue;

                $full_path .= '/'.$category['name'];

                $n++;
            }
            return $full_path.$path;
        }

    }

}