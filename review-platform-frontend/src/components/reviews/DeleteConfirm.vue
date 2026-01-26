<template>
  <div class="modal-backdrop" @click.self="close">
    <div class="modal-window">
      <div class="modal-header">
        <h3>Confirmer la suppression</h3>
        <button @click="close" class="close-x">&times;</button>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer cet avis ?</p>
      </div>
      <div class="modal-footer">
        <button class="btn-cancel" @click="close">Annuler</button>
        <button class="btn-delete" @click="confirmDelete">Supprimer</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits } from 'vue';
const emit = defineEmits(['cancel', 'confirm']);

const close = () => emit('cancel');
const confirmDelete = () => emit('confirm');
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(8px);
  display: flex; align-items: center; justify-content: center;
  z-index: 1000;
}

.modal-window {
  background: white; width: 400px;
  border-radius: 20px; padding: 1.5rem;
  display: flex; flex-direction: column;
}

.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.close-x { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; }

.modal-body { margin-bottom: 1.5rem; }
.modal-footer { display: flex; justify-content: flex-end; gap: 12px; }

.btn-cancel { background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; cursor: pointer; }
.btn-delete { background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; }
</style>
