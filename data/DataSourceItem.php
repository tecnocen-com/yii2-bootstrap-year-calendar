<?php

namespace tecnocen\yearcalendar\data;

use Date;
use yii\web\JsExpression;

/**
 * Interface to provide the structure for the items in the `dataSource` option
 * for bootstra-year-calendar plugin.
 *
 * @author Angel (Faryshta) Guevara <aguevara@tecnocen.com>
 */
interface DataSourceItem extends \yii\base\Arrayable
{
    /**
     * Gets the `name` property of the `dataSource` item.
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the `startDate` property of a `dataSource` item.
     *
     * @return JsExpression containing a js `Date` object
     */
    public function getStartDate();


    /**
     * Gets the `endDate` property of a `dataSource` item.
     *
     * @return JsExpression containing a js `Date` object
     */
    public function getEndDate();
}
