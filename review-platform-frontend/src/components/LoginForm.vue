<template>
  <form @submit.prevent="handleSubmit" class="auth-form">
    <div class="field-wrapper">
      <label for="email">Identifiant</label>
      <div class="input-group">
        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <input 
          type="email" 
          v-model="email" 
          id="email" 
          placeholder="....@email.com"
          required 
        />
      </div>
    </div>

    <div class="field-wrapper">
      <label for="password">Mot de passe</label>
      <div class="input-group">
        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <input 
          :type="passwordVisible ? 'text' : 'password'" 
          v-model="password" 
          id="password" 
          placeholder="••••••••"
          class="password-input"
          required 
        />
        <button 
          type="button" 
          class="visibility-toggle" 
          @click="passwordVisible = !passwordVisible"
          tabindex="-1"
        >
          <svg v-if="!passwordVisible" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
        </button>
      </div>
    </div>

    <button type="submit" :disabled="isLoading" class="submit-button">
      <span v-if="!isLoading">Se connecter</span>
      <div v-else class="loader-dots"></div>
    </button>
  </form>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  isLoading: Boolean
});

const emit = defineEmits(['login']);

const email = ref("");
const password = ref("");
const passwordVisible = ref(false);

const handleSubmit = () => {
  emit('login', { email: email.value, password: password.value });
};
</script>

<style scoped>
.auth-form { width: 100%; }
.field-wrapper { margin-bottom: 24px; text-align: left; }
label { display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }

.input-group { position: relative; display: flex; align-items: center; }
.input-icon { position: absolute; left: 14px; width: 18px; height: 18px; color: #94a3b8; pointer-events: none; }

input {
  width: 100%; height: 52px; padding: 0 12px 0 44px;
  background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px;
  font-size: 15px; color: #1e293b; transition: all 0.3s ease;
}
input:focus { outline: none; border-color: #bc6c25; background: white; box-shadow: 0 0 0 4px rgba(188, 108, 37, 0.1); }

.visibility-toggle {
  position: absolute; right: 8px; background: none; border: none; color: #94a3b8;
  cursor: pointer; padding: 8px; border-radius: 8px; display: flex; align-items: center;
}
.visibility-toggle:hover { color: #bc6c25; background: rgba(188, 108, 37, 0.05); }

.submit-button {
  width: 100%; height: 54px; background: #1e293b; color: white;
  border: none; border-radius: 12px; font-size: 16px; font-weight: 700;
  cursor: pointer; transition: all 0.3s; margin-top: 10px;
}
.submit-button:hover:not(:disabled) { background: #bc6c25; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(188, 108, 37, 0.2); }


.loader-dots {
  width: 40px; height: 10px; margin: 0 auto;
  background: radial-gradient(circle closest-side, currentColor 90%, #0000) 0% 50%,
              radial-gradient(circle closest-side, currentColor 90%, #0000) 50% 50%,
              radial-gradient(circle closest-side, currentColor 90%, #0000) 100% 50%;
  background-size: calc(100%/3) 100%; background-repeat: no-repeat;
  animation: dots 1s infinite linear;
}
@keyframes dots {
    33% { background-size: calc(100%/3) 0%, calc(100%/3) 100%, calc(100%/3) 100% }
    50% { background-size: calc(100%/3) 100%, calc(100%/3) 0%, calc(100%/3) 100% }
    66% { background-size: calc(100%/3) 100%, calc(100%/3) 100%, calc(100%/3) 0% }
}
</style>