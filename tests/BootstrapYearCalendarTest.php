<?php
namespace tecnocen\yearcalendar\tests;

use tecnocen\yearcalendar\widgets\BootstrapYearCalendar as Widget;
use tecnocen\yearcalendar\widgets\DataSourceCalendar as DataWidget;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * Test the functionality for the bootstrap-year-calendar plugin
 */
class BootstrapYearCalendarTest extends TestCase
{
    public function testWidget()
    {
        $expected = <<<'HTML'
<div id="w0"></div>
HTML;
        $this->assertEquals($expected, Widget::widget());
        $this->assertEquals(
            'jQuery(\'#w0\').calendar();',
            array_values(Yii::$app->view->js[View::POS_READY])[0]
        );

        $expected = <<<'HTML'
<span id="w1" class="row"></span>
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
            'jQuery(\'#w1\').calendar({"startYear":2012});',
            array_values(Yii::$app->view->js[View::POS_READY])[1]
        );
    }

    public function testDataWidget()
    {
        $expected = <<<'HTML'
<div id="w2"></div>
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
jQuery('#w2').calendar({"dataSource":[
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
]});
JS;
        $expected = preg_replace('/\n\s*/', '', $expected);
        $this->assertEquals(
            $expected,
            array_values(Yii::$app->view->js[View::POS_READY])[0]
        );
    }
}
