<template>
  <div class="filter-section">
    <div class="search-box">
      <input
        :value="searchQuery"
        @input="$emit('update:searchQuery', $event.target.value)"
        type="text"
        placeholder="Rechercher..."
      />
    </div>

    <div class="filter-actions">
      <select
        :value="filterSentiment"
        @change="$emit('update:filterSentiment', $event.target.value)"
        class="sentiment-select"
      >
        <option value="all">Tous les sentiments</option>
        <option value="positive">Positifs</option>
        <option value="neutre">Neutres</option>
        <option value="negative">Négatifs</option>
      </select>
    </div>
  </div>
</template>

<script setup>
defineProps(['searchQuery', 'filterSentiment']);
defineEmits(['update:searchQuery', 'update:filterSentiment']);
</script>