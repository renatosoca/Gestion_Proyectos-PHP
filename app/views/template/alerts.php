<?php 
foreach ($alerts as $key => $message) :
  foreach ($message as $messages) :
?>
    <div class="alerts <?php echo $key ?>" >
      <?php echo $messages ?>
    </div>
<?php
  endforeach;
endforeach;
?>