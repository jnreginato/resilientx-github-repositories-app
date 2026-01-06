<script setup lang="ts">
import {onMounted} from 'vue';
import {RouterLink} from 'vue-router';
import {useRepositoriesStore} from '@/stores/repositories';
import PaginationControls from "@/components/PaginationControls.vue";

const store = useRepositoriesStore();

onMounted(() => {
  // If a query has already been persisted (e.g., refresh)
  if (store.query) {
    store.search();
  }
});
</script>

<template>
  <!-- Loading -->
  <div v-if="store.loading" class="text-gray-400 animate-pulse">
    Loading repositories…
  </div>

  <!-- Error -->
  <div v-else-if="store.error" class="text-red-400 font-medium">
    {{ store.error }}
  </div>

  <!-- Empty -->
  <div
    v-else-if="!store.repositories.length"
    class="rounded-lg border border-gray-700 p-10 text-center
           text-gray-400 italic"
  >
    No repositories found.
  </div>

  <!-- Table -->
  <div v-else>
    <div class="overflow-hidden rounded-lg border border-gray-800">
      <table class="min-w-full divide-y divide-gray-800 text-sm">
        <thead class="text-gray-400 uppercase text-xs tracking-wider">
        <tr>
          <th class="px-4 py-3 text-left font-medium">Repository</th>
          <th class="px-4 py-3 text-left font-medium">Language</th>
          <th class="px-4 py-3 text-right font-medium">Stars</th>
        </tr>
        </thead>

        <tbody class="divide-y divide-gray-800 text-gray-200">
        <tr
          v-for="repo in store.repositories"
          :key="repo.id"
          class="hover:bg-gray-800/60 transition-colors"
        >
          <td class="px-4 py-4">
            <RouterLink
              :to="`/repositories/${repo.owner}/${repo.name}`"
              class="text-indigo-400 hover:underline font-medium"
            >
              {{ repo.full_name }}
            </RouterLink>
          </td>

          <td class="px-4 py-4">
            {{ repo.language ?? '—' }}
          </td>

          <td class="px-4 py-4 text-right ">
            <span class="relative top-[-1px]">⭐</span> {{ repo.stars.toLocaleString() }}
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <PaginationControls
      :meta="store.meta"
      @change-page="store.goToPage"
    />
  </div>
</template>
