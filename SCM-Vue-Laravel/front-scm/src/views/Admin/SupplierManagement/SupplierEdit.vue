<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Edit Supplier ID: {{ $route.params.id }}</h1>
        </div>

        <section class="content">
            <div v-if="loading && !supplier.id" class="text-center text-primary">Loading Supplier data...</div>
            
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            
            <div v-if="validationErrors" class="alert alert-warning">
                <ul class="mb-0">
                    <li v-for="(messages, field) in validationErrors" :key="field">
                        <strong>{{ field }}:</strong> {{ messages[0] }}
                    </li>
                </ul>
            </div>
            
            <div class="card card-outline card-info" v-if="supplier.id">
                <div class="card-body">
                    <form @submit.prevent="updateSupplier">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Supplier Name</label>
                                <input type="text" class="form-control" id="name" v-model="supplier.name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" class="form-control" id="contact_person" v-model="supplier.contact_person">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" v-model="supplier.phone">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" v-model="supplier.email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" v-model="supplier.address"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info mt-3" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Update Supplier
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
    name: "SupplierEdit",
    data() {
        return {
            supplier: {
                id: this.$route.params.id,
                name: '',
                contact_person: '',
                phone: '',
                email: '',
                address: '',
            },
            validationErrors: null,
            error: null,
            loading: false,
        };
    },
    mounted() {
        this.fetchSupplier();
    },
    methods: {
        async fetchSupplier() {
            this.loading = true;
            this.error = null;
            try {
                // API কল: GET /api/admin/suppliers/{id}
                const response = await axios.get(`admin/suppliers/${this.supplier.id}`);
                this.supplier = response.data;

            } catch (err) {
                console.error("Error fetching supplier:", err);
                this.error = `Failed to load Supplier data: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        },
        async updateSupplier() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;

            const formData = {
                ...this.supplier,
                _method: 'patch' // Laravel PATCH রিকোয়েস্টের জন্য
            };
            
            try {
                // API কল: POST /api/admin/suppliers/{id} (for PATCH)
                await axios.post(`admin/suppliers/${this.supplier.id}`, formData);

                alert('Supplier updated successfully!');
                
                this.$router.push({ name: 'supplier-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error updating supplier:", err);
                    this.error = `Update failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>