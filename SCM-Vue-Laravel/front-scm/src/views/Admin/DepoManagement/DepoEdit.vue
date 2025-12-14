<template>
    <div class="container-fluid">
        <div class="content-header">
            <h1 class="m-0 text-info">Edit Depo/Distributor ID: {{ $route.params.id }}</h1>
        </div>

        <section class="content">
            <div v-if="loading && !depo.id" class="text-center text-primary">Loading Depo data...</div>
            
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            
            <div v-if="validationErrors" class="alert alert-warning">
                <ul class="mb-0">
                    <li v-for="(messages, field) in validationErrors" :key="field">
                        <strong>{{ field }}:</strong> {{ messages[0] }}
                    </li>
                </ul>
            </div>
            
            <div class="card card-outline card-info" v-if="depo.id">
                <div class="card-body">
                    <form @submit.prevent="updateDepo">
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
                            Update Depo
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
    name: "DepoEdit",
    data() {
        return {
            depo: {
                id: this.$route.params.id,
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
    mounted() {
        this.fetchDepo();
    },
    methods: {
        async fetchDepo() {
            this.loading = true;
            this.error = null;
            try {
                // API কল: GET /api/admin/depos/{id}
                const response = await axios.get(`admin/depos/${this.depo.id}`);
                this.depo = response.data;

            } catch (err) {
                console.error("Error fetching depo:", err);
                this.error = `Failed to load Depo data: ${err.response?.data?.message || 'Server error'}`;
            } finally {
                this.loading = false;
            }
        },
        async updateDepo() {
            this.loading = true;
            this.error = null;
            this.validationErrors = null;

            const formData = {
                ...this.depo,
                _method: 'patch' // Laravel PATCH রিকোয়েস্টের জন্য
            };
            
            try {
                // API কল: POST /api/admin/depos/{id} (for PATCH)
                await axios.post(`admin/depos/${this.depo.id}`, formData);

                alert('Depo updated successfully!');
                
                this.$router.push({ name: 'depo-list' });

            } catch (err) {
                if (err.response && err.response.status === 422) {
                    this.validationErrors = err.response.data.errors;
                    this.error = 'Validation failed. Please check the form.';
                } else {
                    console.error("Error updating depo:", err);
                    this.error = `Update failed: ${err.response?.data?.message || 'Server error'}`;
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>