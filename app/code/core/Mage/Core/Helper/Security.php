<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Core
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2020-2023 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Mage
 * @package    Mage_Core
 */
class Mage_Core_Helper_Security
{
    private $invalidBlockActions
        = [
            ['block' => Mage_Page_Block_Html_Topmenu_Renderer::class, 'method' => 'render'],
            ['block' => Mage_Core_Block_Template::class, 'method' => 'fetchView'],
        ];

    /**
     * @param Mage_Core_Block_Abstract $block
     * @param string                   $method
     * @param string[]                 $args
     *
     * @throws Mage_Core_Exception
     */
    public function validateAgainstBlockMethodBlacklist(Mage_Core_Block_Abstract $block, $method, array $args)
    {
        foreach ($this->invalidBlockActions as $action) {
            $calledMethod = strtolower($method);
            if (str_contains($calledMethod, '::')) {
                $calledMethod = explode('::', $calledMethod)[1];
            }
            if ($block instanceof $action['block'] && strtolower($action['method']) === $calledMethod) {
                Mage::throwException(
                    sprintf('Action with combination block %s and method %s is forbidden.', get_class($block), $method)
                );
            }
        }
    }
}
