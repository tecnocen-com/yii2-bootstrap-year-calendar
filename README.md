# Tecnocen Yii2 Bootstrap Year Calendar

[![Latest Stable Version](https://poser.pugx.org/tecnocen/yii2-bootstrap-year-calendar/v/stable)](https://packagist.org/packages/tecnocen/yii2-bootstrap-year-calendar) [![Total Downloads](https://poser.pugx.org/tecnocen/yii2-bootstrap-year-calendar/downloads)](https://packagist.org/packages/tecnocen/yii2-bootstrap-year-calendar) [![Latest Unstable Version](https://poser.pugx.org/tecnocen/yii2-bootstrap-year-calendar/v/unstable)](https://packagist.org/packages/tecnocen/yii2-bootstrap-year-calendar) [![License](https://poser.pugx.org/tecnocen/yii2-bootstrap-year-calendar/license)](https://packagist.org/packages/tecnocen/yii2-bootstrap-year-calendar)

Widget that implements the [bootstrap-year-calendar](http://www.bootstrap-year-calendar.com/) plugin for Yii2

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer require --prefer-dist "tecnocen/yii2-bootstrap-year-calendar:*"
```

or add

```
"tecnocen/yii2-bootstrap-year-calendar": "*"
```

to the `require` section of your `composer.json` file.

## Usage

### Calendar

This is the basic widget which encapsulates the plugin into a `yii\bootstrap\Widget` implementation.

```php

use tecnocen\yearcalendar\Calendar;

echo Calendar::widget([
    // 'language' => 'es',
    'options' => [
        // HTML attributes for the container.
        // the `tag` option is specially handled as the HTML tag name
    ],
    'clientOptions' => [
        // JS Options to be passed to the `calendar()` plugin.
        // see http://bootstrap-year-calendar.com/#Documentation/Options
    ],
    'clientEvents' => [
        // JS Events for the `calendar()` plugin.
        // see http://bootstrap-year-calendar.com/#Documentation/Events
    ]
]);
```

### ActiveCalendar

The data source calendar uses a [dataProvider](http://www.yiiframework.com/doc-2.0/yii-data-dataproviderinterface.html) to load the `dataSource` property passed to the calendar.

The models returned by the dataProvider must implement the `tecnocen\yearcalendar\data\DataItem` interface.

```php
namespace api\models;

use tecnocen\yearcalendar\data\DataItem;
use yii\db\ActiveRecord;
use yii\web\JsExpression;

class Conference extends ActiveRecord implements DataItem
{
    public function getName()
    {
        return $this->name;
    }

    public function getStartDate()
    {
        return new JsExpression("new Date('{$this->start_date}')");
    }

    public function getEndDate()
    {
        return new JsExpression("new Date('{$this->end_date}')");
    }

    // rest of the active record code.
}
```

Once we have the model we can create the dataProvider.

```php
use api\models\Conference;
use tecnocen\yearcalendar\widgets\ActiveCalendar;
use yii\data\ActiveDataProvider;

echo ActiveCalendar::widget([
    // 'language' => 'es',
    'dataProvider' => new ActiveDataProvider([
        'query' => Conference::find()->andWhere(['active' => 1])
    ]),
    'options' => [
        // HTML attributes for the container.
        // the `tag` option is specially handled as the HTML tag name
    ],
    'clientOptions' => [
        // JS Options to be passed to the `calendar()` plugin.
        // The `dataSource` property will be overwritten by the dataProvider.
        // see http://bootstrap-year-calendar.com/#Documentation/Options
    ],
    'clientEvents' => [
        // JS Events for the `calendar()` plugin.
        // see http://bootstrap-year-calendar.com/#Documentation/Events
    ]
])
```

### Language

The bootstrap-year-calendar plugin provides the [following languages]
(https://github.com/Paul-DS/bootstrap-year-calendar/tree/master/js/languages),
`Calendar` and `ActiveCalendar` support automatic translations using the
`$language` class property which automatically will load the required js file
and customize the plugin call.

```php
echo Calendar::widget([
    'options' => ['id' => 'es-calendar'],
    'language' => 'es',
]);
```

Will add the JS File `bootstrap-year-calendar.es.js` to the view and run

```js
jQuery(\'#es-calendar\').calendar({"language":"es"});
```

On the browser.

## Documentation

TODO

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.
