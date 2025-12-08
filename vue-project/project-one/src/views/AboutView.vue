<template>
  <div class="text-center">
    <h1 class="mb-4">About Page</h1>

    <div class="card mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <h5 class="card-title">About Us</h5>
        <p class="card-text">
          This page describes the purpose of this Vue 3 application.
        </p>

        <ul class="list-group list-group-flush text-start">
          <li class="list-group-item">Built with Vue 3</li>
          <li class="list-group-item">Uses Vue Router for navigation</li>
          <li class="list-group-item">Styled with Bootstrap 5</li>
        </ul>

        <router-link to="/contact" class="btn btn-primary mt-3">Contact Us</router-link>
      </div>
    </div>
  </div>
</template>

<script setup></script>
