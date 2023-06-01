<?php include_once __DIR__.'/header_dashboard.php'; ?>

<?php if (count( $proyectos ) === 0) { ?>
    <p class='no-proyectos'>No hay Proyectos Aún</p>
    <a href="/crear-proyecto" class="btn">Crea Uno</a>
<?php } else { ?>
    <ul class="listado-proyectos">
    <?php foreach ($proyectos as $row) { ?>
        <li class="proyecto">
            <a href="/proyecto?token=<?php echo $row->url; ?>">
                <?php echo $row->proyecto; ?>
            </a>
        </li>
    <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__.'/footer_dashboard.php'; ?>