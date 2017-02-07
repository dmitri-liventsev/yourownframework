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

    public function render(array $params)
    {
        extract($params, EXTR_OVERWRITE);
        require($this->templatePath);
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
}
