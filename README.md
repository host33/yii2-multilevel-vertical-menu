yii2-multilevel-vertical-menu
=============================

This extension consists of a multilevel vertical menu. It is based on the SMenu extension. The CSS code has been taken from this page: [http://tympanus.net/codrops/2013/04/19/responsive-multi-level-menu/](http://tympanus.net/codrops/2013/04/19/responsive-multi-level-menu/ "http://tympanus.net/codrops/2013/04/19/responsive-multi-level-menu/")

## Demo

[https://yiidemos.oligalma.com/multilevelverticalmenu](https://yiidemos.oligalma.com/multilevelverticalmenu "https://yiidemos.oligalma.com/multilevelverticalmenu")

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require host33/yii2-multilevel-vertical-menu "dev-master"
```

or add

```
"host33/yii2-multilevel-vertical-menu": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
use host33\multilevelverticalmenu\MultilevelVerticalMenu;
echo MultilevelVerticalMenu::widget(
array(
"menu"=>array(
  array("url"=>array(),
               "label"=>"Products",
          array("url"=>array(
                       "route"=>"/product/create"),
                       "label"=>"Create product",),
          array("url"=>array(
                      "route"=>"/product/list"),
                      "label"=>"Product List",),
          array("url"=>array(),
                       "label"=>"View Products",
          array("url"=>array(
                       "route"=>"/product/show",
                       "params"=>array("id"=>3),
                       "htmlOptions"=>array("title"=>"title")),
                       "label"=>"Product 3"),
            array("url"=>array(),
                         "label"=>"Product 4",
                array("url"=>array(
                             "route"=>"/product/show",
                             "params"=>array("id"=>5)),
                             "label"=>"Product 5")))),
          array("url"=>array(
                       "route"=>"/event/create"),
                       "label"=>"Sales"),
          array("url"=>array(
                       "route"=>"/event/create"),
                       "label"=>"Extensions",
                       "visible"=>false),
          array("url"=>array(),
                       "label"=>"Documentation",
              array("url"=>array(
                           "link"=>"http://www.yiiframework.com",
                           "htmlOptions"=>array("target"=>"_BLANK")),
                           "label"=>"Yii Framework"),
          array("url"=>array(),
                       "label"=>"Clothes",
          array("url"=>array(
                       "route"=>"/product/men",
                       "params"=>array("id"=>3),
                       "htmlOptions"=>array("title"=>"title")),
                       "label"=>"Men"),
            array("url"=>array(),
                         "label"=>"Women",
                array("url"=>array(
                             "route"=>"/product/scarves",
                             "params"=>array("id"=>5)),
                             "label"=>"Scarves"))),
              array("url"=>array(
                           "route"=>"site/menuDoc"),
                           "label"=>"Disabled Link",
						   "disabled"=>true),
                )
          ),
    "transition" => 1 // To choose between 1,2,3,4 and 5. 
)
);
```

## License

**yii2-multilevel-vertical-menu** is released under the GPLv3 License. See the bundled `LICENSE.md` for details.
