<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace App\Service;


use App\Model\Repository\ProfileRepository;
use App\Model\Repository\WidgetRepository;

abstract class BaseService
{
    /**
     * @var WidgetRepository
     */
    protected $widgetRepository;

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    /**
     * @var \PDO
     */
    protected $db;

    /**
     * @param WidgetRepository $widgetRepository
     */
    public function setWidgetRepository(WidgetRepository $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param ProfileRepository $profileRepository
     */
    public function setProfileRepository(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param \PDO $db
     */
    public function setDb(\PDO $db)
    {
        $this->db = $db;
    }
}