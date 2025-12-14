<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-info">Edit User ID: {{ $route.params.id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'admin-dashboard' }">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'user-list' }">Users</router-link>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div v-if="loading && !user.id" class="text-center text-primary">Loading user data...</div>
            
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            
            <div v-if="validationErrors" class="alert alert-warning">
                <ul class="mb-0">
                    <li v-for="(messages, field) in validationErrors" :key="field">
                        <strong>{{ field }}:</strong> {{ messages[0] }}
                    </li>
                </ul>
            </div>
            
            <div class="card card-outline card-info" v-if="user.id">
                <div class="card-body">
                    <form @submit.prevent="updateUser">
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
                                <label for="password">New Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="password" v-model="user.password">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" v-model="user.password_confirmation">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info mt-3" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Update User
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
    name: "UserEdit",
    data() {
        return {
            user: {
                id: this.$route.params.id,
                name: '',
                email: '',
                role: '',
                depo_id: '', // ✅ নতুন ফিল্ড
                password: null, // Edit-এ null রাখা ভালো
                password_confirmation: null,
            },
            roles: [
                { value: 'admin', name: 'Admin' }, 
                { value: 'depo', name: 'Depo' },
                { value: 'distributor', name: 'Distributor' },
            ],
            depos: [], // ✅ ডিপো তালিকা রাখার জন্য নতুন Array
            depoLoading: false, 
            validationErrors: null,
            error: null,
            loading: false,
        };
    },
    mounted() {
        // দুটি ডেটা লোডিং অপারেশন একসাথে শুরু করা
        this.fetchDepos();
        this.fetchUser(); 
    },
    methods: {
        async fetchDepos() {
            this.depoLoading = true;
            try {
                // API কল: GET /api/admin/depos
                const response = await axios.get('admin/depos'); 
                this.depos = response.data;
            } catch (err) {
                console.error("Error fetching depos:", err);
                this.error = `Warning: Could not load Depo list. Server Error: ${err.response?.status} - ${err.response?.data?.message || 'Check network tab.'}`;
            } finally {
                this.depoLoading = false;
            }
        },
        async fetchUser() {
            this.loading = true;
            this.error = null;
            try {
                // API কল: GET /api/admin/users/{id}
                const response = await axios.get(`admin/users/${this.user.id}`);
                
                // ডেটা সেট করা
                this.user.name = response.data.name;
                this.user.email = response.data.email;
                this.user.role = response.data.role;
                this.user.depo_id = response.data.depo_id; // ✅ depo_id লোড করা হলো

            } catch (err) {
                console.error("Error fetching user:", err);
                this.error = `Failed to load user data: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        },
        async updateUser() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;

            // পাসওয়ার্ড ফিল্ড খালি হলে, আপডেট ডেটা থেকে বাদ দেওয়া 
            const formData = {
                name: this.user.name,
                email: this.user.email,
                role: this.user.role,
                depo_id: this.user.depo_id, // ✅ depo_id যোগ করা হলো
                ...(this.user.password && { 
                    password: this.user.password,
                    password_confirmation: this.user.password_confirmation 
                }),
                _method: 'patch' // Laravel PATCH রিকোয়েস্টের জন্য
            };
            
            try {
                // API কল: POST /api/admin/users/{id}
                await axios.post(`admin/users/${this.user.id}`, formData);

                alert('User updated successfully!');
                
                this.$router.push({ name: 'user-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error updating user:", err);
                    this.error = `Update failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>