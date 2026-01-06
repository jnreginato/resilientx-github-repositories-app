<script setup lang="ts">
import { ref } from 'vue'
import { useRepositoriesStore } from '@/stores/repositories'

const store = useRepositoriesStore()
const localQuery = ref(store.query)

/**
 * Submits the current search query after validating input criteria.
 *
 * This method checks if the localQuery value is not empty and meets the
 * minimum length requirement. If valid, it updates the query in the store and
 * resets the current page to the first page before initiating a search.
 */
function submit(): void {
  if (!localQuery.value || localQuery.value.trim().length < 2) {
    return
  }

  store.query = localQuery.value.trim()
  store.meta.current_page = 1
  store.search(1)
}
</script>

<template>
  <div class="mb-8">
    <div class="flex items-center gap-3">
      <input
        v-model="localQuery"
        type="text"
        placeholder="Search GitHub repositories…"
        class="flex-1 px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600"
      />

      <button
        @click="submit"
        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition-colors disabled:opacity-50"
      >
        Search
      </button>
    </div>

    <p class="text-sm text-gray-400 mt-2">Enter at least 2 characters to search repositories.</p>
  </div>
</template>
