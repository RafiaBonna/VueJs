import { createRouter, createWebHistory } from 'vue-router'

// ✅ FIX: Shudhu Dashboard related components import kora holo
import DashboardLayout from '../layout/DashboardLayout.vue';
import DashboardView from '../views/DashboardView.vue';

const routes = [
  // HomeView route remove kora holo

  {
    path: '/',
    component: DashboardLayout,   
    children: [
      { 
        // Default route: Accessible at /
        path: '', 
        name: 'dashboard-root',
        component: DashboardView 
      },
      { 
        // Accessible at /dashboard
        path: 'dashboard', 
        name: 'dashboard',
        component: DashboardView 
      },
    ]
  },
  
  // NotFound route-keo Dashboard-e pathano holo
  { path: '/:catchAll(.*)', name: 'NotFound', redirect: '/' }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

export default router;