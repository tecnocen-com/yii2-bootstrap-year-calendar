<?php
namespace tecnocen\yearcalendar\tests;

use tecnocen\yearcalendar\data\JsExpressionHelper;
use yii\web\JsExpression;

/**
 * Test the functionality for the bootstrap-year-calendar plugin
 */
class JsExpressionHelperTest extends TestCase
{
    protected function assertJsExpression($expected, JsExpression $expression)
    {
        $this->assertEquals($expected, $expression->expression);
    }

    public function testParseString()
    {
        $this->assertJsExpression(
            'new Date(2016, 01, 01)',
            JsExpressionHelper::parse('2016-01-01')
        );

        $this->assertJsExpression(
            'new Date(2016, 02, 01)',
            JsExpressionHelper::parse('2016-01-02', 'Y-d-m')
        );
    }

    public function testParseTimestamp()
    {
        $this->assertJsExpression(
            'new Date(1970, 01, 01)',
            JsExpressionHelper::parse(0)
        );

        $this->assertJsExpression(
            'new Date(2014, 05, 13)',
            JsExpressionHelper::parse(1400000000)
        );
    }
}
