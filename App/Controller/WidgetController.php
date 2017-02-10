<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

namespace App\Controller;

use App\Service\WidgetGet;
use YourOwnFramework\Controller;
use YourOwnFramework\Request;

class WidgetController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $this->header("Content-Type", "text/javascript");

        $this->layout = 'widget';
        $this->template = 'widget';

        /** @var WidgetGet $service */
        $service = $this->get(\App\Service\WidgetGet::CONTAINER_KEY_EXECUTOR);

        return $service->execute([]);
    }
}