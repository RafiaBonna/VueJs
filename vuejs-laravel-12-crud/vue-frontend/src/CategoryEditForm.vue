<script>
import axios from "axios";

export default {
    props: {
        // The category object passed from App.vue
        category: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            // Use local form data, initialized from the prop
            form: { ...this.category }, 
            message: '',
            isSuccess: false,
        };
    },
    methods: {
        /**
         * Submits the updated form data to the Laravel API using PUT.
         */
        async updateCategory() {
            this.message = 'Updating category...';
            this.isSuccess = false;

            try {
                // Use the ID from the local form data to build the endpoint URL
                const response = await axios.put(`http://127.0.0.1:8000/api/category/${this.form.id}`, this.form);

                this.message = response.data.message || 'Category updated successfully!';
                this.isSuccess = true;

                // Emit an event to tell the parent (App.vue) the update is complete
                this.$emit('update-completed');

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    this.message = Object.values(errors).flat()[0] || 'An error occurred during update.';
                } else {
                    this.message = 'Error updating category. Please check the console.';
                    console.error('API Error:', error);
                }
                this.isSuccess = false;
            }
        },

        /**
         * Cancels the edit process.
         */
        cancelEdit() {
            this.$emit('cancel-edit');
        }
    }
};
</script>

<template>
    <div class="category-form-container edit-container">
        <h2>✍️ Edit Category: {{ form.title }}</h2>
        
        <form @submit.prevent="updateCategory">
            <div class="form-group">
                <label for="title-edit">Category Title:</label>
                <input 
                    type="text" 
                    id="title-edit" 
                    class="form-control"
                    v-model="form.title" 
                    required
                />
            </div>

            <div class="form-group">
                <label for="description-edit">Description :</label>
                <textarea 
                    id="description-edit" 
                    class="form-control"
                    v-model="form.description"
                ></textarea>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary">
                    Update Category 
                </button>
                <button type="button" class="btn btn-secondary" @click="cancelEdit">
                    Cancel 
                </button>
            </div>
        </form>

        <div v-if="message" :class="{'alert-success': isSuccess, 'alert-danger': !isSuccess}" class="alert mt-3">
            {{ message }}
        </div>
    </div>
</template>

<style scoped>
/* Reusing basic form styles from CategoryForm.vue */
.category-form-container {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
}
.edit-container {
    border: 2px solid #007bff; /* Highlight the edit form */
}
.form-group {
    margin-bottom: 15px;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; 
}
.button-group button:not(:last-child) {
    margin-right: 10px;
}
.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
}
.btn-primary {
    background-color: #007bff;
}
.btn-secondary {
    background-color: #6c757d;
}
.alert {
    padding: 10px;
    border-radius: 4px;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}
</style>