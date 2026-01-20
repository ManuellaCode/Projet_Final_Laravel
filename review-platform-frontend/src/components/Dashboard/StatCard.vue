<template>
  <div class="stat-card">
    <div v-if="hasIcon" class="card-icon gold">
      <slot name="icon"></slot>
    </div>
    <div class="card-data">
      <span class="card-label">{{ label }}</span>
      <div class="card-value">
        <slot name="value"></slot>
      </div>
    </div>
    <div v-if="footer" class="card-footer">{{ footer }}</div>
    <slot></slot> </div>
</template>

<script setup>
defineProps({
  label: String,
  footer: String,
  hasIcon: Boolean
});
</script>

<style scoped>
.stat-card { background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 10px; }
.card-icon.gold { background: #fff7ed; color: #bc6c25; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.card-label { font-weight: 700; color: #64748b; text-transform: uppercase; font-size: 0.75rem; }
.card-value { font-size: 2.5rem; font-weight: 800; color: #1e293b; }
.card-footer { font-size: 0.8rem; color: #94a3b8; }
</style>