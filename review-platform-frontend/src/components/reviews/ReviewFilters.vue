<template>
  <div class="filter-section">
    <div class="search-box">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="search-icon">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>

      <input
        :value="searchQuery"
        @input="onSearchInput"
        type="text"
        placeholder="Rechercher par mot-clé..."
      />
    </div>

    <div class="filter-actions">
      <select
        :value="filterSentiment"
        @change="onSentimentChange"
        class="sentiment-select"
      >
        <option value="all">Tous les sentiments</option>
        <option value="positive">Positifs</option>
        <option value="neutral">Neutres</option>
        <option value="negative">Négatifs</option>
      </select>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  searchQuery: String,
  filterSentiment: String
})

const emit = defineEmits([
  'update:searchQuery',
  'update:filterSentiment'
])

const onSearchInput = (event) => {
  emit('update:searchQuery', event.target.value)
}

const onSentimentChange = (event) => {
  emit('update:filterSentiment', event.target.value)
}
</script>
