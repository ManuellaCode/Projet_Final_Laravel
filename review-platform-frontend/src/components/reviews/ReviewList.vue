<template>
  <div class="review-list">
    <div v-if="reviews.length === 0" class="empty-state">
      Aucun avis trouvé pour votre recherche.
    </div>

    <!-- Liste des cartes -->
    <ReviewCard
      v-for="review in reviews"
      :key="review.id"
      :review="review"
      @show-details="$emit('show-details', $event)"
      @delete-review="onRequestDelete"
    />

    <!-- MODAL CONFIRMATION SUPPRESSION -->
    <DeleteConfirm
      v-if="reviewToDelete"
      @cancel="reviewToDelete = null"
      @confirm="deleteReview"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ReviewCard from './ReviewCard.vue';
import DeleteConfirm from './DeleteConfirm.vue';

const props = defineProps({
  reviews: Array
});

const reviewToDelete = ref(null);

// Quand l'utilisateur clique sur l'icône de suppression
const onRequestDelete = (review) => {
  reviewToDelete.value = review; // ouvre le modal
};

// Supprimer définitivement après confirmation
const deleteReview = () => {
  if (reviewToDelete.value) {
    const index = props.reviews.findIndex(r => r.id === reviewToDelete.value.id);
    if (index !== -1) props.reviews.splice(index, 1); // supprime l'avis
    reviewToDelete.value = null; // ferme le modal
  }
};
</script>
