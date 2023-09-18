<template>
    <div v-if="DeletePopup" id="deleteTaskModal" class="modal fade show" tabindex="-1"  style="display:block" aria-modal="true">        
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure want to delete this task ?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button type="button" class="btn btn-primary">Yes</button>
            </div>
          </div>
        </div>
      </div>
</template>