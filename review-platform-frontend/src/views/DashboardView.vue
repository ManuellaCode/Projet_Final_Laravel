<template>
  <div class="dashboard-container">
    <div class="top-status-bar">
      <div class="system-health">
        <span class="pulse-dot"></span>
        <span class="status-text">En ligne</span>
      </div>
      <button class="btn-logout" @click="handleLogout">
        <div class="logout-icon-wrapper">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        </div>
        <span class="logout-text">Se déconnecter</span>
      </button>
    </div>

    <header class="dashboard-header">
      <div class="header-content">
        <h1>Tableau de <span>bord</span></h1>
        <p>Analyse automatique de la satisfaction client</p>
      </div>
      <button class="btn-new-review" @click="$router.push('/reviews/new')">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Saisir un avis
      </button>
    </header>

    <div class="stats-grid">
      <StatCard label="Note Moyenne" footer="Basé sur les derniers avis" :hasIcon="true">
        <template #icon>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        </template>
        <template #value>4.0 <small>/ 5</small></template>
      </StatCard>

      <div class="stat-card-wrapper">
        <SentimentBar :sentiments="sentimentStats" />
      </div>

      <StatCard label="Thèmes Détectés">
        <div class="topic-tags">
          <span class="topic-tag"># Service</span>
          <span class="topic-tag"># Food</span>
          <span class="topic-tag empty">Analyse en cours...</span>
        </div>
      </StatCard>

      <div class="stat-card reviews-feed">
        <div class="flex-between mb-15">
          <h3>Dernières activités</h3>
          <button @click="$router.push('/reviews')" class="btn-link">Tout voir →</button>
        </div>
        <div class="feed-list">
          <ActivityFeed 
            name="ADJO Dila" sentimentClass="pos" sentimentLabel="Positif"
            content="je suis venu hier c'était great" time="Il y a 2 min" 
          />
          <ActivityFeed 
            name="ADJO Dila" sentimentClass="neg" sentimentLabel="Négatif"
            content="mauvais" time="Il y a 1 heure" 
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import StatCard from '../components/Dashboard/StatCard.vue'
import SentimentBar from '../components/Dashboard/SentimentBar.vue'
import ActivityFeed from '../components/Dashboard/ActivityFeed.vue'

const router = useRouter()
const handleLogout = () => router.push('/')

const sentimentStats = [
  { label: 'Positif', value: 41.7, class: 'pos' },
  { label: 'Négatif', value: 41.7, class: 'neg' }
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.dashboard-container { max-width: 1300px; margin: 0 auto; padding: 10px 40px; background-color: #f8fafc; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
.top-status-bar { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; margin-bottom: 15px; }
.system-health { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; color: #94a3b8; background: white; padding: 6px 14px; border-radius: 100px; }
.btn-logout { display: flex; align-items: center; gap: 12px; background: white; border: 1px solid #e2e8f0; padding: 4px 4px 4px 16px; border-radius: 100px; cursor: pointer; transition: 0.3s; }
.logout-text { font-size: 0.85rem; font-weight: 700; color: #64748b; }
.logout-icon-wrapper { width: 28px; height: 28px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; }
.btn-logout:hover { border-color: #fecaca; background: #fff1f2; }
.btn-logout:hover .logout-text { color: #ef4444; }
.btn-logout:hover .logout-icon-wrapper { background: #ef4444; color: white; }

.dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
h1 { font-size: 2.2rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -1px; }
h1 span { color: #bc6c25; }
.header-content p { color: #64748b; margin-top: 5px; font-size: 1.05rem; }

.btn-new-review { background: #1e293b; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: 0.3s; }
.btn-new-review:hover { background: #bc6c25; transform: translateY(-2px); }

.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.stat-card-wrapper { background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; }
.reviews-feed { grid-column: span 3; background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; }
.feed-list { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.flex-between { display: flex; justify-content: space-between; align-items: center; }
.mb-15 { margin-bottom: 15px; }
.mb-15 h3 { font-size: 1.05rem; font-weight: 800; color: #1e293b; margin: 0; }

.topic-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.topic-tag { background: #f8fafc; border: 1px solid #e2e8f0; padding: 6px 14px; border-radius: 8px; font-weight: 700; color: #1e293b; font-size: 0.85rem; }
.topic-tag.empty { opacity: 0.4; border-style: dashed; }
.btn-link { background: none; border: none; color: #bc6c25; font-weight: 700; cursor: pointer; font-size: 0.9rem; }

.pulse-dot { width: 7px; height: 7px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite; }
@keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
</style>