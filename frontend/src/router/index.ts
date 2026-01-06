import { createRouter, createWebHistory } from 'vue-router';
import SearchView from '../views/SearchView.vue';
import RepositoryDetailView from '../views/RepositoryDetailView.vue';

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
