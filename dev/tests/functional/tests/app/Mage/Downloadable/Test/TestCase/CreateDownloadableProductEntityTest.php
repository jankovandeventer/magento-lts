<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Tests
 * @package    Tests_Functional
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage\Downloadable\Test\TestCase;

use Mage\Catalog\Test\Fixture\CatalogCategory;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProduct;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductNew;
use Mage\Downloadable\Test\Fixture\DownloadableProduct;
use Magento\Mtf\TestCase\Injectable;

/**
 * Steps:
 * 1. Log in to Backend.
 * 2. Navigate to Catalog -> Manage Products.
 * 3. Start to create new Downloadable product.
 * 4. Fill in data according to data set.
 * 5. Save product.
 * 6. Perform all assertions.
 *
 * @group Downloadable_Product_(CS)
 * @ZephyrId MPERF-6884
 */
class CreateDownloadableProductEntityTest extends Injectable
{
    /**
     * Product page with a grid.
     *
     * @var CatalogProduct
     */
    protected $catalogProductIndex;

    /**
     * New product page on backend.
     *
     * @var CatalogProductNew
     */
    protected $catalogProductNew;

    /**
     * Persist category.
     *
     * @param CatalogCategory $category
     * @return array
     */
    public function __prepare(CatalogCategory $category)
    {
        $category->persist();

        return ['category' => $category];
    }

    /**
     * Filling objects of the class.
     *
     * @param CatalogProduct $catalogProductIndexNewPage
     * @param CatalogProductNew $catalogProductNewPage
     * @return void
     */
    public function __inject(CatalogProduct $catalogProductIndexNewPage, CatalogProductNew $catalogProductNewPage)
    {
        $this->catalogProductIndex = $catalogProductIndexNewPage;
        $this->catalogProductNew = $catalogProductNewPage;
    }

    /**
     * Test create downloadable product.
     *
     * @param DownloadableProduct $product
     * @param CatalogCategory $category
     * @return void
     */
    public function test(DownloadableProduct $product, CatalogCategory $category)
    {
        // Steps
        $this->catalogProductIndex->open();
        $this->catalogProductIndex->getGridPageActionBlock()->addNew();
        $this->catalogProductNew->getProductForm()->fill($product, null, $category);
        $this->catalogProductNew->getFormPageActions()->save();
    }
}
