<template>
  <nav class="main-header navbar navbar-expand custom-navbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a
          class="nav-link"
          data-widget="pushmenu"
          href="#"
          role="button"
        >
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a
          class="nav-link"
          data-widget="fullscreen"
          href="#"
          role="button"
        >
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <a
          href="#"
          @click.prevent="handleLogout"
          class="nav-link"
          title="Logout"
        >
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import axios from "axios";
import router from "../router";

export default {
  name: "Navbar",
  methods: {
    async handleLogout() {
      if (!confirm("Are you sure you want to logout?")) return;

      try {
        await axios.post("logout");
      } catch (error) {
        console.warn("Logout API failed, proceeding anyway.");
      }

      localStorage.removeItem("auth_token");
      localStorage.removeItem("user_role");
      router.push({ name: "login" });
    },
  },
};
</script>

<style scoped>
/* ==============================
   NAVBAR – LAVENDER THEME
   ============================== */

.custom-navbar {
  background-color: #e6e1ff !important; /* Lavender */
  border-bottom: 1px solid #d6cfff;
}

.custom-navbar .nav-link {
  color: #3f2b96 !important; /* Indigo */
}

.custom-navbar .nav-link i {
  color: #3f2b96 !important;
}

/* Hover */
.custom-navbar .nav-link:hover {
  background-color: #ddd6ff !important;
  color: #2c1a7a !important;
}

.custom-navbar .nav-link:hover i {
  color: #2c1a7a !important;
}
</style>
