<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createOne([
            'name' => 'clothing',
            'childrenCategories' => CategoryFactory::createSequence(
                function () {
                    foreach ($this->getClothingCategoryData() as $name) {
                        yield ['name' => $name];
                    }
                }
            ),
        ]);

        CategoryFactory::createOne([
            'name' => 'footwear',
            'childrenCategories' => CategoryFactory::createSequence(
                function () {
                    foreach ($this->getFootwearCategoryData() as $name) {
                        yield ['name' => $name];
                    }
                }
            ),
        ]);

        CategoryFactory::createOne([
            'name' => 'accessories',
            'childrenCategories' => CategoryFactory::createSequence(
                function () {
                    foreach ($this->getAccessoryCategoryData() as $name) {
                        yield ['name' => $name];
                    }
                }
            ),
        ]);
    }

    /**
     * @return string[]
     */
    private function getClothingCategoryData(): array
    {
        return [
            'dresses',
            't-shirts',
            'tops',
            'trousers',
            'shirts',
            'coats',
        ];
    }

    /**
     * @return string[]
     */
    private function getFootwearCategoryData(): array
    {
        return [
            'sneakers',
            'boots',
            'pumps',
            'sports shoes',
            'low shoes',
        ];
    }

    /**
     * @return string[]
     */
    private function getAccessoryCategoryData(): array
    {
        return [
            'jewellery',
            'hats',
            'beanies',
            'gloves',
            'mittens',
            'handbags',
            'watches',
            'bags',
            'cases',
            'backpacks',
            'scarves',
            'shawls',
        ];
    }

    /**
     * @return string[]
     */
    private function getParentCategoryData(): array
    {
        return [
            'clothing',
            'footwear',
            'accessories',
        ];
    }
}
