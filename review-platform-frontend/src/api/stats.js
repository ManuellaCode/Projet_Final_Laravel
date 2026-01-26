import api from "./axios";

export function getStats() {
  return api.get("/dashboard"); // ou /stats selon backend
}
