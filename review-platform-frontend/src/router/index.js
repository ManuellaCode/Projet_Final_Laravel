import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../views/LoginView.vue";
import DashboardView from "../views/DashboardView.vue";
import ReviewsView from "../views/ReviewsView.vue";
import CreateReviewView from "../views/CreateReviewView.vue";

const routes = [
  { 
    path: "/", 
    name: "login",
    component: LoginView 
  },
  { 
    path: "/dashboard", 
    name: "dashboard", 
    component: DashboardView 
  },
  { 
    path: "/reviews", 
    name: "reviews",
    component: ReviewsView 
  },
  { 
    path: "/reviews/new", 
    name: "create-review",
    component: CreateReviewView 
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;