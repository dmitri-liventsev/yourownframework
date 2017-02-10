<?php

namespace App\Service\Validator;

use ServiceExecutor\ValidatorInterface;

/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
class ProfileEditValidator implements ValidatorInterface
{
    const CONTAINER_KEY = "service.validator.profile.edit";

    /**
     * @return bool
     */
    public function validate(array $params)
    {
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