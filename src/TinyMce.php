<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\tinymce;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use dosamigos\tinymce\Creator;

/**
 *
 * TinyMCE renders a tinyMCE js plugin for WYSIWYG editing.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
class TinyMce extends InputWidget
{

    /**
     * @var string the language to use. Defaults to null (en).
     */
    public $language;

    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see http://www.tinymce.com/wiki.php/Configuration
     */
    public $clientOptions = [];

    /**
     * @var bool whether to set the on change event for the editor. This is required to be able to validate data.
     * @see https://github.com/2amigos/yii2-tinymce-widget/issues/7
     */
    public $triggerSaveOnBeforeValidateForm = true;

    /**
     * Конфигурация TinyMce
     * @var array 
     */
    public $config = [];

    /**
     * custom config path
     * alias @fm-custom-config - config your application
     */
    public $customConfigPath = '@fm-custom-config';
    public $fileCustomConfigName = 'config.php';

    /**
     * оригинал конфига
     * @var stiring 
     */
    public $pathOriginalConfig = '';

    /**
     * Орининальное название файла конфига
     * @var string
     */
    public $fileOriginalConfigName = 'config.php';

    /**
     * Полный путь к оригинальному файлу
     * @var string 
     */
    public $fullConfigPath;

    /**
     * @var dosamigos\tinymce\Creator 
     */
    public $creatorConfig;

    /**
     * is object $creatorConfig - use this methodCreatorConfig else use this to class method createConfig
     * @var type 
     */
    public $methodCreatorConfig = 'merge';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->setPaths();
        if (!$this->creatorConfig) {
            $this->creatorConfig = new Creator($this->fullConfigPath, $this->customConfigPath, $this->config);
            // create
            $this->createConfig();
        } else {
            if (is_string($this->creatorConfig)) {
                $class = new $this->creatorConfig;
                $this->creatorConfig = new $class($this->fullConfigPath, $this->customConfigPath, $this->config);
                // create
                $this->createConfig();
            } elseif (is_object($this->creatorConfig)) {
                $methodCreatorConfig = $this->methodCreatorConfig;
                if (is_string($methodCreatorConfig)) {
                    $this->creatorConfig->$methodCreatorConfig();
                }
            } elseif (is_callable($this->methodCreatorConfig)) {
                call_user_func($this->methodCreatorConfig);
            }
        }

        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->registerClientScript();
    }

    public function setPaths()
    {
        $this->customConfigPath = Yii::getAlias($this->customConfigPath) . '/' . $this->fileCustomConfigName;
        $this->pathOriginalConfig = Yii::getAlias('@fm-path-original-config');
        $this->fullConfigPath = $this->pathOriginalConfig . '/' . $this->fileOriginalConfigName;
        if (!file_exists($this->fullConfigPath)) {
            throw new Exception('Не верный путь к файлу конфигурации расширения ' . __CLASS__);
        }
        require $this->fullConfigPath;
    }

    public function createConfig()
    {
        if (!empty($this->config)) {
            $this->creatorConfig->merge();
        }
    }

    /**
     * Registers tinyMCE js plugin
     */
    protected function registerClientScript()
    {
        $js = [];
        $view = $this->getView();

        TinyMceAsset::register($view);

        $id = $this->options['id'];

        $this->clientOptions['selector'] = "#$id";
        // @codeCoverageIgnoreStart
        if ($this->language !== null) {
            $langFile = "langs/{$this->language}.js";
            $langAssetBundle = TinyMceLangAsset::register($view);
            $langAssetBundle->js[] = $langFile;
            $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
        }
        // @codeCoverageIgnoreEnd

        $options = Json::encode($this->clientOptions);

        $js[] = "tinymce.init($options);";
        if ($this->triggerSaveOnBeforeValidateForm) {
            $js[] = "$('#{$id}').parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });";
        }
        $view->registerJs(implode("\n", $js));
    }
}
