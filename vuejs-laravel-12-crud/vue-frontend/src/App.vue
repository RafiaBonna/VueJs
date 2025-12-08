<script>
import axios from "axios";
import CategoryForm from "./CategoryForm.vue"; 
// 1. Import the new Edit component (we will create this next)
import CategoryEditForm from "./CategoryEditForm.vue"; 

export default {
    components: {
        CategoryForm,
        CategoryEditForm // 2. Register the Edit component
    },
    data() {
        return {
            tasks: [], 
            // 3. New state variables for editing
            isEditing: false,
            editingCategory: null, 
        };
    },

    mounted() {
        this.getCategory();
    },

    methods: {
        getCategory() {
            axios.get('http://127.0.0.1:8000/api/category')
                .then((res) => {
                    this.tasks = res.data.data
                })
                .catch((error) => {
                    console.error('Error fetching categories:', error);
                });
        },

        async deleteCategory(id) {
            if (!confirm('Are you sure you want to delete this category?')) {
                return;
            }

            try {
                const response = await axios.delete(`http://127.0.0.1:8000/api/category/${id}`);

                alert(response.data.message || 'Category deleted successfully!');
                
                this.getCategory();

            } catch (error) {
                alert('Error deleting category. Please check the console.');
                console.error('Deletion Error:', error);
            }
        },

        // --- NEW METHOD FOR EDITING ---
        editCategory(category) {
            this.isEditing = true;
            // Create a deep copy of the category to avoid modifying the list data directly
            this.editingCategory = { ...category }; 
        },

        // --- NEW METHOD TO HANDLE CANCEL/COMPLETE ---
        updateComplete() {
            this.isEditing = false;
            this.editingCategory = null;
            // Refresh the list to show the updated data
            this.getCategory(); 
        }
    },
};
</script>

<template>
<div>
    <h2>Vue + Laravel API CRUD</h2>

    <div v-if="isEditing">
        <CategoryEditForm 
            :category="editingCategory" 
            @update-completed="updateComplete"
            @cancel-edit="updateComplete" 
        />
    </div>
    <div v-else>
        <CategoryForm @category-created="getCategory" />
    </div>

    <br>
    <br>
    <h2>📋 Existing Categories</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Category Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody v-for="(d, i) in tasks" :key="i">
            <tr>
                <td scope="row">{{ i + 1 }}</td>
                <td>{{ d.title }}</td>
                <td>{{ d.description }}</td>
                <td width="150px">
                    <button class="btn btn-primary" @click="editCategory(d)">Edit</button>
                    <button class="btn btn-danger" @click="deleteCategory(d.id)">Delete</button>
                </td>
            </tr>

        </tbody>
    </table>
</div>
</template>

<style scoped>
/* ... your styles ... */
/* NOTE: The styles from the previous message should be present here. */
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
.table th {
    background-color: #f2f2f2;
}

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
    margin-left: 5px;
}

.btn-primary {
    background-color: #007bff;
}

.btn-danger {
    background-color: #dc3545;
}
</style>