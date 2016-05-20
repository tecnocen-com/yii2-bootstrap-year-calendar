<?php

namespace tecnocen\yearcalendar\tests\data;

use yii\web\JsExpression;

class DataItem extends \yii\base\Model
    implements \tecnocen\yearcalendar\data\DataItem
{
    private $name;
    private $startDate;
    private $endDate;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getStartDate()
    {
        return $this->startDate;
    }
    public function setStartDate($date)
    {
        $this->startDate = new JsExpression("new Date('$date')");
    }
    public function getEndDate()
    {
        return $this->endDate;
    }
    public function setEndDate($date)
    {
        $this->endDate = new JsExpression("new Date('$date')");
    }
}
