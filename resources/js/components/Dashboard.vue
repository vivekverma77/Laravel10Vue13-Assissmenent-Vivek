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
                                <form @submit.prevent="addNewTask">
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
                                        <label class="invalid-feedback" v-if="errors.priority && errors.priority[0]">{{errors.priority && errors.priority[0]}}</label>
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
                        
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>ID</th>
                              <th>Task </th>
                              <th>Priority</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                             <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td>{{ task.id }}</td>
                                    <td>{{ task.name }}</td>
                                    <td>{{ task.priority }}</td>
                                    <td><button class="btn btn-success btn-sm" @click="editTask">Edit</button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                             </tbody>   
                          </table>
                          <DeleteModal />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { storeToRefs } from "pinia";
import { allTasks } from '../http/task-api.js';
import DeleteModal  from "./modals/DeleteModal.vue"

import { useTaskStore } from "../store/task";
const store = useTaskStore()
const { handleAddedTask } = store
const { fetchAllTasks } = store
const tasks = ref([])
const modalPopup= ref(false)
const errors = ref({});
const successMessage = ref('');
const loader = ref(false)
const isEdit = ref(false)

onMounted(async () => {
    const { data } = await allTasks()
  // await fetchAllTasks()
    tasks.value = data.data
})


const formData = ref({
    name:'',
    priority:''
})

const OpenModal = () => {
    modalPopup.value = true;
}

const CloseModal = () => {
    modalPopup.value = false;
}

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

  }catch(error){
    if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
      loader.value = false; 
  }

}

const editTask = () => {
    isEdit.value = true;
    modalPopup.value = true;
}
</script>