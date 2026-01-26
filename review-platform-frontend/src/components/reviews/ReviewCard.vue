<template>
  <div class="review-card">
    <div class="review-main">
      <div class="sentiment-indicator" :class="review.sentiment || 'neutre'">
        <span class="dot"></span>
        <span class="label">{{ review.sentiment || 'neutre' }}</span>
      </div>
      <p class="review-text">"{{ review.content }}"</p>

      <div class="topics-row" v-if="review.topics && review.topics.length">
        <span v-for="t in review.topics" :key="t" class="topic-pill">#{{ t }}</span>
      </div>
    </div>

    <div class="review-meta">
      <div class="score-badge">
        <span class="score-value">{{ review.score || 0 }}%</span>
      </div>

      <div class="btn-group">
        <button class="btn-action" @click="$emit('show-details', review)">Détails</button>
        <button class="btn-delete-icon" @click="$emit('delete-review', review.id)">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M3 6h18"></path>
    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
  </svg>
</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ review: Object });
defineEmits(['show-details', 'delete-review']);
</script>

<style scoped>
.btn-delete-icon {
  background: #fff5f5; 
  border: 1px solid #feb2b2;
  color: #f56565;
  padding: 8px;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
}

.btn-delete-icon:hover {
  background: #f56565;
  color: white;
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(245, 101, 101, 0.2);
}
</style>