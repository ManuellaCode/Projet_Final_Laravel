<template>
  <div class="star-group">
    <button 
      v-for="star in 5" 
      :key="star"
      type="button"
      @mouseenter="hoverStar = star"
      @mouseleave="hoverStar = 0"
      @click="$emit('update:rating', star)"
      :class="['star-trigger', { 'is-active': star <= (hoverStar || rating) }]"
    >
      <svg viewBox="0 0 24 24" class="star-svg">
        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
      </svg>
    </button>
    <transition name="pop">
      <span class="rating-text" v-if="rating">{{ getRatingLabel(rating) }}</span>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue';
defineProps(['rating']);
defineEmits(['update:rating']);
const hoverStar = ref(0);
const getRatingLabel = (n) => ["Médiocre", "Passable", "Correct", "Excellent", "Exceptionnel"][n-1];
</script>

<style scoped>
.star-group { display: flex; align-items: center; gap: 10px; }
.star-trigger { background: none; border: none; cursor: pointer; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); padding: 0; }
.star-trigger:hover { transform: scale(1.2) rotate(5deg); }
.star-svg { width: 42px; height: 42px; fill: #e2e8f0; transition: all 0.3s ease; }
.star-trigger.is-active .star-svg { fill: #bc6c25; filter: drop-shadow(0 0 8px rgba(188, 108, 37, 0.4)); }
.rating-text { margin-left: 20px; font-weight: 800; color: #bc6c25; font-size: 1rem; background: #fff7ed; padding: 4px 12px; border-radius: 8px; }

.pop-enter-active { animation: pop-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
@keyframes pop-in { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>