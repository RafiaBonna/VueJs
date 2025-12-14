// src/router/index.js (আপডেটেড ফাইল)

import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue';
import DashboardLayout from '../layout/DashboardLayout.vue';
import axios from 'axios'; // Logout-এর জন্য axios দরকার হতে পারে

// ✅ মডিউল ফাইলগুলি ইম্পোর্ট করুন
import adminRoutes from './modules/admin';
import depoRoutes from './modules/depo';
import distributorRoutes from './modules/distributor';

// ফাংশন: রোল অনুযায়ী ড্যাশবোর্ড রুটের নাম রিটার্ন করে
const getDashboardRouteName = (role) => {
    if (role === 'admin') return 'admin-dashboard';
    if (role === 'depo') return 'depo-dashboard';
    if (role === 'distributor') return 'distributor-dashboard';
    return 'login'; 
}

// ✅ সমস্ত রোল-ভিত্তিক রুট একত্রিত করা
const dashboardChildrenRoutes = [
    ...adminRoutes,
    ...depoRoutes,
    ...distributorRoutes,
];


const routes = [
  // 1. লগইন রুট (পাবলিক) - এটিই আমাদের '/' রুট
  {
    path: '/',
    name: 'login',
    component: LoginView 
  },
  
  // 2. ড্যাশবোর্ড লেআউট
  {
    path: '/dashboard', 
    component: DashboardLayout,   
    // ✅ একত্রিত রুটগুলি এখানে যুক্ত করা হলো
    children: dashboardChildrenRoutes
  },
  
  // 3. 404/NotFound route
  { path: '/:catchAll(.*)', name: 'NotFound', redirect: '/' }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

// ----------------------------------------------------
// Global Navigation Guard (Auth and Role Check)
// ----------------------------------------------------

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('auth_token');
  const userRole = localStorage.getItem('user_role'); 
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  
  // A. সুরক্ষিত রুট হ্যান্ডলিং
  if (requiresAuth) {
    if (!isAuthenticated) {
      return next({ name: 'login' });
    }
    
    // রোল চেক করো 
    const requiredRoles = to.meta.roles;
    if (requiredRoles && !requiredRoles.includes(userRole)) {
      
      const userDashboardRoute = getDashboardRouteName(userRole);
      
      // যদি এটিই তার ড্যাশবোর্ড হয়, তবে লুপ এড়াতে next() কল করো।
      if (to.name === userDashboardRoute) {
        return next(); 
      }
      
      // অন্যথায় তার ড্যাশবোর্ডে রিডিরেক্ট করো
      return next({ name: userDashboardRoute }); 
    }
    
    return next();
  } 
  
  // B. লগইন পেজ হ্যান্ডলিং
  else if (to.name === 'login' && isAuthenticated) {
    
    const userDashboardRouteName = getDashboardRouteName(userRole);
    
    // যদি টোকেন থাকে কিন্তু রোল না পায় (অথবা রোল ভুলবশত 'login' রিটার্ন করে), 
    // তবে লোকাল স্টোরেজ পরিষ্কার করে বর্তমান রুটে থাকার অনুমতি দাও
    if (userDashboardRouteName === 'login' && to.name === 'login') {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_role');
        return next(); 
    }
    
    // টোকেন থাকলে ড্যাশবোর্ডে রিডিরেক্ট
    return next({ name: userDashboardRouteName });
  } 
  
  // C. অন্য সব ক্ষেত্রে
  else {
    return next();
  }
});

export default router;