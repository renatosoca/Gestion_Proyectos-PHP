<?php include_once __DIR__.'/header_dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__.'/../template/alertas.php'; ?>

    <form action="/crear-proyecto" class="formulario" method="POST">

        <?php include_once __DIR__.'/formulario.php'; ?>

        <input type="submit" value="Crear Proyecto" class="btn">
    </form>
</div>

<?php include_once __DIR__.'/footer_dashboard.php'; ?>