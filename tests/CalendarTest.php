<?php
namespace tecnocen\yearcalendar\tests;

use tecnocen\yearcalendar\widgets\Calendar;
use tecnocen\yearcalendar\assets\Language;
use Yii;
use yii\web\View;

/**
 * Test the functionality for the bootstrap-year-calendar plugin
 */
class CalendarTest extends TestCase
{

    public function testLanguage()
    {
        $view = Yii::$app->view;
        $expected = <<<'HTML'
<div id="es-calendar"></div>
HTML;

        $this->assertEquals($expected, Calendar::widget([
            'language' => 'es',
            'options' => ['id' => 'es-calendar'],
        ]));

        $this->assertEquals(
            'jQuery(\'#es-calendar\').calendar({"language":"es"});',
            end($view->js[View::POS_READY])
        );

        $this->assertTrue(isset($view->assetBundles[Language::className()]));
        $languageAsset  = $view->assetBundles[Language::className()];
        $this->assertEquals('es', $languageAsset->language);
    }

    public function testWidget()
    {
        $expected = <<<'HTML'
<div id="basic-widget"></div>
HTML;
        $this->assertEquals($expected, Calendar::widget([
            'options' => ['id' => 'basic-widget']
        ]));
        $this->assertEquals(
            'jQuery(\'#basic-widget\').calendar({"language":"en"});',
            end(Yii::$app->view->js[View::POS_READY])
        );

        $expected = <<<'HTML'
<span id="custom-calendar" class="row"></span>
HTML;
        $this->assertEquals($expected, Calendar::widget([
            'options' => [
                'id' => 'custom-calendar',
                'tag' => 'span',
                'class' => 'row'
            ],
            'clientOptions' => [
                'startYear' => 2012,
            ],
        ]));

        $this->assertEquals(
            'jQuery(\'#custom-calendar\')'
                . '.calendar({"startYear":2012,"language":"en"});',
            end(Yii::$app->view->js[View::POS_READY])
        );
    }
}
