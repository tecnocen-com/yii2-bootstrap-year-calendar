# Tecnocen-com Yii2 Bootstrap Year Calendar

TODO: poser badges

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

### BootstraYearCalendar

This is the basic widget which encapsulates the plugin into a `yii\bootstrap\Widget` implementation.

```php

use tecnocen\yearcalendar\BootstrapYearCalendar;

echo BootstrapYearCalendar::widget([
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

### DataSourceCalendar

The data source calendar uses a [dataProvider](http://www.yiiframework.com/doc-2.0/yii-data-dataproviderinterface.html) to load the `dataSource` property passed to the calendar.

The models returned by the dataProvider must implement the `tecnocen\yearcalendar\data\DataSourceItem` interface.

```php
namespace api\models;

use tecnocen\yearcalendar\data\DataSourceItem;
use yii\db\ActiveRecord;
use yii\web\JsExpression;

class Conference extends ActiveRecord implements DataSourceItem
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
use tecnocen\yearcalendar\widgets\DataSourceCalendar;
use yii\data\ActiveDataProvider;

echo DataSourceCalendar::widget([
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

## Documentation

TODO

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.
