// src/router/modules/depo.js

import DepoDashboard from '../../views//Depo/DepoDashboard.vue'; 

const depoRoutes = [
    { 
        path: 'depo', 
        name: 'depo-dashboard',
        component: DepoDashboard, 
        meta: { requiresAuth: true, roles: ['depo'] } 
    },
    // Depo-এর অন্যান্য রুট এখানে যোগ করুন
    // { path: 'depo/inventory', name: 'depo-inventory', component: DepoInventoryView, meta: { requiresAuth: true, roles: ['depo'] } },
];

export default depoRoutes;