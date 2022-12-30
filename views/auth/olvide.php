<div class="contenedor olvide">
    <h1 class="titulo">UpTask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Password</p>

        <?php include_once __DIR__.'/../template/alertas.php'; ?>

        <form action="/olvide" method="POST" class="formulario">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu Email">
            </div>
            
            <input type="submit" value="Enviar Instrucciones" class="btn">
        </form>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/crear">Aún no tienes una Cuenta? Crea Una</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div> <!-- .contenedor -->