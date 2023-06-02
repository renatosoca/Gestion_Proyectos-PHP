<?php if (count($projects) <= 0) : ?>
  <p class='no-proyectos'>No hay Proyectos Aún</p>
  <a href="/create-project" class="btn">Crea Uno</a>
<?php endif; ?>

<?php if (count($projects) >= 0) : ?>
  <ul class="listado-proyectos">
    <?php foreach ($projects as $row) { ?>
      <li>
        <a href="/project/<?php echo $row->url; ?>" class="proyecto">
          <?php echo $row->proyecto; ?>
        </a>
      </li>
    <?php } ?>
  </ul>
<?php endif; ?>