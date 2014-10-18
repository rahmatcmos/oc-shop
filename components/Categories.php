<?php namespace DShoreman\Shop\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use DShoreman\Shop\Models\Category as ShopCategory;

class Categories extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Category List',
            'description' => 'Displays a list of shop categories on the page.',
        ];
    }

    public function defineProperties()
    {
        return [
            'categoryPage' => [
                'title'       => 'Category page',
                'description' => 'Name of the page file to use for the category links. This property is used by the default component partial.',
                'type'        => 'dropdown',
                'default'     => 'shop/category',
                'group'       => 'Links',
            ],
            'listClass' => [
                'title'       => 'List class',
                'description' => 'The classes to apply to the <ul> element in the default partial.',
                'default'     => '',
                'group'       => 'Styles',
            ],
            'listItemClass' => [
                'title'       => 'List item class',
                'description' => 'The classes to apply to child <li> elements in the default partial.',
                'default'     => '',
                'group'       => 'Styles',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->categories = $this->page['categories'] = $this->listCategories();
    }

    public function prepareVars()
    {
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->listClass = $this->page['listClass'] = $this->property('listClass');
        $this->listItemClass = $this->page['listItemClass'] = $this->property('listItemClass');
    }

    public function listCategories()
    {
        $categories = ShopCategory::all();

        $categories->each(function($category)
        {
            $category->setUrl($this->categoryPage, $this->controller);
        });

        return $categories;
    }

}
