<template>
  <div class="sentiment-analysis">
    <div class="card-header-simple">
      <h3>Répartition des sentiments</h3>
    </div>
    <div class="sentiment-bars">
      <div class="bar-item" v-for="s in sentiments" :key="s.label">
        <div class="bar-info">
          <span>{{ s.label }}</span>
          <span>{{ s.value }}%</span>
        </div>
        <div class="progress">
          <div class="fill" :class="s.class" :style="{ width: s.value + '%' }"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['sentiments']);
</script>

<style scoped>
.card-header-simple h3 { font-size: 1.05rem; font-weight: 800; margin-bottom: 15px; color: #1e293b; }
.bar-item { margin-bottom: 15px; }
.bar-info { display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #334155; }
.progress { height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden; }
.fill { height: 100%; border-radius: 10px; }
.fill.pos { background: #10b981; }
.fill.neg { background: #ef4444; }
</style>