<?php

namespace dosamigos\tinymce;

/**
 * Description of Creator
 *
 * @author gambit
 */
class Creator
{

    public $vendor = null;
    public $fileConfigLib,
        $newConfig,
        $datas = [];
    public $configuration;

    public function __construct($fileConfigLib, $newConfig, $datas)
    {
        $this->fileConfigLib = $fileConfigLib;
        $this->newConfig = $newConfig;
        $this->datas = $datas;
    }

    public function merge()
    {
        $this->configuration = strtr(file_get_contents($this->newConfig), $this->datas);
        file_put_contents($this->fileConfigLib, $this->configuration);
    }
}
