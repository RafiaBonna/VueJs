<template>
  <section class="content">
      <div class="container-fluid">
          
          <div class="row">
              <div class="col-12 mt-3">
                  <div class="card card-primary card-outline">
                      <div class="card-header">
                          <h3 class="card-title">Welcome to Home Page</h3>
                      </div>
                      <div class="card-body">
                          <h1 class="text-primary">Your Vue + AdminLTE Project is Running!</h1>
                          <p class="lead">This is an unprotected view. Go to Dashboard to see the main layout.</p>
                          <hr>
                          <router-link to="/" class="btn btn-info">Go to Dashboard</router-link>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </section>
</template>

<script>
export default {
    name: 'HomeView'
}
</script>

<style scoped>
/* Optional styling */
</style>