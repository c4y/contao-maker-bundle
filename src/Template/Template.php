<?php

namespace App\Template;

use App\Utils\StringUtil;

/**
 * Class Template
 * @package DevCoder
 */
class Template
{
    /**
     * @var string
     */
    private $tpl = '';

    private $options = [];

    /**
     * Template constructor.
     * @param string $path
     * @param array $parameters
     */
    public function __construct($tpl)
    {
        $this->tpl = __DIR__ . '/../../skeleton/' . $tpl;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->options[$key];
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function setOptions(array $options) {
        $this->options = $options;
    }


    /**
     * @param string $view
     * @param array $context
     * @return string
     * @throws \Exception
     */
    public function render(): string
    {
        if (!file_exists($this->tpl)) {
            throw new \Exception(sprintf('The file %s could not be found.', $this->tpl));
        }

        ob_start();

        include($this->tpl);

        return ob_get_clean();
    }

    /**
     * @param string $view
     * @param array $context
     * @return string
     * @throws \Exception
     */
    public function saveTo($dest)
    {
        // add append if file exists
        $this->options['fileExists'] = false;

        if (file_exists($dest)) {
            $this->options['fileExists'] = true;
        }

        $flags = null;
        if ($this->options['fileExists']) {
            $flags = FILE_APPEND;
        }

        $dest = str_replace('##NAME##', $this->options['name'], $dest);
        $dest = str_replace('##SCNAME##', $this->options['scname'], $dest);

        echo $dest . " created\n";
        file_put_contents($dest, $this->render(), $flags);
    }
}
