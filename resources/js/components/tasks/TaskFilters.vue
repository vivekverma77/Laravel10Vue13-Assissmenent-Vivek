<template>
    <div class="btn-group ml-5 d-flex">
        <button class="btn btn-primary" @click="filterTasks('All')" :class="selectedStatus === 'All' ? 'active' : ''">All</button>
        <button class="btn btn-primary" @click="filterTasks('Pending')" :class="selectedStatus === 'Pending' ? 'active' : ''">Pending</button>
        <button class="btn btn-primary" @click="filterTasks('In-Progress')" :class="selectedStatus === 'In-Progress' ? 'active' : ''">In Progress</button>
        <button class="btn btn-primary" @click="filterTasks('Completed')" :class="selectedStatus === 'Completed' ? 'active' : ''">Completed</button>
    </div>
</template>
<script setup>
import { ref } from "vue";
const emit = defineEmits(['filter-tasks'])
const selectedStatus = ref('All'); // To store the selected status


const filterTasks = ($parm) => {
    selectedStatus.value = status;
    emit("filter-tasks",$parm);
}
</script>