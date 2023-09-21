<template>
    <div v-if="taskPopup" id="taskModal" class="modal fade show" tabindex="-1"  style="display:block" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form @submit.prevent="isEdit ? updateTaskData() : addNewTask()">
            <div class="modal-header">
                <h5 class="modal-title" v-if="isEdit">Edit Task</h5>
                <h5 class="modal-title" v-else>Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeTaskModal"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeTaskModal">Close</button>
                <button type="submit" class="btn btn-primary" :disabled="loader">Save changes</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { storeToRefs } from "pinia";

const props = defineProps({
    taskPopup: Boolean,
    isEdit:Boolean
});

const emit = defineEmits(["open-task-modal","close-task-modal"]);

const openTaskModal = () => {
  emit("open-task-modal");
};

const closeTaskModal = () => {
  emit("close-task-modal");
};

const formData = ref({
  name: "",
  priority: "high",
  status: "Pending",
});
const loader = ref(false);
const errors = ref({});
</script>
  