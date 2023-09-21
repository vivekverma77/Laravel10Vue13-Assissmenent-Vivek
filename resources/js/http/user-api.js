import api from "./api";

const apiPath = import.meta.env.VITE_API_PATH;
const resource = apiPath + "/users";

export const allUsers = () => api.get(resource)