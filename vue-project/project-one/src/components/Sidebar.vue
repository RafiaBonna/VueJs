<template>
  <div class="bg-light border-end vh-100 p-3" style="width: 220px;">
    <h5>Menu</h5>
    <ul class="nav flex-column">
      <li class="nav-item">
        <router-link to="/" class="nav-link">Dashboard</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/products" class="nav-link">Poems</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/orders" class="nav-link">Collections</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default { name: "Sidebar" };
</script>
