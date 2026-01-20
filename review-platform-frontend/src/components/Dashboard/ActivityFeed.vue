<template>
  <div class="feed-item">
    <div class="item-header">
      <span class="reviewer">{{ name }}</span>
      <span class="badge" :class="sentimentClass">{{ sentimentLabel }}</span>
    </div>
    <p>"{{ content }}"</p>
    <span class="item-time">{{ time }}</span>
  </div>
</template>

<script setup>
defineProps(['name', 'sentimentClass', 'sentimentLabel', 'content', 'time']);
</script>

<style scoped>
.feed-item { background: #f8fafc; padding: 15px; border-radius: 14px; border: 1px solid #f1f5f9; }
.item-header { display: flex; justify-content: space-between; margin-bottom: 8px; }
.reviewer { font-weight: 800; color: #1e293b; font-size: 0.95rem; }
.badge { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 5px; }
.badge.pos { background: #dcfce7; color: #166534; }
.badge.neg { background: #fee2e2; color: #991b1b; }
p { margin: 8px 0; color: #475569; font-style: italic; font-size: 0.9rem; }
.item-time { font-size: 0.7rem; color: #94a3b8; }
</style>