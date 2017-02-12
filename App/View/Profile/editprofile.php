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

<script type="text/javascript">
    var originalId = <?php echo $profile->getId(); ?>;

    setInterval(function(){update();}, 5000);

    function update()
    {
        $.get( "/profile/json/", function( data ) {
            if (data.id != originalId) {
                console.log("income: " + data.id + " | originalID : " + originalId);
                if (confirm("Somebody was change that profile, reload the page?")) {
                    window.location = window.location.href;
                }
            }
        }, "json");
    }
</script>