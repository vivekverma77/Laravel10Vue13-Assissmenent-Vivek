<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div v-if="successMessage" class="alert alert-success" role="alert">
          {{ successMessage }}
        </div>
        <div class="card shadow-sm">
          <div class="card-header">
            <h3>Tasks List</h3>
          </div>
          <div class="card-body">
            <!-- Add Task Button -->
            <button class="btn btn-secondary mb-3" @click="openTaskModal()">
              Add Task
            </button>

            <!-- Include the TaskModal component -->
            <TaskModal
              :task-popup="taskPopup"
              :is-edit="isEdit"
              :loader="loader"
              :users="users"
              :formData="formData"
              :errors="errors"
              @close-task-modal="closeTaskModal"
            />

            <!-- ... Task Filter ... -->
            <TaskFilters @filter-tasks="filterTasks" />
            <!-- Search input field -->
            <div class="mb-3 mt-3">
              <label for="search" class="form-label">Search:</label>
              <input
                type="text"
                class="form-control"
                id="search"
                v-model="searchQuery"
                @input="filterTasksBySearch"
                style="width: 250px"
              />
            </div>
        
            <!-- Include the TaskTable component -->
            <TaskTable
              :filteredTasks="filteredTasks"
              :currentPage="currentPage"
              :totalPages="totalPages"
              :prevPage="prevPage"
              :nextPage="nextPage"
              :gotoPage="gotoPage"

              @show-delete-modal="showDeleteModal"
              @task-edit="taskEdit"
            />

            <!-- Delete Modal Component -->
            <DeleteModal
              :deletePopup="deletePopup"
              @hide-delete-modal="hideDeleteModal"
              @confirm-delete="confirmDelete"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import {
  editTask,
  tasksByStatus,
  tasksBySearch,
} from "../http/task-api.js";
import DeleteModal from "../components/modals/DeleteModal.vue";
import TaskModal from "../components/modals/TaskModal.vue";
import TaskFilters from "../components/tasks/TaskFilters.vue";
import TaskTable from "../components/tasks/TaskTable.vue";
import { useTaskStore } from "../stores/task";
const store = useTaskStore();
const { fetchAllTasks } = store;
const { handleRemovedTask } = store;
const tasks = ref([]);

const taskPopup = ref(false);
const errors = ref({});
const successMessage = ref("");
const loader = ref(false);

const isEdit = ref(false);
const taskId = ref("");

const deletePopup = ref(false);
const deleteTaskId = ref("");

//Get all users
import { useUserStore } from "../stores/user";
const userStore = useUserStore();
const { fetchAllUsers } = userStore;
const users = ref([]);

// Get all tasks
onMounted(async () => {
  await fetchAllTasks();
  tasks.value = store.tasks;
  await fetchAllUsers();
  users.value = userStore.users;
});

const formData = ref({
  name: "",
  priority: "",
  status: "",
  assigned_user_id: "",
});

const openTaskModal = () => {
  taskPopup.value = true;
  formData.value.name = "";
  formData.value.priority = "high";
  formData.value.status = "Pending";
};

const closeTaskModal = () => {
  taskPopup.value = false;
};

// Edit the task
const taskEdit = async (id) => {
  isEdit.value = true;
  taskPopup.value = true;
  const { data } = await editTask(id);
  formData.value = data.data;
};

// Function to Delete the task
const showDeleteModal = (id) => {
  deletePopup.value = true;
  deleteTaskId.value = id;
};

// Function to hide the modal
const hideDeleteModal = () => {
  deletePopup.value = false;
  deleteTaskId.value = "";
};

const confirmDelete = async () => {
  await handleRemovedTask(deleteTaskId.value);
  deletePopup.value = false;
  tasks.value = store.tasks;
};

// Filter tasks
const selectedStatus = ref("All"); // To store the selected status
const filterTasks = async (status) => {
  selectedStatus.value = status;
  if (status === "All") {
     tasks.value = store.tasks;
  } else {
    const { data } = await tasksByStatus(status);
    tasks.value = data.data;
  }
};

// Search task
const searchQuery = ref("");

// Filter tasks by search query
const filterTasksBySearch = async () => {
  const query = searchQuery.value.toLowerCase();
  if (query == "") {
    await fetchAllTasks();
    tasks.value = store.tasks;
  } else {
    const { data } = await tasksBySearch({ search: query });
    tasks.value = data.data;
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

const totalPages = computed(() =>
  Math.ceil(tasks.value.length / itemsPerPage.value)
);

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