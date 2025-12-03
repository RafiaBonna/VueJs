<script setup>
import { ref } from 'vue'
import logo from './assets/logo.png'
</script>
<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <!-- Logo -->
      <router-link to="/" class="navbar-brand">
        <img :src="logo" alt="Logo" height="40" class="d-inline-block align-text-top">
        
      </router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link to="/" class="nav-link" exact>Home</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/about" class="nav-link">About</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/contact" class="nav-link">Contact</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <router-view />
  </div>
</template>


<style scoped>
/* Active link highlight */
.nav-link.router-link-active {
  font-weight: bold;
  text-decoration: underline;
}
</style>
