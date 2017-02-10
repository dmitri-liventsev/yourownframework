<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 *
 * @var array $profileDetails
 * @var array $profileVersions
 * @var Profile $profile
 */
use App\Model\Entity\Profile;

?>

<div class="row">
    <div class="col-sm-6" id="form_div">
        <?php $this->includeTemplate('Profile/table', ['profileDetails' => $profileDetails, 'profileVersions' => $profileVersions]);?>
    </div>
    <div class="col-sm-6">
        <?php $this->includeTemplate('Profile/status', ['profile' => $profile]);?>
    </div>
</div>