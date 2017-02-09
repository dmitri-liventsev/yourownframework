<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * @var $this \YourOwnFramework\View\View
 * @var $profile array
 * @var $allProfiles \App\Model\Entity\Profile[]
 */

?>
<h2>Profile</h2>

<div class="row">
  <div class="col-sm-6" id="form_div">
      <?php $this->includeTemplate('form', ['profile' => $profile]);?>
  </div>
  <div class="col-sm-6">
    <div id="versions"></div>
  </div>
</div>

<script type="text/javascript">
    $("versions").profileVersions({
        versions: <?php echo json_encode($allProfiles)?>,
        form_div: $('#form_div')
    });
</script>