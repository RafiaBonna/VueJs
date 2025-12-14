<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-info">Create New User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'admin-dashboard' }">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'user-list' }">Users</router-link>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            
            <div v-if="validationErrors" class="alert alert-warning">
                <ul class="mb-0">
                    <li v-for="(messages, field) in validationErrors" :key="field">
                        <strong>{{ field }}:</strong> {{ messages[0] }}
                    </li>
                </ul>
            </div>
            
            <div class="card card-outline card-info">
                <div class="card-body">
                    <form @submit.prevent="createUser">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" v-model="user.name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" v-model="user.email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" v-model="user.role" required>
                                    <option value="" disabled>Select Role</option>
                                    <option v-for="role in roles" :key="role.value" :value="role.value">
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group" v-if="user.role === 'depo' || user.role === 'distributor'">
                                <label for="depo">Select Depo/Distributor</label>
                                <select class="form-control" id="depo" v-model="user.depo_id" required>
                                    <option value="" disabled>Select Depo/Distributor</option>
                                    <option v-for="depo in depos" :key="depo.id" :value="depo.id">
                                        {{ depo.name }}
                                    </option>
                                </select>
                                <small v-if="depoLoading" class="text-info">Loading Depo list...</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" v-model="user.password" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" v-model="user.password_confirmation" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info mt-3" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Create User
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "UserCreate",
    data() {
        return {
            user: {
                name: '',
                email: '',
                role: '',
                depo_id: '', // ✅ নতুন ফিল্ড
                password: '', 
                password_confirmation: '',
            },
            roles: [
                { value: 'admin', name: 'Admin' }, 
                { value: 'depo', name: 'Depo' },
                { value: 'distributor', name: 'Distributor' },
            ],
            depos: [], // ✅ ডিপো তালিকা রাখার জন্য নতুন Array
            depoLoading: false, // ✅ Depo লোডিং স্টেট
            validationErrors: null,
            error: null,
            loading: false,
        };
    },
    mounted() {
        this.fetchDepos(); // ✅ কম্পোনেন্ট লোড হওয়ার সময় ডিপো ডেটা আনা হবে
    },
    methods: {
        async fetchDepos() {
            this.depoLoading = true;
            try {
                // API কল: GET /api/admin/depos (এই রুটটি আপনাকে Laravel-এ তৈরি করতে হবে)
                const response = await axios.get('admin/depos'); 
                this.depos = response.data;
            } catch (err) {
                console.error("Error fetching depos:", err);
                // Depo Load ব্যর্থ হলেও অ্যাপ্লিকেশন চলতে থাকবে
                this.error = `Warning: Could not load Depo list. Server Error: ${err.response?.status} - ${err.response?.data?.message || 'Check network tab.'}`;
            } finally {
                this.depoLoading = false;
            }
        },
        async createUser() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;
            
            try {
                // API কল: POST /api/admin/users
                await axios.post('admin/users', this.user);

                alert('User created successfully!');
                
                this.$router.push({ name: 'user-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error creating user:", err);
                    this.error = `Creation failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>