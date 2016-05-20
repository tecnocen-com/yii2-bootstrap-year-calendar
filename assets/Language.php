<?php
namespace tecnocen\yearcalendar\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Angel Guevara <angeldelcaos@gmail.com>
 */
class Language extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/bootstrap-year-calendar/js/languages/';
    /**
     * @var boolean whether to automatically generate the needed language js files.
     * If this is true, the language js files will be determined based on the actual usage of [[DatePicker]]
     * and its language settings. If this is false, you should explicitly specify the language js files via [[js]].
     */
    public $autoGenerate = true;

    /**
     * @var string language to register translation file for
     */
    public $language;

    /**
     * @inheritdoc
     */

    public $depends = ['tecnocen\yearcalendar\assets\Calendar'];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        if ($this->autoGenerate && $this->language != 'en') {
            $language = $this->language;
            if (!file_exists(Yii::getAlias(
                $this->sourcePath . "/bootstrap-year-calendar.{$language}.js"
            ))) {
                return parent::registerAssetFiles($view);
            }
            $this->js[] = "bootstrap-year-calendar.$language.js";
        }
        parent::registerAssetFiles($view);
    }
}
