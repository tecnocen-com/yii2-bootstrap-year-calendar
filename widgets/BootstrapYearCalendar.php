<?php

namespace tecnocen\yearcalendar\widgets;

use tecnocen\yearcalendar\assets\BootstrapYearCalendarLanguage as LanguageAsset;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @author Angel (Faryshta) Guevara <aguevara@tecnocen.com>
 */
class BootstrapYearCalendar extends \yii\bootstrap\Widget
{
    /**
     * @var string the locale ID (e.g. 'fr', 'de', 'en-GB') for the language to * be used by the date picker. If this property is empty, then the current
     * application language will be used.
     */
    public $language;
    /**
     * @inheritdoc
     */
    public function run()
    {
        $language = $this->language
            ? $this->language
            : substr(Yii::$app->language, 0, 2);

        $assetBundle = LanguageAsset::register($this->getView());
        $assetBundle->language = $language;
        $this->clientOptions['language'] = $language;

        $this->registerPlugin('calendar');
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        return Html::tag($tag, '', $this->options);
    }
}
