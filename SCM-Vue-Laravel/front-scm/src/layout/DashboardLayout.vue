<template>
  <div class="wrapper">
    
    <Navbar />
    
    <Sidebar />

    <div class="content-wrapper">
      <router-view />
    </div>
    
    <Footer />

    <aside class="control-sidebar control-sidebar-dark"></aside>

  </div>
</template>

<script>
// isSidebarOpen logic-ke remove kora holo, AdminLTE JS handle kore
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";
import Footer from "../components/Footer.vue";

export default {
  name: "DashboardLayout",
  components: { Navbar, Sidebar, Footer },
  // setup() block-er isSidebarOpen, toggleSidebar logic remove korun
};
</script>