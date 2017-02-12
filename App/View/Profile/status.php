<?php
use App\Model\Entity\Profile;
/** @var $profile Profile */
?>

<div>
    <h4>Profile Status</h4>
    <?php if($profile->isNotChecked()):?>
        Our trained kittys are not checked yet your profile, please wait
        <img width="250" alt="No!" src="/img/wait.gif" />
    <?php elseif($profile->isValid()):?>
        Profile is valid, you was a good boy, so please take that kitty:
        <img width="250" alt="Kitty" src="http://www.randomkittengenerator.com/cats/rotator.php" />
    <?php else:?>
        Profile is invalid: <br />
        <img width="250" alt="No!" src="/img/no.gif" />
    <?php endif;?>
</div>
<div id="versions"></div>
