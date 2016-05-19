<?php

namespace tecnocen\yearcalendar\widgets;

use tecnocen\yearcalendar\assets\BootstrapYearCalendar as BYCAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @author Angel (Faryshta) Guevara <aguevara@tecnocen.com>
 */
class BootstrapYearCalendar extends \yii\bootstrap\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerPlugin('calendar');
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        return Html::tag($tag, '', $this->options);
    }

    /**
     * @inheritdoc
     */
    protected function registerPlugin($name)
    {
        BYCAsset::register($this->getView());
        parent::registerPlugin($name);
    }
}
