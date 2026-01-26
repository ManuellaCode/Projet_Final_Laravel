<template>
  <div class="studio-header">
    <div class="status-badge">
      <span class="pulse-dot"></span>
      <span class="ai-text">Donner Votre avis</span>
    </div>
  </div>
</template>

<style scoped>
.studio-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding: 0 10px;
}
.status-badge {
  background: white;
  padding: 6px 14px;
  border-radius: 100px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.75rem;
  font-weight: 800;
  color: #1e293b;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
.ai-text { text-transform: uppercase; letter-spacing: 0.5px; color: #bc6c25; }
.pulse-dot { 
  width: 6px; height: 6px; background: #bc6c25; 
  border-radius: 50%; animation: pulse 2s infinite; 
}

@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(188, 108, 37, 0.4); }
  70% { box-shadow: 0 0 0 8px rgba(188, 108, 37, 0); }
  100% { box-shadow: 0 0 0 0 rgba(188, 108, 37, 0); }
}
</style>