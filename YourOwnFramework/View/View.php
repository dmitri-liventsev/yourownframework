<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace YourOwnFramework\View;

use Delight\Auth\Auth;

class View
{
    const CONTAINER_KEY = 'view';

    /**
     * @var FormHelper
     */
    protected $form;

    /**
     * View constructor.
     * @param FormHelper $formHelper
     * @param string $layoutDirectory
     * @param string $templateDirectory
     */
    public function __construct(FormHelper $formHelper, string $layoutDirectory, string $templateDirectory)
    {
        $this->form = $formHelper;
        $this->layoutDirectory = $layoutDirectory;
        $this->templateDirectory = $templateDirectory;
    }

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var string
     */
    private $layoutDirectory;

    /**
     * @var string
     */
    private $templateDirectory;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param array $params
     */
    public function render(array $params)
    {
        extract(['content' => $this->renderPhpFile($this->getFullTemplatePath($this->template), $params)], EXTR_OVERWRITE);
        require($this->getFullLayoutPath($this->layout));
    }

    /**
     * @param string $templateName
     * @param array $params
     */
    public function includeTemplate(string $templateName, array $params)
    {
        extract($params, EXTR_OVERWRITE);
        require($this->getFullTemplatePath($templateName));
    }

    /**
     * @param $_file_
     * @param array $params
     * @return string
     */
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
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param Auth $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param string $template
     * @return string
     */
    public function getFullTemplatePath(string $template) : string
    {
        return ROOT . $this->templateDirectory . $template . '.php';
    }

    /**
     * @param string $layout
     *
     * @return string
     */
    public function getFullLayoutPath(string $layout) : string
    {
        return ROOT . $this->layoutDirectory . $layout . '.php';
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }


}
