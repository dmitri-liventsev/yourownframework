<?php
/**
 * @var $this YourOwnFramework\View
 * @var $profile \App\Model\Entity\Profile
  */
?>

<form method="post">
    <?php echo $this->form->text('text1', 'text1', $profile->getText1())?>
    <?php echo $this->form->text('text2', 'text2', $profile->getText2())?>
    <?php echo $this->form->text('text3', 'text3', $profile->getText3())?>
    <?php echo $this->form->text('text4', 'text4', $profile->getText4())?>
    <?php echo $this->form->text('text5', 'text5', $profile->getText5())?>
    <?php echo $this->form->text('text6', 'text6', $profile->getText6())?>
    <?php echo $this->form->text('text7', 'text7', $profile->getText7())?>
    <?php echo $this->form->text('text8', 'text8', $profile->getText8())?>
    <?php echo $this->form->text('checkbox1', 'checkbox1', $profile->getCheckbox1())?>
    <?php echo $this->form->text('checkbox2', 'checkbox2', $profile->getCheckbox2())?>
    <?php echo $this->form->text('checkbox3', 'checkbox3', $profile->getCheckbox3())?>
    <?php echo $this->form->submit()?>
</form>