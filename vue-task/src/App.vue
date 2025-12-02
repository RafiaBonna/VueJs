<script>
export default {
  data() {
    return {
      name: "",
    };
  }
};
</script>

<template>
  <div class="container">
    <h1>Vue Task Example</h1>

    <input 
      type="text" 
      v-model="name"
      placeholder="Type your name..."
    />

    <h2>
      Hello, {{ name ? name : "Guest" }}!
    </h2>
  </div>
</template>

<style>
.container {
  text-align: center;
  margin-top: 60px;
}
input {
  padding: 10px;
  font-size: 18px;
}
</style>
