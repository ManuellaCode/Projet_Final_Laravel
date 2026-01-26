<template>
  <div class="app-layout">
    <aside v-if="showSidebar" class="sidebar">
      <div class="sidebar-logo">
        <div class="logo-box">
          <svg 
            viewBox="0 0 24 24" 
            fill="none" 
            stroke="white" 
            stroke-width="2" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            class="logo-svg"
          >
            <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 9.18 0A4 4 0 0 1 18 13.87V19a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-5.13Z" />
            <line x1="6" y1="16" x2="18" y2="16" />
            <path d="M20 3l-1 2.5L16.5 6.5 19 7.5l1 2.5 1-2.5 2.5-1L21 6.5 20 3z" fill="white" stroke="none" />
          </svg>
        </div>
        <h2 class="brand-name">Resto<span>Mind</span></h2>
      </div>
      
      <nav class="sidebar-links">
        <p class="nav-label">Menu Principal</p>
        
        <router-link to="/dashboard" class="nav-item">
          <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          <span>Dashboard</span>
        </router-link>
        
        <router-link to="/reviews" class="nav-item">
          <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          <span>Liste des avis</span>
        </router-link>
        
        <router-link to="/reviews/new" class="nav-item">
          <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          <span>Nouvel avis</span>
        </router-link>
      </nav>

      <div class="sidebar-footer">
        <button @click="logout" class="logout-btn">
          <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          <span>Déconnexion</span>
        </button>
      </div>
    </aside>

    <main :class="['main-content', { 'no-sidebar': !showSidebar }]">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import { computed } from "vue";

const route = useRoute();
const router = useRouter();
const showSidebar = computed(() => route.path !== "/");

const logout = () => router.push("/");
</script>

<style>
:root {
  --sidebar-width: 280px;
  --bg-dark: #0f172a;
  --bg-main: #f8fafc;
  --accent: #bc6c25;
  --nav-text: #94a3b8;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body { margin: 0; background: var(--bg-main); font-family: 'Plus Jakarta Sans', sans-serif; }

.app-layout { display: flex; min-height: 100vh; }

.sidebar {
  width: var(--sidebar-width);
  background: var(--bg-dark);
  color: white;
  display: flex;
  flex-direction: column;
  position: fixed;
  height: 100vh;
  padding: 2rem 1.25rem;
  z-index: 100;
  box-shadow: 10px 0 30px rgba(0,0,0,0.1);
}

.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 3.5rem;
  padding-left: 0.5rem;
}

.logo-box {
  background: linear-gradient(135deg, var(--accent), #dda15e);
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 16px rgba(188, 108, 37, 0.25);
}

.logo-svg { width: 24px; height: 24px; } 

.brand-name { 
  font-size: 1.5rem; 
  font-weight: 800; 
  letter-spacing: -0.03em; 
  margin: 0;
}

.brand-name span { color: var(--accent); }

.nav-label {
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #475569;
  margin-bottom: 1.25rem;
  padding-left: 0.75rem;
}

.sidebar-links { display: flex; flex-direction: column; gap: 0.6rem; flex: 1; }

.nav-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 16px;
  color: var(--nav-text);
  text-decoration: none;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  transition: var(--transition);
  position: relative;
}

.nav-icon { width: 20px; height: 20px; transition: var(--transition); }

.nav-item:hover {
  background: rgba(255, 255, 255, 0.04);
  color: white;
  transform: translateX(4px);
}

.router-link-active {
  background: rgba(188, 108, 37, 0.12) !important;
  color: white !important;
}

.router-link-active .nav-icon {
  color: var(--accent);
  filter: drop-shadow(0 0 8px rgba(188, 108, 37, 0.4));
}

.router-link-active::after {
  content: '';
  position: absolute;
  right: 12px;
  width: 6px;
  height: 6px;
  background: var(--accent);
  border-radius: 50%;
}

.sidebar-footer {
  margin-top: auto;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 12px;
  background: transparent;
  border: 1px solid #334155;
  color: var(--nav-text);
  padding: 12px;
  width: 100%;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 600;
  transition: var(--transition);
}

.logout-btn:hover {
  background: #ef4444;
  border-color: #ef4444;
  color: white;
  box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
}

.main-content {
  flex: 1;
  margin-left: var(--sidebar-width);
  padding: 2.5rem;
  transition: var(--transition);
}

.main-content.no-sidebar { margin-left: 0; padding: 0; }
</style>