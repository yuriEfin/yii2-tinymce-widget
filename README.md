# TinyMCE Widget for Yii2


> [![Latest Version](https://img.shields.io/github/tag/2amigos/yii2-tinymce-widget.svg?style=flat-square&label=release)](https://github.com/2amigos/yii2-tinymce-widget/tags)
> [![Software License](https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square)](LICENSE.md)
> [![Build Status](https://img.shields.io/travis/2amigos/yii2-tinymce-widget/master.svg?style=flat-square)](https://travis-ci.org/2amigos/yii2-tinymce-widget)
> [![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/2amigos/yii2-tinymce-widget.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-tinymce-widget/code-structure)
> [![Quality Score](https://img.shields.io/scrutinizer/g/2amigos/yii2-tinymce-widget.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-tinymce-widget)
> [![Total Downloads](https://img.shields.io/packagist/dt/2amigos/yii2-tinymce-widget.svg?style=flat-square)](https://packagist.org/packages/2amigos/yii2-tinymce-widget)

Renders a [TinyMCE WYSIWYG text editor plugin](http://www.tinymce.com/) widget.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
> composer require 2amigos/yii2-tinymce-widget:~1.1

```
or add

```json
> "2amigos/yii2-tinymce-widget" : "~1.1"
```

Change file composer.lock 

```json
            "name": "2amigos/yii2-tinymce-widget",
            "version": "1.1.1",
            "source": {
                "type": "git",
                "url": "https://github.com/yuriEfin/yii2-tinymce-widget.git", // <--- 
                "reference": "d58bad3ede450f86acd475fb4ecda982b980132b"
            },

```
```php 
composer install --prefer-source // Installation of the repository of the composer.loc
```



to the require section of your application's `composer.json` file.

## Usage
Copy file config TinyMce  => app/config/TinyMce/config.php
```json
... 

define('USE_ACCESS_KEYS', false); // TRUE or FALSE

/*
  |--------------------------------------------------------------------------
  | DON'T COPY THIS VARIABLES IN FOLDERS config.php FILES
  |--------------------------------------------------------------------------
 */

define('DEBUG_ERROR_MESSAGE', true); // TRUE or FALSE

/*
  |--------------------------------------------------------------------------
  | Path configuration
  |--------------------------------------------------------------------------
  | In this configuration the folder tree is
  | root
  |    |- source <- upload folder
  |    |- thumbs <- thumbnail folder [must have write permission (755)]
  |    |- filemanager
  |    |- js
  |    |   |- tinymce
  |    |   |   |- plugins
  |    |   |   |   |- responsivefilemanager
  |    |   |   |   |   |- plugin.min.js
 */
$config = array(
    /*
      |--------------------------------------------------------------------------
      | DON'T TOUCH (base url (only domain) of site).
      |--------------------------------------------------------------------------
      |
      | without final / (DON'T TOUCH)
      |
     */
    'base_url' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'],
    /*
      |--------------------------------------------------------------------------
      | path from base_url to base of upload folder
      |--------------------------------------------------------------------------
      |
      | with start and final /
      |
     */
    'upload_dir' => '{upload_dir}',// <--  This {key config}
    /*
      |--------------------------------------------------------------------------
      | relative path from filemanager folder to upload folder
      |--------------------------------------------------------------------------
      |
      | with final /
      |
     */
    'current_path' => '{current_path}',// <--  This {key config}
    /*
      |--------------------------------------------------------------------------
      | relative path from filemanager folder to thumbs folder
      |--------------------------------------------------------------------------
      |
      | with final /
      | DO NOT put inside upload folder
      |
     */
    'thumbs_base_path' => '{thumbs_base_path}',// <-- This {key config}
    /*
      |--------------------------------------------------------------------------
      | Access keys
      |--------------------------------------------------------------------------
      |
      | add access keys eg: array('myPrivateKey', 'someoneElseKey');
   ....
);
...

```
```php

    /**
     * Конфигурация TinyMce
     * @Example  [
     *              '{current_path}'=>'path/to/current_path',
     *              '{thumbs_base_path}'=>'path/to/thumbs_base_path',
     *              '{upload_dir}' =>'path/to/upload_dir',   
     *           ]
     * @var array 
     */
    public $config = []; 

    /**
     * custom config path
     * alias @fm-custom-config - config your application
     */
    public $customConfigPath = '@fm-custom-config';  // Custom (alias) (application configuration '@fm-custom-config'=>'path/to/custom-path-Tinymce-config/')
    /**
     * наименование вашего файла конфигурации
     */
    public $fileCustomConfigName = 'config.php';  // Custom filename (custom-path-Tinymce-config.php)

    /**
     * оригинал конфига
     * @var stiring 
     */
    public $pathOriginalConfig = ''; // path/to/original-path-Tinymce-config/

    /**
     * Орининальное название файла конфига
     * @var string
     */
    public $fileOriginalConfigName = 'config.php'; // original-filename-Tinymce-config.php

    /**
     * Полный путь к оригинальному файлу
     * @var string 
     */
    public $fullConfigPath; // full-path/to/original-path-Tinymce-config/

    /**
     * @var dosamigos\tinymce\Creator 
     */
    public $creatorConfig; // Change your creator 

```
Creator config 
```php
            if (!$this->creatorConfig) {
                $this->creatorConfig = new Creator($this->fullConfigPath, $this->customConfigPath, $this->config);
                // create
                $this->createConfig();
            } else {
                if (is_string($this->creatorConfig)) {
                    $class = $this->creatorConfig;
                    $this->creatorConfig = new $class($this->fullConfigPath, $this->customConfigPath, $this->config);
                    // create
                    $this->createConfig();
                } elseif (is_object($this->creatorConfig)) {
                    $methodCreatorConfig = $this->methodCreatorConfig;
                    if (is_string($methodCreatorConfig)) {
                        $this->creatorConfig->$methodCreatorConfig();
                    } elseif (is_callable($this->methodCreatorConfig)) {
                        call_user_func($this->methodCreatorConfig);
                    }
                }
            }
```


```php
// set configuration application `aliases`
'aliases' => [
        '@fm' => dirname(__DIR__) . '/web/js/fm/',
        '@fm-custom-config' => __DIR__ . '/tinyMce/',
        '@fm-upload-base-path' => dirname(__DIR__) . '/web/js/fm/source/',
        '@fm-upload-current-path' => dirname(__DIR__) . '/web/js/fm/source/',
        '@fm-upload-thumbs-base-path' => dirname(__DIR__) . '/web/js/fm/source/thumbs',
        '@fm-path-original-config' => dirname(__DIR__) . '/web/js/fm/filemanager/config',
    ],

```
Usage widget: 
```php
use dosamigos\tinymce\TinyMce;

<?= $form->field($model, 'text')->widget(\dosamigos\tinymce\TinyMce::className(), [
        'options' => ['rows' => 25],
        'language' => 'ru',
        'triggerSaveOnBeforeValidateForm' => true,
        'config' => [ // change default configuration 
            '{upload_dir}' => Yii::getAlias('@fm-upload-base-path'),
            '{current_path}' => Yii::getAlias('@fm-upload-current-path'),
            '{thumbs_base_path}' => Yii::getAlias('@fm-upload-thumbs-base-path'),
        ],
        'clientOptions' => [
            'br_in_pre' => false,
            'images_upload_url' => Url::to([Yii::$app->controller->id . '/fm-upload']),
            'images_reuse_filename' => true,
            'images_upload_base_path' => Yii::getAlias('@fm-upload-base-path'),
            'automatic_uploads' => true,
            'extended_valid_elements' =>
            "a[*],abbr[*],acronym[*],address[*],applet[*],area[*],article[*],aside[*],audio[*],b[*],base[*],basefont[*],bdi[*],bdo[*]
            'block_formats' => 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3',
            'font_formats' => 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
            'fontsize_formats' => '8pt 10pt 12pt 14pt 18pt 24pt 36pt 72pt',
            'disk_cache' => true,
            'plugins' => [
                "emoticons",
                "code",
                "lists",
            ],
            'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            'menubar' => "file | view | tools | insert",
            'external_filemanager_path' => '/js/fm/filemanager/',
            'filemanager_title' => 'Filemanager',
            'external_plugins' => [
                // Кнопка загрузки файла в диалоге вставки изображения.
                'filemanager' => '/js/fm/tinymce/plugins/responsivefilemanager/plugin.min.js',
                // Кнопка загрузки файла в тулбаре.
                'responsivefilemanager' => '/js/fm/tinymce/plugins/responsivefilemanager/plugin.min.js',
            ],
            'hidden_input' => false,
            'elementpath' => false,
        ]
    ]);?>
```
```php
> <?= $form->field($model, 'text')->widget(TinyMce::className(), [
>    'options' => ['rows' => 6],
>    'language' => 'es',
>    'clientOptions' => [
>        'plugins' => [
>            "advlist autolink lists link charmap print preview anchor",
>            "searchreplace visualblocks code fullscreen",
>            "insertdatetime media table contextmenu paste"
>        ],
>        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
>    ]
>]);?>

```

## Testing

``` bash
$ phpunit
```

## Further Information

Please, check the [TinyMCE plugin site](http://www.tinymce.com/wiki.php/Configuration) documentation for further 
information about its configuration options.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Antonio Ramirez](https://github.com/tonydspaniard)
- [All Contributors](../../contributors)

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)  
<i>Web development has never been so fun!</i>  
[www.2amigos.us](http://www.2amigos.us)
