<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Supplier List</h1>
        </div>

        <section class="content">
            <div class="row mb-3">
                <div class="col-12">
                   <router-link :to="{ name: 'supplier-create' }" class="btn btn-info float-right">
                        <i class="fas fa-plus-circle"></i> Add New Supplier
                    </router-link>
                </div>
            </div>

            <div v-if="loading" class="text-center text-primary">Loading Suppliers...</div>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>

            <div class="card card-outline card-info">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(supplier, index) in suppliers" :key="supplier.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ supplier.name }}</td>
                                <td>{{ supplier.contact_person }}</td>
                                <td>{{ supplier.phone }}</td>
                                <td>{{ supplier.email }}</td>
                                <td>
                                    <router-link :to="{ name: 'supplier-edit', params: { id: supplier.id } }" class="btn btn-sm btn-primary mr-1">
                                        <i class="fas fa-edit"></i>
                                    </router-link>
                                    <button @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger">
                                        <i class="fas fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!suppliers.length && !loading">
                                <td colspan="6" class="text-center">No Suppliers found.</td>
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
    name: "SupplierList",
    data() {
        return {
            suppliers: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchSuppliers();
    },
    methods: {
        async fetchSuppliers() {
            this.loading = true;
            this.error = null;
            try {
                // API কল: GET /api/admin/suppliers (এখনো Laravel-এ তৈরি করতে হবে)
                const response = await axios.get('admin/suppliers');
                this.suppliers = response.data; 
                
            } catch (err) {
                console.error("Error fetching suppliers:", err);
                this.error = `Failed to load Supplier list. Server Error: ${err.response?.status} - ${err.response?.data?.message || 'Check network tab.'}`; 
            } finally {
                this.loading = false;
            }
        },
        async deleteSupplier(supplierId) {
            if (!confirm('Are you sure you want to delete this Supplier?')) {
                return;
            }
            
            this.loading = true;
            this.error = null;
            try {
                await axios.delete(`admin/suppliers/${supplierId}`);
                alert('Supplier deleted successfully!');
                
                this.fetchSuppliers();

            } catch (err) {
                console.error("Error deleting supplier:", err);
                this.error = `Deletion failed: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>