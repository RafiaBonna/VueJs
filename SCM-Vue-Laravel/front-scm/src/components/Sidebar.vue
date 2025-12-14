<template>
  <aside class="main-sidebar sidebar-light-indigo elevation-4">
    <router-link to="/" class="brand-link">
      <img src="/dist/img/vue.png" 
           alt="AdminLTE Logo" 
           class="brand-image img-circle elevation-3" 
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b>SCM PANEL</b></span>
    </router-link>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" 
            data-widget="treeview" 
            role="menu" 
            data-accordion="false">

          <li class="nav-item" v-if="userRole">
            <router-link :to="dashboardLink" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>{{ dashboardTitle }}</p>
            </router-link>
          </li>

          <li class="nav-item" v-if="userRole === 'admin'">
            <router-link :to="{ name: 'user-list' }" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>User Management</p>
            </router-link>
          </li>

          <li class="nav-item has-treeview" v-if="userRole === 'admin'">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                      Settings
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              
              <ul class="nav nav-treeview">
                  
                  <li class="nav-item">
                      <router-link :to="{ name: 'depo-list' }" class="nav-link">
                          <i class="fas fa-warehouse nav-icon"></i>
                          <p>Depo List</p>
                      </router-link>
                  </li>

                  <li class="nav-item">
                      <router-link :to="{ name: 'supplier-list' }" class="nav-link">
                          <i class="fas fa-truck-moving nav-icon"></i>
                          <p>Supplier List</p>
                      </router-link>
                  </li>
                  
              </ul>
          </li>
          <li class="nav-item" v-if="userRole === 'depo'">
            <router-link to="/dashboard/depo/inventory" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Inventory</p>
            </router-link>
          </li>

          <li class="nav-item" v-if="userRole === 'distributor'">
            <router-link to="/dashboard/distributor/orders" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Place Order</p>
            </router-link>
          </li>

          </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import axios from "axios";
import router from "../router";

export default {
  name: "Sidebar",

  data() {
    return {
      userRole: localStorage.getItem("user_role"), //
    };
  },

  watch: {
    $route() {
      this.userRole = localStorage.getItem("user_role"); //
    },
  },

  computed: {
    dashboardLink() {
      if (this.userRole === "admin") {
        return { name: "admin-dashboard" }; //
      }
      if (this.userRole === "depo") {
        return { name: "depo-dashboard" }; //
      }
      if (this.userRole === "distributor") {
        return { name: "distributor-dashboard" }; //
      }
      return { name: "login" };
    },

    dashboardTitle() {
      if (this.userRole === "admin") return "Admin Dashboard"; //
      if (this.userRole === "depo") return "Depo Dashboard"; //
      if (this.userRole === "distributor") return "Distributor Dashboard"; //
      return "Dashboard";
    },
  },

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
   FULL SIDEBAR LAVENDER THEME
   ============================== */

/* Sidebar background */
.main-sidebar {
  background-color: #f2efff !important; /* Soft lavender */
}

/* Brand area */
.main-sidebar .brand-link {
  background-color: #e6e1ff !important;
  color: #3f2b96 !important;
}

/* Menu text & icon default */
.nav-sidebar .nav-link {
  color: #3f2b96 !important; /* Indigo */
}

.nav-sidebar .nav-link .nav-icon {
  color: #3f2b96 !important;
}

/* Hover effect */
.nav-sidebar .nav-link:hover {
  background-color: #ddd6ff !important; /* darker lavender */
  color: #2c1a7a !important;
}

.nav-sidebar .nav-link:hover .nav-icon {
  color: #2c1a7a !important;
}

/* Active menu item - Deep Lavender */
.nav-sidebar .nav-link.router-link-active,
.nav-sidebar .nav-link.router-link-exact-active {
  background-color: #6a5acd !important; /* Deep Lavender */
  color: #ffffff !important;
}

.nav-sidebar .nav-link.router-link-active .nav-icon,
.nav-sidebar .nav-link.router-link-exact-active .nav-icon {
  color: #ffffff !important;
}


/* Treeview submenu background */
.nav-treeview {
  background-color: #ebe7ff !important;
}
</style>
