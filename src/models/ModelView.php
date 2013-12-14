<?php
namespace App\Model;

class ModelView
{
    private $_layoutDir;
    private $_templateDir;
    private $_layout;
    private $_template;
    private $_params;

    public function __construct($layoutDir, $templateDir, $layout, $template, $params)
    {
        $this->_layoutDir = $layoutDir;
        $this->_templateDir = $templateDir;
        $this->_layout = $layout;
        $this->_template = $template;
        $this->_params = $params;
    }

    public function render()
    {
        require_once $this->_layoutDir . $this->_layout . '.phtml';
    }

    public function renderTemplate()
    {
        require_once $this->_templateDir . $this->_template . '.phtml';
    }

    public function get($param)
    {
        return $this->_params[$param];
    }
}
