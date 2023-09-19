import api from "./api";

const apiPath = import.meta.env.VITE_API_PATH;
const resource = apiPath + "/tasks";

export const allTasks = () => api.get(resource);

export const tasksByStatus = (status) => api.get(`${resource}/tasksByStatus/${status}`);

export const tasksBySearch = (search) => api.post(`${resource}/tasksBySearch`,search);

export const createTask = (task) => api.post(resource, task);

export const editTask = (id) => api.get(`${resource}/${id}`);

export const updateTask = (id, task) => api.put(`${resource}/${id}`, task);

export const removeTask = (id) => api.delete(`${resource}/${id}`);

export const completeTask = (id, task) =>
  api.patch(`${resource}/${id}/complete`, task);
