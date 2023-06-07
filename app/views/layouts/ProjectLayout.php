<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? ''; ?> | Projetify</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="/build/css/app.css">

  <link rel="icon" href="/icons/favicon.svg">
</head>
<body class="layout">
  <div class="layout__project">
    <?php  include_once __DIR__.'/../template/header.php'; ?>

    <main class="layout__project--container" id="dashboard">
      <?php include_once __DIR__.'/../template/sidebar.php'; ?>

      <div class="layout__project--main projects">
        <?php echo $content; ?>
      </div>
    </main>
  </div>

  <?php echo $script ?? ''; ?>
  
  <script src='/build/js/main.js' ></script>
</body>
</html>