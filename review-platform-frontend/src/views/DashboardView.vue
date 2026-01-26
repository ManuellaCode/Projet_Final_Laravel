<template>
  <div class="dashboard-container">
    <div class="top-status-bar">
      <div class="system-health">
        <span class="pulse-dot"></span>
        <span class="status-text">{{ loading ? 'Synchronisation...' : 'En ligne' }}</span>
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

    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>Calcul des statistiques IA en cours...</p>
    </div>

    <div v-else class="stats-grid">
      
      <StatCard label="Score Moyen" footer="Note de satisfaction globale" :hasIcon="true">
        <template #icon>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        </template>
        <template #value>{{ stats.average_score || 0 }} <small>/ 100</small></template>
      </StatCard>

      <div class="stat-card-wrapper">
        <SentimentBar :sentiments="formattedSentiments" />
      </div>

      <StatCard label="Thèmes Détectés">
        <div class="topic-tags">
          <span v-for="topic in stats.top_topics" :key="topic" class="topic-tag">
            # {{ topic }}
          </span>
          <span v-if="!stats.top_topics || stats.top_topics.length === 0" class="topic-tag empty">
            Aucun thème récurrent
          </span>
        </div>
      </StatCard>

      <div class="stat-card reviews-feed">
        <div class="flex-between mb-15">
          <h3>Dernières activités</h3>
          <button @click="$router.push('/reviews')" class="btn-link">Tout voir →</button>
        </div>
        <div class="feed-list">
          <ActivityFeed 
            v-for="review in stats.recent_reviews" 
            :key="review.id"
            :name="review.user?.name || 'Utilisateur'" 
            :sentimentClass="getSentimentClass(review.sentiment)" 
            :sentimentLabel="translateSentiment(review.sentiment)"
            :content="review.content" 
            :time="formatDate(review.created_at)" 
          />
          <div v-if="stats.recent_reviews.length === 0" class="empty-feed">
            Aucun avis enregistré pour le moment.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { statsService } from '../api/stats'
import StatCard from '../components/Dashboard/StatCard.vue'
import SentimentBar from '../components/Dashboard/SentimentBar.vue'
import ActivityFeed from '../components/Dashboard/ActivityFeed.vue'

const router = useRouter()
const loading = ref(true)

// Initialisation des stats 
const stats = ref({
  positive: 0,
  negative: 0,
  neutral: 0,
  average_score: 0,
  top_topics: [],
  recent_reviews: []
})

// Récupération des données via l'API
const fetchStats = async () => {
  loading.value = true
  try {
    const response = await statsService.getDashboardStats()
    stats.value = response.data
  } catch (error) {
    console.error("Erreur lors de la récupération des stats:", error)
  } finally {
    loading.value = false
  }
}

// Formatage des données pour le composant SentimentBar
const formattedSentiments = computed(() => [
  { label: 'Positifs', value: stats.value.positive || 0, class: 'pos' },
  { label: 'Neutres', value: stats.value.neutral || 0, class: 'neu' },
  { label: 'Négatifs', value: stats.value.negative || 0, class: 'neg' }
])

// Utilitaires de formatage
const getSentimentClass = (sentiment) => {
  if (sentiment === 'positive') return 'pos'
  if (sentiment === 'negative') return 'neg'
  return 'neu'
}

const translateSentiment = (sentiment) => {
  const map = { 'positive': 'Positif', 'negative': 'Négatif', 'neutral': 'Neutre' }
  return map[sentiment] || 'Neutre'
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return `Il y a ${Math.floor((new Date() - date) / (1000 * 60 * 60))}h`
}

const handleLogout = () => {
  localStorage.removeItem('token')
  router.push('/')
}

onMounted(fetchStats)
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.dashboard-container { max-width: 1300px; margin: 0 auto; padding: 10px 40px; background-color: #f8fafc; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
.top-status-bar { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; margin-bottom: 15px; }

.system-health { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; color: #94a3b8; background: white; padding: 6px 14px; border-radius: 100px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }

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

.btn-new-review { background: #1e293b; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }
.btn-new-review:hover { background: #bc6c25; transform: translateY(-2px); }

.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.stat-card-wrapper { background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; }
.reviews-feed { grid-column: span 3; background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; }
.feed-list { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

.loading-state { grid-column: span 3; padding: 100px; text-align: center; color: #64748b; font-weight: 600; }
.topic-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.topic-tag { background: #fef3c7; border: 1px solid #fde68a; padding: 6px 14px; border-radius: 8px; font-weight: 700; color: #92400e; font-size: 0.85rem; }
.topic-tag.empty { opacity: 0.5; background: #f1f5f9; color: #64748b; border-style: dashed; }

.flex-between { display: flex; justify-content: space-between; align-items: center; }
.mb-15 { margin-bottom: 15px; }
.mb-15 h3 { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin: 0; }
.btn-link { background: none; border: none; color: #bc6c25; font-weight: 700; cursor: pointer; font-size: 0.9rem; }

.pulse-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; position: relative; }
.pulse-dot::after { content: ''; position: absolute; width: 100%; height: 100%; background: #10b981; border-radius: 50%; animation: pulse 2s infinite; }

@keyframes pulse { 0% { transform: scale(1); opacity: 0.8; } 100% { transform: scale(3); opacity: 0; } }

@media (max-width: 1024px) {
  .stats-grid { grid-template-columns: 1fr; }
  .reviews-feed { grid-column: span 1; }
  .feed-list { grid-template-columns: 1fr; }
}
</style>