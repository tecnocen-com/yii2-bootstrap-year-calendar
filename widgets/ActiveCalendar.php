<?php

namespace tecnocen\yearcalendar\widgets;

use yii\data\DataProviderInterface;
use tecnocen\yearcalendar\data\DataItem;

class ActiveCalendar extends Calendar
{
    /**
     * @var DataProviderInterface the data provider for the view. This property
     * is required.
     */
    public $dataProvider;

    /**
     * @var callable replaces the functionality of `prepareItem()` method.
     * the signature must be
     * ```php
     * function (DataSourceItem $model, $key, $inde, $widget)
     * ```
     *
     * - `$model`: the current data model being rendered
     * - `$key`: the key value associated with the current data model
     * - `$index`: the zero-based index of the data model in the model array returned by [[dataProvider]]
     * - `$widget`: the DataSourceCalendar object
     */
    public $prepareItem;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->dataProvider === null
            || !$this->dataProvider instanceof DataProviderInterface
        ) {
            throw new InvalidConfigException(
                'The "dataProvider" property must be set.'
            );
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->prepareDataSource();
        return parent::run();
    }

    public function prepareDataSource()
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];

            $rows[] = $this->prepareItem($model, $key, $index);
        }

        $this->clientOptions['dataSource'] = $rows;
    }

    public function prepareItem(DataItem $model, $key, $index)
    {
        if ($this->prepareItem !== null) {
            return call_user_func(
                $this->prepareItem,
                $model,
                $key,
                $index,
                $this
            );
        }

        $item = $model->toArray();
        $item['name'] = $model->getName();
        $item['startDate'] = $model->getStartDate();
        $item['endDate'] = $model->getEndDate();
        return $item;
    }
}
