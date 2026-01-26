<template>
  <div class="review-list">
    <div v-if="reviews.length === 0" class="empty-state">
      Aucun avis trouvé pour votre recherche.
    </div>

    <ReviewCard
      v-for="review in reviews"
      :key="review.id"
      :review="review"
      @show-details="$emit('show-details', $event)"
      @delete-review="$emit('delete-review', $event)"
    />
  </div>
</template>

<script setup>
import ReviewCard from './ReviewCard.vue';
const props = defineProps({ reviews: Array });
defineEmits(['show-details', 'delete-review']);
</script>