<template>
  <div class="review-card">
    <div class="review-main">
      <div class="sentiment-indicator" :class="review.sentiment">
        <span class="dot"></span>
        <span class="label">{{ review.sentiment }}</span>
      </div>
      <p class="review-text">"{{ review.content }}"</p>

      <div class="topics-row" v-if="review.topics && review.topics.length">
        <span v-for="t in review.topics" :key="t" class="topic-pill">#{{ t }}</span>
      </div>
    </div>

    <div class="review-meta">
      <div class="score-badge">
        <span class="score-label">Fiabilité IA</span>
        <span class="score-value">{{ review.score }}%</span>
      </div>

      <div class="btn-group">
        <button class="btn-action" @click="$emit('show-details', review)">
          <span>Détails</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
        </button>
        <button class="btn-delete-icon" @click="$emit('delete-review', review.id)">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ review: Object });
</script>
