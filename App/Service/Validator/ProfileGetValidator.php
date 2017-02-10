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
     * @return bool
     */
    public function validate(array $params)
    {
        //TODO implement validation
        return true;
    }

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