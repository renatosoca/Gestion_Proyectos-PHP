<div class="contenedor login">
    <h1 class="titulo">UpTask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__.'/../template/alertas.php'; ?>

        <form action="/" method="POST" class="formulario">
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Tu Email">
            </div>

            <div class="campo">
                <label for="password">Clave:</label>
                <input type="password" name="password" id="password" placeholder="Tu Password">
            </div>
            
            <input type="submit" value="Ingresar" class="btn">
        </form>

        <div class="acciones">
            <a href="/crear">Aún no tienes una Cuenta? Crea Una</a>
            <a href="/olvide">Olvidaste tu Password?</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div> <!-- .contenedor -->