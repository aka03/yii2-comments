Yii2 Comments
=============
Yii2 Simple Comments Widget

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist aka03/yii2-comments "*"
```

or add

```
"aka03/yii2-comments": "*"
```

to the require section of your `composer.json` file.


Migration
---------

```
php yii migrate --migrationPath=@vendor/aka03/yii2-comments/src/migrations
```


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \aka03\comments\CommentWidget::widget([
    'page' => $this->context->id,
    'page_id' => $model->id,
]); ?>
```

If you want to use this widget in module, change `page` attribute into:

```php
'page' => $this->context->module->id
```


Attributes
----------

`page` using for indicate current controller for showing comments.

`page_id` using for indicate current id. If this attribute is set each `page` will have own comments.

For example if current route = 'site/about', you can add following code:

```php
<?= \aka03\comments\CommentWidget::widget([
    'page' => 'site',
    'page_id' => 'about'
]); ?>
```

For simple `page` you can set `page_id` = null, or do not even set.

```php
<?= \aka03\comments\CommentWidget::widget([
    'page' => 'about'
]); ?>
```

`guestCanLeaveComment` (boolean, default = true). If user is not logged in, he can't leave comments.

`showCommentsForGuests` (boolean, default = true). Show comments for guest users ().

`showRelativeTime` (boolean, default = true). Show time as relative. False means datetime will be shown.

`avatarField` (string, default = 'avatar'). User avatar field in database.
If this field not found, default avatar will be used.

Full code should looks like:
```php
<?= \aka03\comments\CommentWidget::widget([
    'page' => $this->context->id,
    'page_id' => $model->id,
    'guestCanLeaveComment' => true,
    'showCommentsForGuests' => true,
    'showRelativeTime' => true,
    'avatarField' => 'avatar',
]); ?>
```


Tests
-----

```php
codecept run
```

For coverage add following lines into indet-test.php file, before Application->run().

```php
include dirname(dirname(__DIR__)) . '/vendor/aka03/yii2-comments/c3.php';

define('MY_APP_STARTED', true);
```

Change `c3_url` to frontend/index-test.php, in codeception.yml file. (For example `http://localhost/index-test.php`).

For acceptance tests:
- do not forget install selenium-server;
- change `url` in tests/acceptance.suite.yml file;
- add following lines to test config file:
    
```php
'bootstrap' => [
    'aka03\comments\modules\testPage\Bootstrap'
],
'modules' => [
    'testPage' => [
        'class' => 'aka03\comments\modules\testPage\Module',
    ],
]
```
