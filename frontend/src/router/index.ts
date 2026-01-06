import { createRouter, createWebHistory } from 'vue-router';
import SearchView from '@/pages/Repositories.vue';
import RepositoryDetailView from '@/pages/RepositoryDetail.vue';

const routes = [
  {
    path: '/',
    name: 'search',
    component: SearchView,
  },
  {
    path: '/repositories/:owner/:repo',
    name: 'repository-detail',
    component: RepositoryDetailView,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
