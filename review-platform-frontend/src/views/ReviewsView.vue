<template>
  <div class="list-container">
    <header class="view-header">
      <div class="title-group">
        <h1>Journal des avis</h1>
        <p v-if="loading">Chargement des données...</p>
        <p v-else>{{ filteredReviews.length }} retours clients enregistrés</p>
      </div>
      <button class="btn-primary" @click="$router.push('/reviews/new')">
        + Nouvel Avis
      </button>
    </header>

    <ReviewFilters
      v-model:searchQuery="searchQuery"
      v-model:filterSentiment="filterSentiment"
    />

    <div v-if="loading" class="loading-state">Analyse en cours...</div>
    
    <ReviewList
      v-else
      :reviews="filteredReviews"
      @show-details="showDetails"
      @delete-review="askDeleteConfirmation"
    />

    <ReviewModal
      v-if="selectedReview"
      :review="selectedReview"
      @close="selectedReview = null"
    />

    <DeleteConfirm
      v-if="reviewIdToDelete"
      @cancel="reviewIdToDelete = null"
      @confirm="confirmDelete"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { reviewService } from '../api/reviews'; 
import ReviewFilters from '../components/reviews/ReviewFilters.vue';
import ReviewList from '../components/reviews/ReviewList.vue';
import ReviewModal from '../components/reviews/ReviewModal.vue';
import DeleteConfirm from '../components/reviews/DeleteConfirm.vue';

const searchQuery = ref('');
const filterSentiment = ref('all');
const selectedReview = ref(null);
const reviews = ref([]); 
const loading = ref(true);

// État pour la suppression
const reviewIdToDelete = ref(null);

// 1. Charger les avis
const fetchAllReviews = async () => {
  loading.value = true;
  try {
    const response = await reviewService.getReviews();
    reviews.value = response.data.data || response.data;
  } catch (error) {
    console.error("Erreur API :", error);
  } finally {
    loading.value = false;
  }
};

// 2. Filtrage + Tri (Les nouveaux en haut)
const filteredReviews = computed(() => {
  return [...reviews.value]
    .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
    .filter(r => {
      const content = (r.content || "").toLowerCase();
      const matchText = content.includes(searchQuery.value.toLowerCase());
      
      const s = r.sentiment === 'neutral' ? 'neutre' : (r.sentiment || 'neutre');
      const filter = filterSentiment.value === 'neutral' ? 'neutre' : filterSentiment.value;
      
      const matchSentiment = filter === 'all' || s === filter;
      return matchText && matchSentiment;
    });
});

const showDetails = (review) => { selectedReview.value = review; };

// 3. Logique de suppression avec modale
const askDeleteConfirmation = (id) => {
  reviewIdToDelete.value = id; 
};

const confirmDelete = async () => {
  if (!reviewIdToDelete.value) return;

  try {
    await reviewService.deleteReview(reviewIdToDelete.value);
    // Suppression
    reviews.value = reviews.value.filter(r => r.id !== reviewIdToDelete.value);
  } catch (err) {
    alert("Erreur lors de la suppression sur le serveur");
  } finally {
    reviewIdToDelete.value = null; // Ferme la modale
  }
};

onMounted(fetchAllReviews);
</script>