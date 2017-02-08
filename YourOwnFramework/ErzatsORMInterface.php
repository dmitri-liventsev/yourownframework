<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework;


interface ErzatsORMInterface
{
    public function load(array $params = []);

    public function save();
}