<?php
namespace PrestaShop\Module\Ec_Xmlfeed\XMLDataMapper;

class XMLDataMapper{
    private array $arrayDataMapper = [];
    private array $products = [];

    public function __construct($products)
    {
        $this->arrayDataMapper=array(
            "products" => function()  {$this->products->next();},
            "products.id" => function(){},
            "products.url" => function(){},
            "products.price" => function(){},
            "products.available" => function(){},
            "products.price" => function(){},
            "products.quantity" => function(){},
            "products.path_cat" => function(){},
            "products.short_description" => function(){},
            "products.long_description" => function(){},
            "products.features" => function(){},
            "products.features.name" => function(){},
            "products.features.value" => function(){},
            "products.images" => function(){},
            "products.images.url" => function(){},
            "products.images.cover.url" => function(){},
        );

        $this->products=$products;
    }

    function getMapperData($fieldName){

    }


}