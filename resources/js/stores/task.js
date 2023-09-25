import { ref, computed } from "vue";
import { defineStore } from "pinia";
import {
  allTasks,
  createTask,
  updateTask,
  completeTask,
  removeTask,
} from "../http/task-api";

export const useTaskStore = defineStore("taskStore", () => {
  const tasks = ref([]);

  const itemsPerPage = ref(5); // Number of items to display per page
  const currentPage = ref(1); // Current page number

  const uncompletedTasks = computed(() =>
    tasks.value.filter((task) => !task.is_completed)
  );

  const fetchAllTasks = async () => {
    const { data } = await allTasks();
    tasks.value = data.data;
  };

  const handleAddedTask = async (newTask) => {
    const { data: createdTask } = await createTask(newTask);
    tasks.value.unshift(createdTask.data);
  };

  const handleUpdatedTask = async (task) => {
    const { data: updatedTask } = await updateTask(task.id, {
      name: task.name,
      priority: task.priority,
      status: task.status,
      assigned_user_id : task.assigned_user_id,
      assigned_user_name : task.assigned_user_name,
    });
    const currentTask = tasks.value.find((item) => item.id === task.id);
    currentTask.name = updatedTask.data.name;
    currentTask.priority = updatedTask.data.priority;
    currentTask.status = updatedTask.data.status;
    currentTask.assigned_user_id = updatedTask.data.assigned_user_id;
    currentTask.assigned_user_name = updatedTask.data.assigned_user_name;
  };

  const handleCompletedTask = async (task) => {
    const { data: updatedTask } = await completeTask(task.id, {
      is_completed: task.is_completed,
    });
    const currentTask = tasks.value.find((item) => item.id === task.id);
    currentTask.is_completed = updatedTask.data.is_completed;
  };

  const handleRemovedTask = async (task_id) => {
    await removeTask(task_id);
    const index = tasks.value.findIndex((item) => item.id === task_id);
    tasks.value.splice(index, 1);
  };

  return {
    tasks,
    uncompletedTasks,
    fetchAllTasks,
    handleAddedTask,
    handleUpdatedTask,
    handleCompletedTask,
    handleRemovedTask,
  };
});
