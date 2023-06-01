<div class="contenedor recuperar">
    <h1 class="titulo">UpTask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo Password</p>

        <?php 
            include_once __DIR__.'/../template/alertas.php'; 
            if ($mostrar) {
        ?>

        <form method="POST" class="formulario">
            <div class="campo">
                <label for="password">Clave:</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>
            
            <input type="submit" value="Cambiar Password" class="btn">
        </form>

        <?php } ?>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/crear">Aún no tienes una Cuenta? Crea Una</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div> <!-- .contenedor -->