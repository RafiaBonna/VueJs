// src/components/Sidebar.vue

<template>
  <aside class="main-sidebar sidebar-light-indigo elevation-4">
    <router-link to="/" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SCM PANEL</span>
    </router-link>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item" v-if="userRole">
            <router-link :to="dashboardLink" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>{{ dashboardTitle }}</p>
            </router-link>
          </li>

          <li class="nav-item" v-if="userRole === 'admin'">
            <router-link to="/dashboard/admin/users" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>User Management</p>
            </router-link>
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
import axios from 'axios';
import router from '../router';

export default { 
    name: "Sidebar",
    data() {
        return {
            // Local Storage থেকে রোল নেওয়া হচ্ছে
            userRole: localStorage.getItem('user_role'),
        }
    },
    watch: {
        // রুট পরিবর্তন হলে রোল আপডেট করার জন্য
        $route() {
            this.userRole = localStorage.getItem('user_role');
        }
    },
    computed: {
        // রোল অনুযায়ী ড্যাশবোর্ড লিঙ্ক তৈরি করা
        dashboardLink() {
            if (this.userRole === 'admin') {
                return { name: 'admin-dashboard' };
            } else if (this.userRole === 'depo') {
                return { name: 'depo-dashboard' };
            } else if (this.userRole === 'distributor') {
                return { name: 'distributor-dashboard' };
            }
            return { name: 'login' };
        },
        // রোল অনুযায়ী ড্যাশবোর্ডের শিরোনাম তৈরি করা
        dashboardTitle() {
            if (this.userRole === 'admin') {
                return 'Admin Dashboard';
            } else if (this.userRole === 'depo') {
                return 'Depo Dashboard';
            } else if (this.userRole === 'distributor') {
                return 'Distributor Dashboard';
            }
            return 'Dashboard';
        }
    },
    methods: {
      // লগআউট ফাংশন, Navbar থেকে কপি করা হয়েছে
      async handleLogout() {
          if (!confirm('Are you sure you want to logout?')) {
              return;
          }

          try {
              await axios.post('logout'); 
          } catch (error) {
              console.error("Logout API call failed, but proceeding with client side logout:", error);
          }
          
          localStorage.removeItem('auth_token');
          localStorage.removeItem('user_role');
          router.push({ name: 'login' });
      }
    }
};
</script>