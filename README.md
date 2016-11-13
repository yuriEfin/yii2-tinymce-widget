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
Create file config TinyMce in app/config/TinyMce/config.php
```php
mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Moscow');

/*
  |--------------------------------------------------------------------------
  | Optional security
  |--------------------------------------------------------------------------
  |
  | if set to true only those will access RF whose url contains the access key(akey) like:
  | <input type="button" href="../filemanager/dialog.php?field_id=imgField&lang=en_EN&akey=myPrivateKey" value="Files">
  | in tinymce a new parameter added: filemanager_access_key:"myPrivateKey"
  | example tinymce config:
  |
  | tiny init ...
  | external_filemanager_path:"../filemanager/",
  | filemanager_title:"Filemanager" ,
  | filemanager_access_key:"myPrivateKey" ,
  | ...
  |
 */

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
    'upload_dir' => '{upload_dir}',// <-- This
    /*
      |--------------------------------------------------------------------------
      | relative path from filemanager folder to upload folder
      |--------------------------------------------------------------------------
      |
      | with final /
      |
     */
    'current_path' => '{current_path}',// <-- This
    /*
      |--------------------------------------------------------------------------
      | relative path from filemanager folder to thumbs folder
      |--------------------------------------------------------------------------
      |
      | with final /
      | DO NOT put inside upload folder
      |
     */
    'thumbs_base_path' => '{thumbs_base_path}',// <-- This
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
            "a[*],abbr[*],acronym[*],address[*],applet[*],area[*],article[*],aside[*],audio[*],b[*],base[*],basefont[*],bdi[*],bdo[*],
bgsound[*],big[*],blink[*],blockquote[*],body[*],br[*],button[*],canvas[*],caption[*],center[*],cite[*],code[*],col[*],
colgroup[*],command[*],comment[*],datalist[*],dd[*],del[*],details[*],dfn[*],dir[*],div[*],dl[*],dt[*],em[*],embed[*],
fieldset[*],figcaption[*],figure[*],font[*],footer[*],form[*],frame[*],frameset[*],h1[*],h2[*],h3[*],h4[*],h5[*],h6[*],
head[*],header[*],hgroup[*],hr[*],html[*],i[*],iframe[*],img[*],input[*],ins[*],isindex[*],kbd[*],keygen[*],label[*],
legend[*],li[*],link[*],listing[*],map[*],mark[*],marquee[*],menu[*],meta[*],meter[*],multicol[*],nav[*],nobr[*],
noembed[*],noframes[*],noscript[*],object[*],ol[*],optgroup[*],option[*],output[*],p[*],param[*],plaintext[*],pre[*],
progress[*],q[*],rp[*],rt[*],ruby[*],s[*],samp[*],script[*],section[*],select[*],small[*],source[*],spacer[*],span[*],
strike[*],strong[*],style[*],sub[*],summary[*],sup[*],table[*],tbody[*],td[*],textarea[*],tfoot[*],th[*],thead[*],time[*],
title[*],tr[*],track[*],tt[*],u[*],ul[*],var[*],video[*],wbr[*],xmp[*]",
            'block_formats' => 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3',
            'font_formats' => 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
            'fontsize_formats' => '8pt 10pt 12pt 14pt 18pt 24pt 36pt 72pt',
            'disk_cache' => true,
            'plugins' => [
                "glvrd",
                "emoticons",
                "code",
                "lists",
                "anchor",
                "fullpage",
                "fullscreen",
                "autosave",
                "wordcount",
                "textcolor colorpicker",
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code",
                "save autosave template responsivefilemanager filemanager",
            ],
            'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            "theme_advanced_buttons2" => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,preCode,anchor,image,uploads_image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
            'theme_advanced_toolbar_location' => "top",
            'theme_advanced_toolbar_align' => "left",
            'theme_advanced_statusbar_location' => "bottom",
            'theme_advanced_resizing' => true,
            'isFirstLaunch' => false,
            'force_p_newlines' => false,
            'force_br_newlines' => false,
            'convert_newlines_to_p' => false,
            'convert_newlines_to_brs' => false,
            'autosave_ask_before_unload' => false,
            'autosave_retention' => '3s',
            'advlist_bullet_styles' => 'square circle disc',
            'autosave_interval' => "20s",
            'wordcount_cleanregex' => '/[0-9.(),;:!?%#$?\x27\x22_+=\\/\-]*/g',
            'image_advtab' => true,
            'menubar' => "file | view | tools | insert",
            'toolbar' => "glvrd | fullpage | fullscreen | fontsizeselect | emoticons | code | anchor | undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media",
            'external_filemanager_path' => '/js/fm/filemanager/',
            'filemanager_title' => 'Filemanager',
            'external_plugins' => [
                'glvrd' => '/js/plugins/glvrd_wp/js/glvrd-plugin.js',
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
