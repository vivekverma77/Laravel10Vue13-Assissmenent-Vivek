<template>
  <div>
    <div v-if="deletePopup" class="modal fade show" tabindex="-1" style="display: block" aria-modal="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="hideDeleteModal"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this task?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="hideDeleteModal">No</button>
            <button type="button" class="btn btn-primary" @click="confirmDelete">Yes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  deletePopup: Boolean,
  default:true
});

const emit = defineEmits(["hide-delete-modal", "confirm-delete"]);

const hideDeleteModal = () => {
  emit("hide-delete-modal");
};

const confirmDelete = () => {
  emit("confirm-delete");
};
</script>