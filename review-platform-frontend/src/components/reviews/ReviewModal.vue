<template>
  <div class="modal-backdrop" @click.self="$emit('close')">
    <div class="modal-window">
      <div class="modal-header">
        <h3>Fiche détaillée de l'avis</h3>
        <button @click="$emit('close')" class="close-x">&times;</button>
      </div>
      <div class="modal-body">
        <div class="info-group highlight-box">
          <span class="info-label">Date de publication</span>
          <div class="date-display">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span>{{ formatDate(review.created_at) }}</span>
          </div>
        </div>

        <div class="info-group">
          <span class="info-label">Auteur (User ID)</span>
          <p>{{ review.user_id }}</p>
        </div>

        <div class="info-group">
          <span class="info-label">Commentaire client</span>
          <p class="full-text">"{{ review.content }}"</p>
        </div>

        <div class="info-group">
          <span class="info-label">Analyse automatique</span>
          <div class="modal-stats">
            <div class="stat-pill">Sentiment: {{ review.sentiment }}</div>
            <div class="stat-pill">Score: {{ review.score }}%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
const props = defineProps({ review: Object });

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('fr-FR', {
    day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
  });
};
</script>
