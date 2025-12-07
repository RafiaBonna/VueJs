import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// ✅ REMOVED: import 'bootstrap/dist/css/bootstrap.min.css' (Index.html e AdminLTE-er modhye already ache)
// ✅ REMOVED: import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const app = createApp(App)
app.use(router)
app.mount('#app')