<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

use App\Model\Entity\Profile;
use App\Model\Repository\ProfileRepository;
use DI\Container;
use DI\ContainerBuilder;

define("ROOT",dirname($_SERVER["DOCUMENT_ROOT"]));
require(ROOT . '/autoload.php');
require(ROOT . '/vendor/autoload.php');

$config = require(ROOT . '/Config/main.php')[\YourOwnFramework\YourOwnFramework::CONTAINER_CONTAINER_KEY];
$container = initializeContainer($config);

function initializeContainer($config) : Container
{
    $builder = new ContainerBuilder();
    $builder->addDefinitions($config);

    return $builder->build();
}

//Take not checked profiles
/** @var ProfileRepository $profileRepository */
$profileRepository = $container->get(ProfileRepository::CONTAINER_KEY);
$newProfiles = $profileRepository->findAllNotChecked();

/** @var Profile $profile */
foreach ($newProfiles as $profile) {
    $status = $profile->checkDetails() ? Profile::STATUS_VALID : Profile::STATUS_INVALID;
    $profile->setStatus($status);
    $profile->save();
}
