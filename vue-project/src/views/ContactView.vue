<template>
  <div class="container mt-5">
    <h1 class="mb-4 text-center">Contact Form</h1>

    <form @submit.prevent="submitForm" class="w-50 mx-auto border p-4 rounded shadow-sm">
      
      <!-- Personal Info Fieldset -->
      <fieldset class="mb-3 p-3 border rounded">
        <legend class="float-none w-auto px-2">Personal Informa</legend>
        
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="name" class="form-control" id="name" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" v-model="email" class="form-control" id="email" required />
        </div>
      </fieldset>

      <!-- Message Fieldset -->
      <fieldset class="mb-3 p-3 border rounded">
        <legend class="float-none w-auto px-2">Message</legend>

        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea v-model="message" class="form-control" id="message" rows="4" required></textarea>
        </div>
      </fieldset>

      <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'ContactView',
  data() {
    return {
      name: '',
      email: '',
      message: ''
    }
  },
  methods: {
    submitForm() {
      alert(`Name: ${this.name}\nEmail: ${this.email}\nMessage: ${this.message}`)
      this.name = ''
      this.email = ''
      this.message = ''
    }
  }
}
</script>

<style scoped>
/* Optional: legend styling */
legend {
  font-size: 1rem;
  font-weight: bold;
}
</style>
