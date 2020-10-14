<?php

class InstallSql{

public  static  function install_ceneo(){

    $sql="
START TRANSACTION;
INSERT INTO `ps_xml_feeds` (`id_xml_feeds`, `feed_name`, `active`) VALUES
(1, 'ceneo', 1);

INSERT INTO ps_xml_map_fields (id_xml_map_fields, id_xml_feeds, shop_field_name, xml_field_path_name, custom_value, cdata, `position`, active) VALUES
(7, 1, '', 'offers', '', 0, 1, 1),
(9, 1, '', 'offers/@version', '1', 0, 3, 1),
(10, 1, 'products', 'offers/o[]', '', 0, 4, 1),
(11, 1, 'id', 'offers/o/@id', '', 0, 5, 1),
(12, 1, 'url', 'offers/o/@url', '', 0, 6, 1),
(13, 1, 'price', 'offers/o/@price', '', 0, 7, 1),
(14, 1, 'active', 'offers/o/@avail', '', 0, 8, 1),
(15, 1, 'quantity', 'offers/o/@stock', '', 0, 9, 1),
(16, 1, 'category_path', 'offers/o/cat', '', 0, 10, 1),
(17, 1, 'description', 'offers/o/desc', '', 0, 11, 1),
(18, 1, 'name', 'offers/o/name', '', 0, 12, 1),
(19, 1, '', 'offers/o/imgs', '', 0, 16, 1),
(23, 1, 'image_cover', 'offers/o/imgs/main', '', 0, 21, 1),
(24, 1, 'images', 'offers/o/imgs/i[]', '', 0, 22, 1),
(25, 1, 'url', 'offers/o/imgs/i/@url', '', 0, 23, 1),
(27, 1, '', 'offers/o/attrs', '', 0, 13, 1),
(28, 1, 'manufacturer_name', 'offers/o/attrs/a', '', 0, 14, 1),
(29, 1, '', 'offers/o/attrs/a/@name', 'Producent', 0, 15, 1),
(30, 1, 'ean13', 'offers/o/attrs/a', '', 0, 17, 1),
(31, 1, '', 'offers/o/attrs/a/@name', 'EAN', 0, 18, 1),
(32, 1, 'reference', 'offers/o/attrs/a', '', 0, 19, 1),
(33, 1, '', 'offers/o/attrs/a/@name', 'Kod Producenta', 0, 20, 1);
COMMIT;

";
    Db::getInstance()->execute($sql);
}

}