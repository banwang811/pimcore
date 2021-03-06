<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\Action;

class Gift implements IGift
{
    /**
     * @var \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct
     */
    protected $product;

    /**
     * @param \Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\IEnvironment $environment
     *
     * @return IGift
     */
    public function executeOnProduct(\Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\IEnvironment $environment)
    {
        // TODO: Implement executeOnProduct() method.
    }

    /**
     * @param \Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\IEnvironment $environment
     *
     * @return IGift
     */
    public function executeOnCart(\Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\IEnvironment $environment)
    {
        $comment = $environment->getRule()->getDescription();
        $environment->getCart()->addGiftItem($this->getProduct(), 1, null, true, [], [], $comment);
    }

    /**
     * set gift product
     * @param \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct $product
     *
     * @return IGift
     */
    public function setProduct(\Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct
     */
    public function getProduct()
    {
        return $this->product;
    }


    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode([
                                'type' => 'Gift',
                                'product' => $this->getProduct() ? $this->getProduct()->getFullPath() : null,
                           ]);
    }

    /**
     * @param string $string
     *
     * @return \Pimcore\Bundle\EcommerceFrameworkBundle\PricingManager\ICondition
     */
    public function fromJSON($string)
    {
        $json = json_decode($string);
        $product = \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct::getByPath($json->product);

        if ($product) {
            $this->setProduct($product);
        }

        return $this;
    }

    /**
     * dont cache the entire product object
     * @return array
     */
    public function __sleep()
    {
        if ($this->product) {
            $this->product = $this->product->getFullPath();
        }

        return ['product'];
    }

    /**
     * restore product
     */
    public function __wakeup()
    {
        if ($this->product != '') {
            $this->product = \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct::getByPath($this->product);
        }
    }
}
