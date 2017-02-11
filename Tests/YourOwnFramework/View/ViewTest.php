<?php

namespace Test\YourOwnFramework\View;
use PHPUnit\Framework\TestCase;
use YourOwnFramework\View\FormHelper;
use YourOwnFramework\View\View;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class ViewTest extends TestCase
{
    public function testGetFullTemplatePath()
    {
        $formHelper = new FormHelper();
        $view = new View($formHelper, 'trololo', 'ololo\\');

        $this->assertNotFalse(strpos($view->getFullTemplatePath('trololo'), 'ololo\trololo.php'));
    }

    public function getFullLayoutPath()
    {
        $formHelper = new FormHelper();
        $view = new View($formHelper, 'trololo\\', 'ololo\\');

        $this->assertNotFalse(strpos($view->getFullLayoutPath('trololo'), 'trololo\trololo.php'));
    }
}
