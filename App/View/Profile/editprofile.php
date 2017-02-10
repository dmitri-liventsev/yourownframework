<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 *
 * @var $this \YourOwnFramework\View\View
 * @var $profileData array
 * @var $profile \App\Model\Entity\Profile
 * @var $allProfiles \App\Model\Entity\Profile[]
 * @var $token string
 */

?>
<h2>Profile</h2>

<div class="row">
    <div class="col-sm-6" id="form_div">
        <?php $this->includeTemplate('Profile/form', ['profile' => $profileData]);?>
    </div>
    <div class="col-sm-6">
        <?php $this->includeTemplate('Profile/status', ['profile' => $profile]);?>
    </div>
</div>