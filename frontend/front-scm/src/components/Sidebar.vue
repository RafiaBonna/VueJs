<template>
  <aside class="main-sidebar sidebar-light-indigo elevation-4">
    <router-link to="/" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CONTROL PANEL</span>
    </router-link>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          
          </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
export default { name: "Sidebar" };
</script>