<template>
  <div class="d-flex flex-column" style="height: 100vh;">
    <Header />

    <div class="d-flex flex-grow-1">
      <Sidebar />

      <main class="flex-grow-1 p-4">
        <router-view />
      </main>
    </div>

    <Footer />
  </div>
</template>

<script>
import Header from "../components/Header.vue";
import Sidebar from "../components/Sidebar.vue";
import Footer from "../components/Footer.vue";

export default {
  components: { Header, Sidebar, Footer }
};
</script>
