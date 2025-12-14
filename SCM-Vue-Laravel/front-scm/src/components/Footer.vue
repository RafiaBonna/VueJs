<template>
  <footer class="main-footer custom-footer text-center py-3">
    <strong>
      Copyright &copy; {{ new Date().getFullYear() }}
    </strong>
    <br />
    All rights reserved by Optichain.
  </footer>
</template>

<script>
export default {
  name: "Footer",
};
</script>

<style scoped>
/* ==============================
/* ==============================
   FOOTER – DEEP LAVENDER THEME
   ============================== */

.custom-footer {
  background-color: #d6ccff; /* Deeper lavender */
  color: #2f1f7a; /* Deep indigo text */
  border-top: 1px solid #c1b5ff; /* Slightly darker border */
}

/* Footer links */
.custom-footer a {
  color: #2f1f7a;
  text-decoration: none;
}

.custom-footer a:hover {
  color: #1f145a; /* Darker on hover */
}

</style>
