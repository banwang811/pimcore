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

namespace Pimcore\Bundle\EcommerceFrameworkBundle\Tracking;

interface IProductView
{
    /**
     * Track product view
     *
     * @param \Pimcore\Bundle\EcommerceFrameworkBundle\Model\IProduct $product
     */
    public function trackProductView(\Pimcore\Bundle\EcommerceFrameworkBundle\Model\IProduct $product);
}
