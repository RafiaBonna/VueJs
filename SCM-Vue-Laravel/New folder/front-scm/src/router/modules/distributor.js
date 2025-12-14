// src/router/modules/distributor.js

// যদি ফাইলটি src/views/Distributor/DistributorDashboard.vue এ থাকে
import DistributorDashboard from '../../views/Distributor/DistributorDashboard.vue';

const distributorRoutes = [
    { 
        path: 'distributor', 
        name: 'distributor-dashboard',
        component: DistributorDashboard, 
        meta: { requiresAuth: true, roles: ['distributor'] } 
    },
    // Distributor-এর অন্যান্য রুট এখানে যোগ করুন
    // { path: 'distributor/orders', name: 'distributor-orders', component: DistributorOrdersView, meta: { requiresAuth: true, roles: ['distributor'] } },
];

export default distributorRoutes;