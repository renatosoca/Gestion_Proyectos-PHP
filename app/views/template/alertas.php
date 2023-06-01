<?php
    foreach ($alertas as $key => $value) {
        foreach ($value as $mensaje) {            
?>
        <div class="alertas <?php echo $key ?>" ><?php echo $mensaje ?></div>
<?php
        }
    }
?>