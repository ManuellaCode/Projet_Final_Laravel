import api from "./axios";

export function login(data) {
  return api.post("/login", data);
}

export function register(data) {
  return api.post("/register", data);
}
