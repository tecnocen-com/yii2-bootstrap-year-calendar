<?php
namespace tecnocen\yearcalendar\tests;

use tecnocen\yearcalendar\widgets\BootstrapYearCalendar as Widget;
use tecnocen\yearcalendar\widgets\DataSourceCalendar as DataWidget;
use tecnocen\yearcalendar\assets\BootstrapYearCalendarLanguage as LangAsset;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * Test the functionality for the bootstrap-year-calendar plugin
 */
class BootstrapYearCalendarTest extends TestCase
{

    public function testLanguage()
    {
        $view = Yii::$app->view;
        $expected = <<<'HTML'
<div id="w0"></div>
HTML;

        $this->assertEquals($expected, Widget::widget(['language' => 'es']));

        $this->assertEquals(
            'jQuery(\'#w0\').calendar({"language":"es"});',
            end($view->js[View::POS_READY])
        );

        $this->assertTrue(isset($view->assetBundles[LangAsset::className()]));
        $languageAsset  = $view->assetBundles[LangAsset::className()];
        $this->assertEquals('es', $languageAsset->language);
    }

    public function testWidget()
    {
        $expected = <<<'HTML'
<div id="w1"></div>
HTML;
        $this->assertEquals($expected, Widget::widget());
        $this->assertEquals(
            'jQuery(\'#w1\').calendar({"language":"en"});',
            end(Yii::$app->view->js[View::POS_READY])
        );

        $expected = <<<'HTML'
<span id="w2" class="row"></span>
HTML;
        $this->assertEquals($expected, Widget::widget([
            'options' => [
                'tag' => 'span',
                'class' => 'row'
            ],
            'clientOptions' => [
                'startYear' => 2012,
            ],
        ]));

        $this->assertEquals(
            'jQuery(\'#w2\').calendar({"startYear":2012,"language":"en"});',
            end(Yii::$app->view->js[View::POS_READY])
        );
    }

    public function testDataWidget()
    {
        $expected = <<<'HTML'
<div id="w3"></div>
HTML;

        $this->assertEquals($expected, DataWidget::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => [
                    new data\DataSourceItem([
                        'name' => 'Conference',
                        'startDate' => '2016-01-01',
                        'endDate' => '2016-02-03',
                    ]),
                    new data\DataSourceItem([
                        'name' => 'Random',
                        'startDate' => '2016-03-01',
                        'endDate' => '2016-03-03',
                    ]),
                ],
            ]),
        ]));
        $expected = <<<'JS'
jQuery('#w3').calendar({"dataSource":[
    {
        "name":"Conference",
        "startDate":new Date('2016-01-01'),
        "endDate":new Date('2016-02-03')
    },
    {
        "name":"Random",
        "startDate":new Date('2016-03-01'),
        "endDate":new Date('2016-03-03')
    }
],"language":"en"});
JS;
        $expected = preg_replace('/\n\s*/', '', $expected);
        $this->assertEquals(
            $expected,
            end(Yii::$app->view->js[View::POS_READY])
        );
    }
}
