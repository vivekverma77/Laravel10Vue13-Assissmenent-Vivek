<template>
  <div>
    <table id="task_table" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Task</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Assigned User</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="filteredTasks.length" v-for="task in filteredTasks" :key="task.id">
          <td>{{ task.name }}</td>
          <td>
            <span v-if="task.priority == 'low'" class="badge bg-success"
              >Low priority</span
            >
            <span v-if="task.priority == 'high'" class="badge bg-danger"
              >High priority</span
            >
            <span v-if="task.priority == 'middle'" class="badge bg-warning"
              >Middle priority</span
            >
          </td>
          <td>{{ task.status }}</td>
          <td>
            <span v-if="task.assigned_user_name">
              <img
                src="https://cdn.pixabay.com/photo/2016/11/18/23/38/child-1837375_1280.png"
                class="img avatar"
                style="width: 25px"
              />
              {{ task.assigned_user_name }}
            </span>
            <span v-else>-</span>
          </td>
          <td>
            <button class="btn btn-primary btn-sm" @click="taskEdit(task.id)">
              Edit</button
            >&nbsp;&nbsp;
            <button
              class="btn btn-danger btn-sm"
              @click="showDeleteModal(task.id)"
            >
              Delete
            </button>
          </td>
        </tr>
        <tr v-else><td colspan="5" class="text-center"><span class=" alert-info">No {{selectedStatus != 'All' ? selectedStatus.toLowerCase() : '' }} task available</span></td></tr>
      </tbody>
    </table>
    <div class="pagination mt-3 d-block" v-if="totalPages">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
        </li>
        <li
          class="page-item"
          v-for="page in totalPages"
          :key="page"
          :class="{ active: currentPage === page }"
        >
          <a class="page-link" href="#" @click.prevent="gotoPage(page)">{{
            page
          }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
        </li>
      </ul>
    </div>
  </div>
</template>
  
<script setup>
import { defineProps,toRefs  } from "vue";

const props = defineProps({
  filteredTasks: Array,
  currentPage: Number,
  totalPages: Number,
  selectedStatus:String,
  prevPage: Function,
  nextPage: Function,
  gotoPage: Function,
});

const {filteredTasks, currentPage, totalPages, prevPage, nextPage, gotoPage } = toRefs(props);

const emit = defineEmits(['show-delete-modal','task-edit'])

const taskEdit = (id) => {
  emit('task-edit',id)
};

const showDeleteModal = (id) => {
  emit('show-delete-modal',id)
};
</script>