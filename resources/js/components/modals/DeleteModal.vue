<template>
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
</template>
<script setup>
import { ref } from "vue";

const deletePopup = ref(true);

const hideDeleteModal = () => {
  deletePopup.value = false;
}

// Delete the task
const taskDelete = (id) => {
    deletePopup.value = true;
    deleteTaskId.value = id;
}

defineExpose({
  taskDelete,
  deletePopup,
  hideDeleteModal,
})
</script>