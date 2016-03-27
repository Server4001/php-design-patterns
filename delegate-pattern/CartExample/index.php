<?php

class Registry{}

class Cart
{
    private $data = array();

    public function getProducts()
    {
        $pretendThisComesFromSession = array("this would be array of products in cart");

        foreach ($pretendThisComesFromSession as $key => $quantity) {
            $product = unserialize(base64_decode($key));

            $customProductTypeId = CustomProductType::REGULAR_PRODUCT_TYPE_ID;
            if (isset($product["custom_product_type_id"]) && (int)$product["custom_product_type_id"] > 0) {
                $customProductTypeId = (int)$product["custom_product_type_id"];
            }

            try {
                $productDataDelegator = new ProductDataDelegator(new Registry(), $customProductTypeId);
                $this->data[$key] = $productDataDelegator->getProductData($key, $product, $quantity);
            } catch (Exception $e) {
                // Handle this
            }
        }

        return $this->data;
    }
}

class CustomProductType
{
    const REGULAR_PRODUCT_TYPE_ID = 1;
    const PROPOSAL_PRODUCT_TYPE_ID = 2;
    const FINE_ART_PRODUCT_TYPE_ID = 3;

    public static function getActionClassInstance($id)
    {
        $mappings = array(
            self::REGULAR_PRODUCT_TYPE_ID => function (Registry $registry) {
                return new RegularProductCartAction($registry);
            },
            self::PROPOSAL_PRODUCT_TYPE_ID => function (Registry $registry) {
                return new ProposalCartAction($registry);
            },
            self::FINE_ART_PRODUCT_TYPE_ID => function (Registry $registry) {
                return new FineArtCartAction($registry);
            },
        );

        if (!array_key_exists($id, $mappings)) {
            throw new Exception("Invalid custom product type id.");
        }

        return $mappings[$id];
    }
}

class ProductDataDelegator
{
    /**
     * @var CartAction
     */
    private $cartAction;

    /**
     * ProductDataDelegator constructor.
     *
     * @param Registry $registry
     * @param $customProductTypeId
     *
     * @throws Exception
     */
    public function __construct(Registry $registry, $customProductTypeId)
    {
        $classCallback = CustomProductType::getActionClassInstance($customProductTypeId);
        $this->cartAction = $classCallback($registry);
    }

    public function getProductData($key, $product, $quantity)
    {
        return $this->cartAction->getProductData($key, $product, $quantity);
    }
}

interface CartAction
{
    public function __construct(Registry $registry);
    public function getProductData($key, $product, $quantity);
}

class RegularProductCartAction implements CartAction
{
    private $registry;
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }
    public function getProductData($key, $product, $quantity)
    {
        return array("I am a regular product");
    }
}

class ProposalCartAction implements CartAction
{
    private $registry;
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }
    public function getProductData($key, $product, $quantity)
    {
        return array("I am a proposal product");
    }
}

class FineArtCartAction implements CartAction
{
    private $registry;
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }
    public function getProductData($key, $product, $quantity)
    {
        return array("I am a fine art product");
    }
}
