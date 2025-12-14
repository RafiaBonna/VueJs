<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Add New Depo/Distributor</h1>
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
                    <form @submit.prevent="createDepo">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Depo/Distributor Name</label>
                                <input type="text" class="form-control" id="name" v-model="depo.name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="location">Location (City/Area)</label>
                                <input type="text" class="form-control" id="location" v-model="depo.location" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="contact_person">Contact Person</label>
                                <input type="text" class="form-control" id="contact_person" v-model="depo.contact_person">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" v-model="depo.phone">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info mt-3" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                            <i v-else class="fas fa-save"></i>
                            Create Depo
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
    name: "DepoCreate",
    data() {
        return {
            depo: {
                name: '',
                location: '',
                contact_person: '',
                phone: '',
            },
            validationErrors: null,
            error: null,
            loading: false,
        };
    },
    methods: {
        async createDepo() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;
            
            try {
                // API কল: POST /api/admin/depos
                await axios.post('admin/depos', this.depo);

                alert('Depo created successfully!');
                
                this.$router.push({ name: 'depo-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error creating depo:", err);
                    this.error = `Creation failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>