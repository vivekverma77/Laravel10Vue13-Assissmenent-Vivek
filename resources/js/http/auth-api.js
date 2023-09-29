import api from "./api";

export const csrfCookie = () => api.get("/sanctum/csrf-cookie");

export const login = (credentials) => api.post("/api/auth/login", credentials);

export const register = (user) => api.post("/api/auth/register", user);

export const logout = () => api.post("/api/auth/logout");

export const forgotPassword = (user) => api.post("/auth/forget-password",user);

export const getUser = () => api.get("/api/user");