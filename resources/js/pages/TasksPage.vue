<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div v-if="successMessage" class="alert alert-success" role="alert">
                    {{successMessage}}
                </div>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Tasks List</h3>
                    </div>
                    <div class="card-body">
                        <!-- Add Task Button -->
                        <button class="btn btn-secondary mb-3"  @click="OpenModal()">Add Task</button>
                        <div v-if="modalPopup" id="taskModal" class="modal fade show" tabindex="-1"  style="display:block" aria-modal="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <form @submit.prevent="isEdit ? updateTaskData() : addNewTask()">
                                <div class="modal-header">
                                  <h5 class="modal-title" v-if="isEdit">Edit Task</h5>
                                  <h5 class="modal-title" v-else>Add New Task</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="CloseModal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="task-text" class="col-form-label">Task:</label>
                                        <textarea class="form-control" :class="{'is-invalid' : errors.name && errors.name[0]}" id="task-text" v-model="formData.name"></textarea>
                                        <label class="invalid-feedback" v-if="errors.name && errors.name[0]">{{ errors.name && errors.name[0] }}</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="task-priority" class="col-form-label">Priority:</label>
                                        <select class="form-control" v-model="formData.priority" :class="{'is-invalid' : errors.priority && errors.priority[0]}">
                                            <option value="high">High priority</option>
                                            <option value="low">Low priority</option>
                                            <option value="middle">Middle priority</option>
                                        </select>
                                        <label class="invalid-feedback" v-if="errors.priority && errors.priority[0]">{{ errors.priority && errors.priority[0] }}</label>
                                    </div>
                                    <div class="mb-3">
                                      <label for="task-status" class="col-form-label">Status:</label>
                                      <select class="form-control" v-model="formData.status">
                                          <option value="Pending">Pending</option>
                                          <option value="In-Progress">In-Progress</option>
                                          <option value="Completed">Completed</option>
                                      </select>
                      
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="CloseModal">Close</button>
                                  <button type="submit" class="btn btn-primary" :disabled="loader">Save changes</button>
                                </div>
                               </form>
                              </div>
                            </div>
                          </div>
                        
                           <!-- ... Your existing template ... -->
                        <div class="btn-group ml-5 d-flex">
                            <button class="btn btn-primary" @click="filterTasks('All')" :class="selectedStatus === 'All' ? 'active' : ''">All</button>
                            <button class="btn btn-primary" @click="filterTasks('Pending')" :class="selectedStatus === 'Pending' ? 'active' : ''">Pending</button>
                            <button class="btn btn-primary" @click="filterTasks('In-Progress')" :class="selectedStatus === 'In-Progress' ? 'active' : ''">In Progress</button>
                            <button class="btn btn-primary" @click="filterTasks('Completed')" :class="selectedStatus === 'Completed' ? 'active' : ''">Completed</button>
                        </div>
                        <!-- Search input field -->
                        <div class="mb-3 mt-3">
                          <label for="search" class="form-label">Search:</label>
                          <input
                            type="text"
                            class="form-control"
                            id="search"
                            v-model="searchQuery"
                            @input="filterTasksBySearch"
                            style="width:250px"/>
                        </div>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Task </th>
                              <th>Priority</th>
                              <th>Status</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                             <tbody>
                                <tr v-for="task in filteredTasks" :key="task.id">
                                    <td>{{ task.id }}</td>
                                    <td>{{ task.name }}</td>
                                    <td>
                                      <span v-if="task.priority == 'low'" class="badge bg-success">Low priority</span>
                                      <span v-if="task.priority == 'high'" class="badge bg-danger">High priority</span>
                                      <span v-if="task.priority == 'middle'" class="badge bg-warning">Middle priority</span>
                                    </td>
                                    <td>{{ task.status }}</td>
                                    <td><button class="btn btn-primary btn-sm" @click="taskEdit(task.id)">Edit</button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm" @click="taskDelete(task.id)">Delete</button></td>
                                </tr>
                             </tbody>   
                          </table>
                          <div class="pagination mt-3 d-block">
                            <ul class="pagination justify-content-center">
                                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
                                </li>
                                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                                    <a class="page-link" href="#" @click.prevent="gotoPage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                    <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                                </li>
                            </ul>
                        </div>
                        
                          <div v-if="deletePopup" id="deleteTaskModal" class="modal fade show" tabindex="-1"  style="display:block" aria-modal="true">        
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Delete Task</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="hideDeleteModal"></button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure want to delete this task ?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="hideDeleteModal">No</button>
                                  <button type="button" class="btn btn-primary" @click="confirmDelete">Yes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { storeToRefs } from "pinia";
