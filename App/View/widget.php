<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */
$activeProfilesJson = json_encode($activeProfiles);

echo <<<JS
var activeProfiles = $activeProfiles;

JS;
