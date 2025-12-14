// src/main.js

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios' // <-- এটি ইম্পোর্ট করুন

const app = createApp(App)

// ✅ গ্লোবাল Axios সেটিংস: Base URL এবং Authorization Header
// নিশ্চিত করুন যে এই URL আপনার Laravel সার্ভার URL-এর সাথে মিলে যায়
axios.defaults.baseURL = 'http://localhost:8000/api/'; 

// Axios Interceptor: প্রতিটি রিকোয়েস্টের আগে টোকেন যোগ করা
axios.interceptors.request.use(config => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

app.use(router)
app.mount('#app')