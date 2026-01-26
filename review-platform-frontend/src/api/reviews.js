import api from './axios';

export const reviewService = {
    getReviews() {
        return api.get('/reviews');
    },
    createReview(content, rating) {
        return api.post('/reviews', { content, rating });
    },
    deleteReview(id) {
        return api.delete(`/reviews/${id}`);
    }
};