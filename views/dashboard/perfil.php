<?php include_once __DIR__.'/header_dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__.'/../template/alertas.php'; ?>

    <a href="/cambiar-clave" class="btn">Cambiar Contraseña</a>

    <form action="/perfil" class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo s($usuario->nombre); ?>" placeholder="Tu Nombre">
        </div>
        
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo s($usuario->email); ?>" placeholder="Tu Email">
        </div>

        <input type="submit" value="Guardar Cambio" class="btn">
    </form>
</div>

<?php include_once __DIR__.'/footer_dashboard.php'; ?>