import api from "./axios";

export function getReviews() {
  return api.get("/reviews");
}

export function createReview(data) {
  return api.post("/reviews", data);
}

export function updateReview(id, data) {
  return api.put(`/reviews/${id}`, data);
}

export function deleteReview(id) {
  return api.delete(`/reviews/${id}`);
}
