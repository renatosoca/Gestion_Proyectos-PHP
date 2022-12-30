<div class="contenedor crear">
    <h1 class="titulo">UpTask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta</p>

        <?php include_once __DIR__.'/../template/alertas.php'; ?>

        <form action="/crear" method="POST" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre; ?>">
            </div>

            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo $usuario->email; ?>">
            </div>

            <div class="campo">
                <label for="password">Clave:</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>

            <div class="campo">
                <label for="password2">Confirmar Clave:</label>
                <input type="password" name="password2" id="password2" placeholder="Confirma tu Password">
            </div>
            
            <input type="submit" value="Crear Cuenta" class="btn">
        </form>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/olvide">Olvidaste tu Password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div> <!-- .contenedor -->