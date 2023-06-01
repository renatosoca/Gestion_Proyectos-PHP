<aside class="sidebar">
  <a href="/dashboard" class="sidebar__title">Task</a>

  <nav class="sidebar-nav">
    <a class="<?php echo isLinkActive('/dashboard') ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
    
    <a class="<?php echo isLinkActive('/create-project') ? 'activo' : ''; ?>" href="/create-project">Crear Proyecto</a>

    <a class="<?php echo isLinkActive('/user/profile') ? 'activo' : ''; ?>" href="/user/profile">Perfil</a>
  </nav>
</aside>