<?php

namespace App\Service\Validator;

use ServiceExecutor\ValidatorInterface;


/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileGetValidator implements ValidatorInterface
{
    const CONTAINER_KEY = "service.validator.profile.get";

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