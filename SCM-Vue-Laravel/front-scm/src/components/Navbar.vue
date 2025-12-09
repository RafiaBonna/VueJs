// src/components/Navbar.vue

<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <li class="nav-item">
          <a href="#" @click.prevent="handleLogout" class="nav-link" title="Logout">
              <i class="fas fa-sign-out-alt"></i>
          </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import axios from 'axios';
import router from '../router';

export default { 
    name: "Navbar",
    methods: {
        async handleLogout() {
            if (!confirm('Are you sure you want to logout?')) {
                return;
            }

            try {
                // Axios-এ গ্লোবাল অথরাইজেশন হেডার সেট করা আছে (main.js-এ), তাই এখানে হেডার দেওয়ার দরকার নেই
                await axios.post('logout'); 
                
            } catch (error) {
                // এটি 401 এরর দিতে পারে, কিন্তু টোকেন ডিলিট করাই আমাদের মূল লক্ষ্য
                console.error("Logout API call failed, but proceeding with client side logout:", error);
            }
            
            // 3. ফ্রন্টএন্ড থেকে টোকেন ও রোল মুছে ফেলা
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_role');

            // 4. লগইন পেজে রিডিরেক্ট করা
            router.push({ name: 'login' });
        }
    } 
};
</script>