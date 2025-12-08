<script>
import axios from "axios";

export default {
    data() {
        return {
            // Data properties to hold form input
            form: {
                title: '',
                description: ''
            },
            // Message to display after form submission
            message: '',
            // Flag to handle loading state/display message
            isSuccess: false,
        };
    },
    methods: {
        /**
         * Submits the form data to the Laravel API.
         */
        async createCategory() {
            this.message = 'Creating category...';
            this.isSuccess = false;

            try {
                // Adjust the URL if your setup is different
                const response = await axios.post('http://127.0.0.1:8000/api/category', this.form);

                this.message = response.data.message || 'Category created successfully!';
                this.isSuccess = true;

                // Reset the form fields after successful submission
                this.form.title = '';
                this.form.description = '';

                // You might want to emit an event here to notify the parent 
                // component (e.g., App.vue) to refresh the list of categories.
                this.$emit('category-created');

            } catch (error) {
                // Handle validation errors or other API errors
                if (error.response && error.response.data.errors) {
                    // Simple way to show first validation error
                    const errors = error.response.data.errors;
                    // Get the first error message from the validation response
                    this.message = Object.values(errors).flat()[0] || 'An error occurred during creation.';
                } else {
                    this.message = 'Error creating category. Please check the console.';
                    console.error('API Error:', error);
                }
                this.isSuccess = false; // Keep flag as false for error state
            }
        }
    }
};
</script>

<template>
    <div class="category-form-container">
        <h5>➕ Create New Category</h5>
        
        <form @submit.prevent="createCategory">
            <div class="form-group">
                <label for="title">Category Title:</label>
                <input 
                    type="text" 
                    id="title" 
                    class="form-control"
                    v-model="form.title" 
                    required
                />
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea 
                    id="description" 
                    class="form-control"
                    v-model="form.description"
                ></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    Save Category
                </button>
            </div>
        </form>

        <div v-if="message" :class="{'alert-success': isSuccess, 'alert-danger': !isSuccess}" class="alert mt-3">
            {{ message }}
        </div>
    </div>
</template>

<style scoped>
/* Add some basic styling for clarity */
.category-form-container {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
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
    box-sizing: border-box; /* Important for padding not to expand the element width */
}

.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
}

.btn-success {
    background-color: #28a745;
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