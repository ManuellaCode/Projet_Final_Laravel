<template>
  <div class="studio-wrapper">
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <div class="studio-container">
      <ReviewCreateHeader />
      <ReviewCreateForm />
    </div>
  </div>
</template>

<script setup>
import ReviewCreateHeader from '../components/ReviewCreate/ReviewCreateHeader.vue'
import ReviewCreateForm from '../components/ReviewCreate/ReviewCreateForm.vue'
</script>

<style scoped>
.studio-wrapper {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
  overflow: hidden;
  padding: 20px;
  font-family: 'Plus Jakarta Sans', sans-serif;
}

.bg-blob {
  position: absolute;
  width: 400px; height: 400px;
  background: linear-gradient(135deg, #bc6c25 0%, #dda15e 100%);
  filter: blur(80px); opacity: 0.1; border-radius: 50%; z-index: 0;
}
.blob-1 { top: -100px; right: -100px; animation: float 10s infinite alternate; }
.blob-2 { bottom: -100px; left: -100px; animation: float 15s infinite alternate-reverse; }

@keyframes float {
  from { transform: translate(0,0); }
  to { transform: translate(50px, 100px); }
}

.studio-container {
  width: 100%;
  max-width: 650px;
  position: relative;
  z-index: 1;
  animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(40px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>