<template>
  <main class="studio-card">
    <section class="studio-section">
      <label class="section-title">Comment était votre expérience ?</label>
      <div class="star-group">
        <button 
          v-for="star in 5" :key="star"
          @mouseenter="hoverStar = star"
          @mouseleave="hoverStar = 0"
          @click="reviewData.rating = star"
          :class="['star-trigger', { 'is-active': star <= (hoverStar || reviewData.rating) }]"
        >
          <svg viewBox="0 0 24 24" class="star-svg">
            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
          </svg>
        </button>
        <transition name="pop">
          <span class="rating-text" v-if="reviewData.rating">{{ getRatingLabel(reviewData.rating) }}</span>
        </transition>
      </div>
    </section>

    <section class="studio-section">
      <div class="label-row">
        <label class="section-title">Votre message ?</label>
        <span class="char-pill">{{ reviewData.content.length }} / 300</span>
      </div>
      <div class="editor-container" :class="sentimentClass">
        <textarea 
          v-model="reviewData.content"
          placeholder="Partagez votre expérience avec nous..."
          class="main-textarea"
        ></textarea>
      </div>
    </section>

    <button 
      class="submit-button" 
      :disabled="!reviewData.content || !reviewData.rating || isProcessing"
      @click="processSubmission"
    >
      <div v-if="!isProcessing" class="btn-content">
        <span>Envoyer mon avis</span>
      </div>
      <div v-else class="loader-dots"><span></span><span></span><span></span></div>
    </button>
  </main>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';

const reviewData = reactive({ content: "", rating: 0 });
const hoverStar = ref(0);
const isProcessing = ref(false);

const getRatingLabel = (n) => ["Médiocre", "Passable", "Correct", "Excellent", "Exceptionnel"][n-1];

const sentimentClass = computed(() => {
  const c = reviewData.content.toLowerCase();
  if (c.length < 5) return '';
  if (c.includes('great') || c.includes('bon') || c.includes('génial') || c.includes('top')) return 'is-positive';
  if (c.includes('cher') || c.includes('attente') || c.includes('mauvais') || c.includes('nul')) return 'is-negative';
  return 'is-neutral';
});

const processSubmission = () => {
  isProcessing.value = true;
  setTimeout(() => {
    isProcessing.value = false;
    alert("🚀 Avis envoyé !");
  }, 2000);
};
</script>

<style scoped>
.studio-card {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border-radius: 30px;
  padding: 40px;
  border: 1px solid white;
  box-shadow: 0 20px 40px rgba(0,0,0,0.04);
}
.studio-section { margin-bottom: 30px; text-align: left; }
.section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 20px; display: block; }

.star-group { display: flex; align-items: center; gap: 10px; }
.star-trigger { background: none; border: none; cursor: pointer; transition: 0.4s; }
.star-svg { width: 42px; height: 42px; fill: #e2e8f0; transition: all 0.3s ease; }
.star-trigger.is-active .star-svg { fill: #bc6c25; filter: drop-shadow(0 0 8px rgba(188, 108, 37, 0.4)); }
.rating-text { margin-left: 20px; font-weight: 800; color: #bc6c25; font-size: 1rem; background: #fff7ed; padding: 4px 12px; border-radius: 8px; }

.editor-container { background: white; border-radius: 20px; border: 2px solid #f1f5f9; transition: 0.4s; overflow: hidden; }
.is-positive { border-color: #10b981 !important; background: #f0fdf4; }
.is-negative { border-color: #ef4444 !important; background: #fef2f2; }
.main-textarea { width: 100%; min-height: 150px; padding: 20px; border: none; background: transparent; outline: none; font-size: 1.05rem; resize: none; }

.label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
.char-pill { font-size: 0.75rem; font-weight: 700; color: #94a3b8; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; }

.submit-button { width: 100%; padding: 18px; border-radius: 16px; border: none; background: #1e293b; color: white; font-weight: 800; cursor: pointer; transition: 0.3s; }
.submit-button:disabled { opacity: 0.3; cursor: not-allowed; }

.loader-dots { display: flex; gap: 4px; justify-content: center; }
.loader-dots span { width: 8px; height: 8px; background: white; border-radius: 50%; animation: dots 0.6s infinite alternate; }
@keyframes dots { from { opacity: 0.2; transform: translateY(0); } to { opacity: 1; transform: translateY(-4px); } }

.pop-enter-active { animation: pop-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
@keyframes pop-in { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>