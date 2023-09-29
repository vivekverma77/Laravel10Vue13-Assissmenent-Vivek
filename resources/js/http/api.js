import axios from "axios";
axios.defaults.withCredentials = true;

// Set the Authorization header with a token (if available)
export const setToken = (token) => {
  if (token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  } else {
    // If there is no token, remove the Authorization header
    delete axios.defaults.headers.common["Authorization"];
  }
};

const api = axios.create({
  baseURL: import.meta.env.VITE_BASE_URL,
});

export default api;
