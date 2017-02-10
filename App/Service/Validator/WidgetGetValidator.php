<?php

namespace App\Service\Validator;

use ServiceExecutor\ValidatorInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class WidgetGetValidator implements ValidatorInterface
{
    const CONTAINER_KEY = "service.validator.widget.edit";

    /**
     * @param $params array
     *
     * @return bool
     */
    public function validateParams(array $params)
    {
        //TODO implement validation
        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return "Oops something went wrong!";
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return [];
    }
}