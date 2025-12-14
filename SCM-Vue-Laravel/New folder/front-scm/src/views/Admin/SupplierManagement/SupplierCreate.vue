<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Add New Raw Material Supplier</h1>
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
                    <form @submit.prevent="createSupplier">
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
                            Create Supplier
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
    name: "SupplierCreate",
    data() {
        return {
            supplier: {
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
    methods: {
        async createSupplier() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;
            
            try {
                // API কল: POST /api/admin/suppliers
                await axios.post('admin/suppliers', this.supplier);

                alert('Supplier created successfully!');
                
                this.$router.push({ name: 'supplier-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error creating supplier:", err);
                    this.error = `Creation failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>