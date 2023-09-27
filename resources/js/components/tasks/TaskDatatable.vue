<template>
    <DataTable :data="tableTasks" class="display"  ref="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
    </DataTable>
</template>
<script setup>
//Datatable
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
DataTable.use(DataTablesCore);

let dt;
const table = ref();

const columns = [
  { data: 'ID' },
  { data: 'Task' },
  { data: 'Priority' },
  { data: 'Actions', orderable: false, searchable: false, },
];

import { defineProps,toRefs,ref, computed  } from "vue";

const props = defineProps({
  tasks: Array,
  tableTasks:Array,
  tableTasks:Function
});

const { tasks } = toRefs(props);

const tableTasks = computed(() => {
  let tableData = [];
    tasks.value.forEach((task) => {
      tableData.push([
        task.id, 
        task.name, 
        task.priority,
        `<button class="btn btn-success btn-sm" @click="taskEdit(${task.id})">Edit</button> 
        <button class="btn btn-danger btn-sm" @click="taskDelete(${task.id})">Delete</button>`,
      ]);
    });
    // Initialize the DataTable
    return tableData;
  });

const emit = defineEmits(['show-delete-modal','task-edit'])

const taskEdit = (id) => {
  alert();
 // emit('task-edit',id)
};

const showDeleteModal = (id) => {
  emit('show-delete-modal',id)
};



</script>
<style>
@import 'bootstrap';
@import 'datatables.net-dt';
</style>
