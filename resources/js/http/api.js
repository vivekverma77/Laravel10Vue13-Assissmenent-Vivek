import axios from "axios";
axios.defaults.withCredentials = true;
const csrfCookie = '21|zCQ5YrmSkW1BGfByyZorkTxs4x2nHHEopktmWDg49372b73d';
axios.defaults.headers.common['Authorization'] = `Bearer ${csrfCookie}` 

export const api = axios.create({
    baseURL: import.meta.env.VITE_BASE_URL,
});

export default api;

