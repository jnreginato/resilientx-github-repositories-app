import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import RepositoriesPage from '@/pages/RepositoriesPage.vue'
import RepositoryDetail from '@/pages/RepositoryDetail.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/repositories',
  },
  {
    path: '/repositories',
    name: 'search',
    component: RepositoriesPage,
    meta: { title: 'ResilientX - Search Repositories' },
  },
  {
    path: '/repositories/:owner/:repo',
    name: 'repository-detail',
    component: RepositoryDetail,
    meta: { title: 'ResilientX - Repository Detail' },
    props: true,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.afterEach((to) => {
  if (to.meta?.title) {
    document.title = String(to.meta.title)
  }
})

export default router
