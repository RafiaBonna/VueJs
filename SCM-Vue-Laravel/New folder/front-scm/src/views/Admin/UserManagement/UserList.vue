<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-info">User List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'admin-dashboard' }">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row mb-3">
                <div class="col-12">
                   <router-link :to="{ name: 'user-create' }" class="btn btn-info float-right">
                        <i class="fas fa-plus-circle"></i> Add User
                    </router-link>
                </div>
            </div>

            <div v-if="loading" class="text-center text-primary">Loading users...</div>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>

            <div class="card card-outline card-info">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Depo/Distributor</th> 
                                <th>Role</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.depo_name }}</td> 
                                <td>
                                    <span class="badge" :class="getRoleBadgeClass(user.role)">
                                        {{ user.role.toUpperCase() || 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <router-link :to="{ name: 'user-edit', params: { id: user.id } }" class="btn btn-sm btn-primary mr-1">
                                        <i class="fas fa-edit"></i>
                                    </router-link>
                                    <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!users.length && !loading">
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "UserList",
    data() {
        return {
            users: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        getRoleBadgeClass(role) {
            if (role === 'admin') return 'bg-danger';
            if (role === 'depo') return 'bg-primary';
            if (role === 'distributor') return 'bg-warning';
            return 'bg-secondary';
        },
        async fetchUsers() {
            this.loading = true;
            this.error = null;
            try {
                // ✅ API কল: GET /api/admin/users
                const response = await axios.get('admin/users');
                this.users = response.data; 
                
            } catch (err) {
                console.error("Error fetching users:", err);
                this.error = `Failed to load user list. Server Error: ${err.response?.status} - ${err.response?.data?.message || 'Check network tab for 500 error.'}`; 
            } finally {
                this.loading = false;
            }
        },
        async deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user?')) {
                return;
            }
            
            this.loading = true;
            this.error = null;
            try {
                // ✅ API কল: DELETE /api/admin/users/{id}
                await axios.delete(`admin/users/${userId}`);
                alert('User deleted successfully!');
                
                this.fetchUsers();

            } catch (err) {
                console.error("Error deleting user:", err);
                this.error = `Deletion failed: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>