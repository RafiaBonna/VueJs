<template>
  <div class="login-page">
    
    <div class="login-box" style="width: 360px; margin-right: auto; margin-left: auto;">
      
      <div class="card card-outline card-primary" style="
        /* ✅ স্বচ্ছ সাদা রঙ: 75% অস্বচ্ছতা (Opacity 0.75) */
        background-color: rgba(255, 255, 255, 0.75) !important; 
        border-radius: 10px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        border: none;
      ">
        <div class="card-header text-center" style="background-color: transparent !important; color: #333;">
          <a href="#" class="h1"><b>SCM</b> System</a>
        </div>
        <div class="card-body" style="background-color: transparent !important; padding-top: 5px;">
          
          <div v-if="error" class="alert alert-danger">{{ error }}</div>
          <div v-if="validationErrors" class="alert alert-warning">
            <ul class="mb-0">
              <li v-for="(messages, field) in validationErrors" :key="field">
                <strong>{{ field }}:</strong> {{ messages[0] }}
              </li>
            </ul>
          </div>
          
          <fieldset>
            <legend>Sign in to start your session</legend> 
            
            <form @submit.prevent="handleLogin">
              <div class="input-group mb-3">
                <input 
                  type="email" 
                  class="form-control" 
                  placeholder="Email (e.g. distributor@scm.com)" 
                  v-model="loginData.email" 
                  required
                  style="background-color: white !important;" 
                >
                <div class="input-group-append">
                  <div class="input-group-text" style="color: #333;">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>

              <div class="input-group mb-3">
                <input 
                  type="password" 
                  class="form-control" 
                  placeholder="Password" 
                  v-model="loginData.password" 
                  required
                  style="background-color: white !important;" 
                >
                <div class="input-group-append">
                  <div class="input-group-text" style="color: #333;">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-4 offset-8">
                  <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Sign In
                  </button>
                </div>
              </div>
            </form>
            
          </fieldset> 
          
          <p class="mb-1 mt-3">
            <a href="#" style="color: #000; font-weight: bold;">I forgot my password</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import router from '../router'; 

export default {
  name: 'LoginView',
  data() {
    return {
      // ✅ ইনপুট ফিল্ড খালি রাখতে email এবং password এর মান খালি স্ট্রিং হিসেবে সেট করা হয়েছে
      loginData: {
        email: '', 
        password: '' 
      },
      error: null,
      loading: false, 
      validationErrors: null, 
    }
  },
  methods: {
    async handleLogin() {
      this.loading = true; 
      this.error = null;
      this.validationErrors = null; 
      
      try {
        const response = await axios.post('login', this.loginData);
        
        if (response.data.token) {
          const role = response.data.user.role; 
          
          localStorage.setItem('auth_token', response.data.token);
          localStorage.setItem('user_role', role.toLowerCase()); 
          
          let redirectRoute = ''; 
          if (role === 'admin') {
            redirectRoute = 'admin-dashboard';
          } else if (role === 'depo') {
            redirectRoute = 'depo-dashboard';
          } else if (role === 'distributor') {
            redirectRoute = 'distributor-dashboard';
          } 

          if (redirectRoute) {
            router.push({ name: redirectRoute }); 
          } 
        }

      } catch (err) {
        if (err.response) {
            if (err.response.status === 422) { 
                this.validationErrors = err.response.data.errors;
                this.error = "Validation Failed. Check the fields above.";
            }
            else if (err.response.status === 401) {
                this.error = "Invalid email or password.";
            } else {
                this.error = `Error: ${err.response.data.message || 'Login failed.'}`;
            }
        }
        else {
          this.error = "Cannot connect to the server. Check your backend API (http://localhost:8000).";
        }

      } finally {
        this.loading = false; 
      }
    }
  }
}
</script>

<style scoped>
/* Inline Style এখানে কাজ করবে না, তাই শুধু Background এবং Fieldset রাখা হলো */

/* 1. সম্পূর্ণ স্ক্রীনকে পটভূমি হিসেবে ব্যবহার করা */
.login-page {
  height: 100vh;
  display: flex;
  align-items: center; 
  
  /* ছবির পাথ: public ফোল্ডারে আছে কিনা নিশ্চিত করুন */
  background-image: url('/truck-9649555_640.webp'); 
  background-size: cover; 
  background-position: center center; 
  background-repeat: no-repeat; 

  /* ছবিটি স্বাভাবিক থাকবে */
  background-color: transparent; 
  background-blend-mode: normal;
}

/* Fieldset এবং Legend স্টাইল */
fieldset {
    border: 1px solid rgba(0, 0, 0, 0.5); 
    padding: 10px;
    margin-bottom: 5px; 
    border-radius: 5px;
}

legend {
    font-size: 1.1em; 
    font-weight: bold;
    color: #000; 
    padding: 0 5px;
    background-color: transparent; 
    width: auto; 
    margin-bottom: 10px; 
}
</style>