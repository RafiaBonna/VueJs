<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Depo/Distributor List</h1>
        </div>

        <section class="content">
            <div class="row mb-3">
                <div class="col-12">
                    <router-link :to="{ name: 'depo-create' }" class="btn btn-info float-right">
                        <i class="fas fa-plus-circle"></i> Add New Depo
                    </router-link>
                </div>
            </div>

            <div v-if="loading" class="text-center text-primary">Loading Depos...</div>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>

            <div class="card card-outline card-info">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(depo, index) in depos" :key="depo.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ depo.name }}</td>
                                <td>{{ depo.location }}</td>
                                <td>{{ depo.contact_person }}</td>
                                <td>{{ depo.phone }}</td>
                                <td>
                                    <router-link :to="{ name: 'depo-edit', params: { id: depo.id } }" class="btn btn-sm btn-primary mr-1">
                                        <i class="fas fa-edit"></i>
                                    </router-link>
                                    <button @click="deleteDepo(depo.id)" class="btn btn-sm btn-danger">
                                        <i class="fas fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!depos.length && !loading">
                                <td colspan="6" class="text-center">No Depos/Distributors found.</td>
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
    name: "DepoList",
    data() {
        return {
            depos: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchDepos();
    },
    methods: {
        async fetchDepos() {
            this.loading = true;
            this.error = null;
            try {
                // API কল: GET /api/admin/depos (যা আমরা UserController-এর জন্য ব্যবহার করেছিলাম)
                const response = await axios.get('admin/depos');
                this.depos = response.data; 
                
            } catch (err) {
                console.error("Error fetching depos:", err);
                this.error = `Failed to load Depo list. Server Error: ${err.response?.status} - ${err.response?.data?.message || 'Check network tab.'}`; 
            } finally {
                this.loading = false;
            }
        },
        async deleteDepo(depoId) {
            if (!confirm('Are you sure you want to delete this Depo?')) {
                return;
            }
            
            this.loading = true;
            this.error = null;
            try {
                await axios.delete(`admin/depos/${depoId}`);
                alert('Depo deleted successfully!');
                
                this.fetchDepos();

            } catch (err) {
                console.error("Error deleting depo:", err);
                this.error = `Deletion failed: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>