import { allTasks, editTask, removeTask, updateTask, tasksByStatus, tasksBySearch } from '../http/task-api.js';
import DeleteModal  from "../components/modals/DeleteModal.vue"
import { useTaskStore } from "../stores/task";
const store = useTaskStore()
const { handleAddedTask } = store
const { fetchAllTasks } = store
const { handleUpdatedTask } = store
const tasks = ref([])

const modalPopup= ref(false)
const errors = ref({});
const successMessage = ref('');
const loader = ref(false)

const isEdit = ref(false)
const taskId = ref('');

const deletePopup = ref(false);
const deleteTaskId = ref('')

// Get all tasks
onMounted(async () => {
    const { data } = await allTasks()
 //  await fetchAllTasks()
    tasks.value = data.data
})


const formData = ref({
    name:'',
    priority:'',
    status:''
})

const OpenModal = () => {
    modalPopup.value = true;
    formData.value.name = '';   
    formData.value.priority = 'high';  
    formData.value.status = 'Pending';
}

const CloseModal = () => {
    modalPopup.value = false;
}

// Add new task
const addNewTask = async() => {
  //  console.log('Form submitted:', formData.value);
  try
  {
      loader.value = true;  
      await handleAddedTask(formData.value)
      modalPopup.value = false;
      successMessage.value =  'Task added successfully';
      loader.value = false;
      formData.value.name = '';   
      formData.value.priority = '';  
      formData.value.status = '';  
      const { data } = await allTasks()
      tasks.value = data.data
  }catch(error){
    if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
      loader.value = false; 
  }

}

// Update Task
const updateTaskData = async() => {
   // console.log('Form submitted:', formData.value);
  try
  {
      loader.value = true;  
      await handleUpdatedTask(formData.value)
      modalPopup.value = false;
      successMessage.value =  'Task updated successfully';
      loader.value = false;
      formData.value.name = '';   
      formData.value.priority = '';
      loader.value = false;
      const { data } = await allTasks()
      tasks.value = data.data   

  }catch(error){
    if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
      loader.value = false; 
  }

}

// Edit the task
const taskEdit =  async(id) => {
    errors.value = '';
    isEdit.value = true;
    modalPopup.value = true;
    const { data } = await editTask(id)
    formData.value = data.data
}

// Delete the task
const taskDelete = (id) => {
    deletePopup.value = true;
    deleteTaskId.value = id;
}

// Function to hide the modal
const hideDeleteModal = () => {
    deletePopup.value = false;
    deleteTaskId.value = '';
    
  };

const confirmDelete = async() => {
    await removeTask(deleteTaskId.value);
    deletePopup.value = false;
    const { data } = await allTasks()
    tasks.value = data.data
}


// Fiter tasks
const selectedStatus = ref('All'); // To store the selected status
const filterTasks = async (status) => {
    selectedStatus.value = status;
    if(status === 'All'){
      const { data } = await allTasks()
      tasks.value = data.data
    }else{
      const { data } = await tasksByStatus(status)
      tasks.value = data.data
    }
};

// Search task
const searchQuery = ref('');

// Filter tasks by search query
const filterTasksBySearch = async() => {
  const query = searchQuery.value.toLowerCase();
  if(query == ''){
      const { data } = await allTasks()
      tasks.value = data.data
    }else{
      const { data } = await tasksBySearch({search:query})
      tasks.value = data.data
    }
};

// Pagingnation
const itemsPerPage = ref(5); // Number of items to display per page
const currentPage = ref(1); // Current page number

const filteredTasks = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return tasks.value.slice(startIndex, endIndex);
});

const totalPages = computed(() => Math.ceil(tasks.value.length / itemsPerPage.value));

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const gotoPage = (page) => {
    currentPage.value = page;
};
</script>