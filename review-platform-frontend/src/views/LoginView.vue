<template>
  <div class="admin-auth-container">
    <div class="viewport-bg"></div>
    <div class="viewport-overlay"></div>

    <main class="auth-card">
      <header class="auth-header">
        <div class="logo-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="logo-svg">
            <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 9.18 0A4 4 0 0 1 18 13.87V19a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-5.13Z" />
            <line x1="6" y1="16" x2="18" y2="16" />
            <path d="M20 3l-1 2.5L16.5 6.5 19 7.5l1 2.5 1-2.5 2.5-1L21 6.5 20 3z" fill="white" stroke="none" />
          </svg>
        </div>
        <h1>Bienvenue sur <span>RestoMind</span></h1>
        <p class="subtitle">Connectez-vous !</p>
      </header>

      <LoginForm :isLoading="isLoading" @login="handleLogin" />
    </main>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import LoginForm from "../components/LoginForm.vue";
import { login } from "../api/auth";

const isLoading = ref(false);
const router = useRouter();

const handleLogin = async (credentials) => {
  isLoading.value = true;
  
  try {
    // Appel de l'api pour se connecter
    const response = await login(credentials);
    
    const token = response.data.token || response.data.access_token;
    localStorage.setItem("token", token);

    //Redirection
    router.push("/dashboard");

  } catch (error) {
    // En cas d'erreur (401, 404, 500...), on affiche le message du back
    console.error("Erreur API:", error.response?.data);
    const errorMsg = error.response?.data?.message || "Identifiants invalides";
    alert(errorMsg);
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.admin-auth-container {
  position: fixed; inset: 0; display: flex; align-items: center; justify-content: center;
  font-family: 'Plus Jakarta Sans', sans-serif; background: #000;
}
.viewport-bg {
  position: absolute; inset: 0; z-index: 1;
  background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=2000');
  background-size: cover; background-position: center;
}
.viewport-overlay {
  position: absolute; inset: 0; z-index: 2;
  background: radial-gradient(circle at center, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.9) 100%);
  backdrop-filter: blur(12px);
}
.auth-card {
  position: relative; z-index: 3; width: 100%; max-width: 420px;
  background: rgba(255, 255, 255, 0.98); border-radius: 24px; padding: 50px 40px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.3);
}
.auth-header { text-align: center; margin-bottom: 40px; }
.logo-box {
  background: linear-gradient(135deg, #bc6c25, #dda15e);
  width: 50px; height: 50px; border-radius: 14px; margin: 0 auto 20px;
  display: flex; align-items: center; justify-content: center;
}
.logo-svg { width: 28px; height: 28px; }
h1 { font-size: 22px; font-weight: 800; color: #1e293b; margin: 0; }
h1 span { color: #bc6c25; }
.subtitle { color: #64748b; font-size: 16px; margin-top: 8px; }
</style>