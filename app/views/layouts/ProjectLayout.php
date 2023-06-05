<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? ''; ?> | Task</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="/build/css/app.css">

  <link rel="icon" href="/icons/favicon.svg">
</head>
<body>

  <div class="layout__project">
    <div class="dashboard" id="dashboard">
      <?php include_once __DIR__.'/../template/sidebar.php'; ?>

      <div class="principal">
        <?php  include_once __DIR__.'/../template/header.php'; ?>

        <div class="layout__container">
          <h2 class="nombre-pagina"><?php echo $title; ?></h2>
          <?php echo $content; ?>
        </div>
      </div>
    </div>
  </div>

  <?php echo $script ?? ''; ?>
</body>
</html>