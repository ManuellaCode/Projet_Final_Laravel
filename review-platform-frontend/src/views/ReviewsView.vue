<template>
  <div class="list-container">
    <header class="view-header">
      <div class="title-group">
        <h1>Journal des avis</h1>
        <p>{{ filteredReviews.length }} retours clients enregistrés</p>
      </div>
      <button class="btn-primary" @click="$router.push('/reviews/new')">
        + Nouvel Avis
      </button>
    </header>

    <!-- Filtres -->
    <ReviewFilters
      v-model:searchQuery="searchQuery"
      v-model:filterSentiment="filterSentiment"
    />

    <!-- Liste des avis -->
    <ReviewList
      :reviews="filteredReviews"
      @show-details="showDetails"
      @delete-review="deleteReview"
    />

    <!-- Modale -->
    <ReviewModal
      v-if="selectedReview"
      :review="selectedReview"
      @close="selectedReview = null"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ReviewFilters from '../components/reviews/ReviewFilters.vue';
import ReviewList from '../components/reviews/ReviewList.vue';
import ReviewModal from '../components/reviews/ReviewModal.vue';

const searchQuery = ref('');
const filterSentiment = ref('all');
const selectedReview = ref(null);

const reviews = ref([
  { id: 1, user_id: 42, content: "Une expérience culinaire exceptionnelle, le service était parfait.", sentiment: "positive", score: 98, topics: ['service', 'cuisine'], created_at: "2026-01-19T10:00:00Z" },
  { id: 2, user_id: 12, content: "Le temps d'attente était beaucoup trop long pour un mardi soir.", sentiment: "negative", score: 85, topics: ['attente'], created_at: "2026-01-18T14:30:00Z" },
  { id: 3, user_id: 8, content: "Plats corrects mais la musique était un peu forte.", sentiment: "neutral", score: 72, topics: ['ambiance'], created_at: "2026-01-17T21:15:00Z" },
]);

const filteredReviews = computed(() => {
  return reviews.value.filter(r => {
    const matchText = r.content.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchSentiment = filterSentiment.value === 'all' || r.sentiment === filterSentiment.value;
    return matchText && matchSentiment;
  });
});

const showDetails = (review) => { selectedReview.value = review; };

const deleteReview = (id) => {
  if(confirm("Confirmer la suppression ?")) {
    reviews.value = reviews.value.filter(r => r.id !== id); 
  }
};
</script>
