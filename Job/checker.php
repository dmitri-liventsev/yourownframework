<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 */

use App\Model\Entity\Profile;
use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;
use DI\Container;
use DI\ContainerBuilder;

define("ROOT", dirname(__DIR__));

require(ROOT . '/autoload.php');
require(ROOT . '/vendor/autoload.php');

$config = require(ROOT . '/Config/main.php');
$config = $config[\YourOwnFramework\YourOwnFramework::CONTAINER_CONTAINER_KEY];

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
/** @var WidgetRepository $widgetRepository */
$widgetRepository = $container->get(WidgetRepository::CONTAINER_KEY);

/** @var PDO $db */
$db = $container->get('db');
$newProfiles = $profileRepository->findAllNotChecked();
/** @var Profile $profile */
foreach ($newProfiles as $profile) {
    $status = $profile->checkDetails() ? Profile::STATUS_VALID : Profile::STATUS_INVALID;
    $profile->setStatus($status);

    $widget = $widgetRepository->findByUserId($profile->getUserId());
    $widget->setLastStatus($status);

    try {
        $db->beginTransaction();

        $profile->save();
        $widget->save();

        $db->commit();
    } catch (\YourOwnFramework\Exception\ErzatsORMException $e) {
        $db->rollBack();
        throw $e;
    }

}
