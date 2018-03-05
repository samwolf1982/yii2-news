News module for Yii2
====================
News module for Yii2 advanced template.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist snapget/yii2-news "*"
```

or add

```
"snapget/yii2-news": "*"
```

to the require section of your `composer.json` file.


Migrations
----------

To apply module migrations run command

```
./yii migrate --migrationPath=@snapget/news/migrations
```

Configure application
---------------------

Let's start with defining module in `@common/config/main.php`:

```php
......
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        'news' => [
            'class' => 'snapget\news\Module',
        ],
    ],
......
```

> Note: Module requires `\kartik\tree\Module`, so your configuration should looks like above.


Restrict access to admin controller from frontend. Open `@frontend/config/main.php` and add following:

```php
'modules' => [
    'news' => [
        // following line will restrict access to `admin-news-category` and `admin-news` controllers from frontend application
        'as frontend' => 'snapget\news\filters\FrontendFilter',
        'baseImageUrl' => 'http://news/upload/news',    // needs here absolute url
    ],
],
```

Restrict access to `news` controller from backend. 
Open `@backend/config/main.php` and add the following:

```php
'modules' => [
    'news' => [
        // following line will restrict access to `news` controller from frontend application
        'as backend' => 'snapget\news\filters\BackendFilter',
        'baseImageUrl' => 'http://news/upload/news',    // needs here absolute url
    ],
],
```

Usage
-----

Go to `/admin-news-category` route to manage news categories.

Go to `/admin-news` route to manage news.

Go to `/news/news` route to view frontend news view.