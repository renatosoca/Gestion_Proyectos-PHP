<?php 
foreach ($alerts as $key => $message) :
  foreach ($message as $messages) :
?>
    <div class="alertas <?php echo $key ?>" >
      <?php echo $messages ?>
    </div>
<?php
  endforeach;
endforeach;
?>