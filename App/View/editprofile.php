<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 *
 * @var $this \YourOwnFramework\View\View
 * @var $profileData array
 * @var $profile \App\Model\Entity\Profile
 * @var $allProfiles \App\Model\Entity\Profile[]
 */

?>
<h2>Profile</h2>

<div class="row">
    <div class="col-sm-6" id="form_div">
        <?php $this->includeTemplate('form', ['profile' => $profileData]);?>
    </div>
    <div class="col-sm-6">
        <div>
            <h4>Profile Status</h4>
            <?php if($profile->isNotChecked()):?>
                Our trained kittys are not checked yet your profile, please wait
                <img width="250" alt="No!" src="/img/wait.gif" />
            <?php elseif($profile->isValid()):?>
                Your profile is valid, you was a good boy, so please take that kitty:
                <img width="250" alt="Kitty" src="http://www.randomkittengenerator.com/cats/rotator.php" />
            <?php else:?>
                Your profile is invalid: <br />
                <img width="250" alt="No!" src="/img/no.gif" />
            <?php endif;?>
        </div>
    <div id="versions"></div>
    </div>
</div>