<?php

namespace tecnocen\yearcalendar\data;

use DateTime;
use yii\base\InvalidParamException;
use yii\web\JsExpression;

/**
 * Helper to parse data into
 * [JsExpression](http://www.yiiframework.com/doc-2.0/yii-web-jsexpression.html) * which is what the widgets expect when dealing with dates for the JS plugin.
 *
 * Its main usage is in classes implementing the [[DataItem]] interface
 *
 * ```php
 * public function getStartDate()
 * {
 *     return JsExpressionHelper::parse($this->start_date);
 * }
 * ```
 *
 * @author Angel (Faryshta) Guevara <angeldelcaos@gmail.com>
 */
class JsExpressionHelper
{
    /**
     * Parses a date to a `JsExpression` containing a javascript date object.
     *
     * @param DateTime|string|integer $date
     * @param string $format only used when the ``$date` param is an string
     * @return JsExpression
     */
    public static function parse($date, $format = 'Y-m-d')
    {
        if (is_string($date)) {
            return self::parseString($date, $format);
        }
        if (is_integer($date)) {
            return self::parseTimestamp($date);
        }
        if (is_object($date) && $date instanceof DateTime) {
            return self::parsePhpDate($date);
        }

        throw new InvalidParamException('The parameter `$date` must be a '
            . 'formatted string, a timestamp or a `DateTime` object'
        );
    }

    /**
     * Parses a DateTime object to a `JsExpression` containing a javascript date
     * object.
     *
     * @param DateTime $date
     * @return JsExpression
     */
    public static function parsePhpDate(DateTime $date)
    {
        return new JsExpression('new Date(' . $date->format('Y, m, d') . ')');
    }

    /**
     * Parses an string to a `JsExpression` containing a javascript date object.
     *
     * @param string $date
     * @param string $format used to create a temporal `DateTime` object
     * @return JsExpression
     * @see http://php.net/manual/es/datetime.format.php
     */
    public static function parseString($date, $format = 'Y-m-d')
    {
        return self::parsePhpDate(DateTime::createFromFormat(
            $format,
            $date
        ));
    }

    /**
     * Parses a timestamp integer to a `JsExpression` containing a javascript
     * date object.
     *
     * @param integer $date
     * @return JsExpression
     * @see http://php.net/manual/es/datetime.settimestamp.php
     */
    public static function parseTimestamp($date)
    {
        $PhpDate = new DateTime();
        $PhpDate->setTimestamp($date);
        return self::parsePhpDate($PhpDate);
    }
}
