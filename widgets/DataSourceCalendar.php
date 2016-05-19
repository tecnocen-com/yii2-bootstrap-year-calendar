<?php

namespace tecnocen\yearcalendar\widgets;

use yii\data\DataProviderInterface;
use tecnocen\yearcalendar\data\DataSourceItem;

class DataSourceCalendar extends BootstrapYearCalendar
{
    /**
     * @var DataProviderInterface the data provider for the view. This property
     * is required.
     */
    public $dataProvider;

    /**
     * @var callable replaces the functionality of `prepareModel()` method.
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
    public $prepareModel;

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

            $rows[$key] = $this->prepareModel($model, $key, $index);
        }

        $this->clientOptions['dataSource'] = $rows;
    }

    public function prepareModel(DataSourceItem $model, $key, $index)
    {
        if ($this->prepareModel !== null) {
            return call_user_func(
                $this->prepareModel,
                $model,
                $key,
                $index,
                $this
            );
        }

        $dataSource = $model->toArray();
        $dataSource['name'] = $model->getName();
        $dataSource['startDate'] = $model->getStartDate();
        $dataSource['endDate'] = $model->getEndDate();
        return $dataSource;
    }
}
