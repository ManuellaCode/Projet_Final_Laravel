import api from './axios'; 

export const statsService = {
    getDashboardStats() {
        return api.get('/dashboard/stats');
    }
};