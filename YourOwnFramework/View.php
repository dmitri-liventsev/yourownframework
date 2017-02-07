<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework;

class View
{
    const CONTAINER_VIEW = 'view';

    /**
     * @var string
     */
    private $templatePath;

    /** @var string */
    private $layoutPath;

    public function render(array $params)
    {
        extract(['content' => $this->renderPhpFile($this->templatePath, $params)], EXTR_OVERWRITE);
        require($this->layoutPath);
    }

    public function renderPhpFile($_file_, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($_file_);

        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @param string $layoutPath
     */
    public function setLayoutPath($layoutPath)
    {
        $this->layoutPath = $layoutPath;
    }
}
