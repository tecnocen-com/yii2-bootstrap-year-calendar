<?php
namespace tecnocen\yearcalendar\tests;

use tecnocen\yearcalendar\widgets\ActiveCalendar;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * Test the functionality for the bootstrap-year-calendar plugin active widget.
 */
class ActiveCalendarTest extends TestCase
{
    public function testDataWidget()
    {
        $expected = <<<'HTML'
<div id="active-calendar"></div>
HTML;

        $this->assertEquals($expected, ActiveCalendar::widget([
            'options' => ['id' => 'active-calendar'],
            'dataProvider' => new ArrayDataProvider([
                'allModels' => [
                    new data\DataItem([
                        'name' => 'Conference',
                        'startDate' => '2016-01-01',
                        'endDate' => '2016-02-03',
                    ]),
                    new data\DataItem([
                        'name' => 'Random',
                        'startDate' => '2016-03-01',
                        'endDate' => '2016-03-03',
                    ]),
                ],
            ]),
        ]));
        $expected = <<<'JS'
jQuery('#active-calendar').calendar({"dataSource":[
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
