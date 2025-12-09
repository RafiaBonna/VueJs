// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue';
import DashboardLayout from '../layout/DashboardLayout.vue';

// রোল-ভিত্তিক ড্যাশবোর্ড ভিউগুলো ইম্পোর্ট করা হলো 
import AdminDashboard from '../views/DashboardView.vue'; 
import DepoDashboard from '../views/DepoDashboard.vue'; 
import DistributorDashboard from '../views/DistributorDashboard.vue'; 

// ফাংশন: রোল অনুযায়ী ড্যাশবোর্ড রুটের নাম রিটার্ন করে
const getDashboardRouteName = (role) => {
    // রোল lowercase-এ না থাকলে, এটি সঠিকভাবে ডিটেক্ট করতে পারবে না
    if (role === 'admin') return 'admin-dashboard';
    if (role === 'depo') return 'depo-dashboard';
    if (role === 'distributor') return 'distributor-dashboard';
    return 'login'; 
}

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
    children: [
      { 
        path: 'admin', 
        name: 'admin-dashboard',
        component: AdminDashboard, 
        meta: { requiresAuth: true, roles: ['admin'] } 
      },
      { 
        path: 'depo', 
        name: 'depo-dashboard',
        component: DepoDashboard, 
        meta: { requiresAuth: true, roles: ['depo'] } 
      },
      { 
        path: 'distributor', 
        name: 'distributor-dashboard',
        component: DistributorDashboard, 
        meta: { requiresAuth: true, roles: ['distributor'] } 
      },
      // 2.4. যদি কেউ /dashboard লিখে এন্টার করে
      { 
        path: '', 
        redirect: to => {
            const isAuthenticated = localStorage.getItem('auth_token');
            const role = localStorage.getItem('user_role');
            
            if (isAuthenticated) {
                const name = getDashboardRouteName(role);
                return { name };
            }
            return { name: 'login' };
        }
      },
    ]
  },
  
  // 3. NotFound (404) রুট
  { 
    // এই রুটটি নিশ্চিত করবে যে ডাবল স্ল্যাশ তৈরি হচ্ছে না
    path: '/:catchAll(.*)', 
    name: 'NotFound', 
    redirect: { name: 'login' } 
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

// Vue Router Guard (Final Failsafe Logic)
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth_token');
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
  
  // B. লগইন পেজ হ্যান্ডলিং (সমস্যার মূল জায়গা)
  else if (to.name === 'login' && isAuthenticated) {
    
    const userDashboardRouteName = getDashboardRouteName(userRole);
    
    // যদি টোকেন থাকে কিন্তু রোল না পায় (অথবা রোল ভুলবশত 'login' রিটার্ন করে), 
    // তবে লোকাল স্টোরেজ পরিষ্কার করে বর্তমান রুটে থাকার অনুমতি দাও
    if (userDashboardRouteName === 'login' && to.name === 'login') {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_role');
        return next();
    }

    // যদি সঠিক ড্যাশবোর্ড রুট পায়, তবে সেখানে রিডিরেক্ট করো
    return next({ name: userDashboardRouteName });
  } 
  
  // C. সাধারণ (পাবলিক) রুটের জন্য
  else {
    return next();
  }
});


export default router;