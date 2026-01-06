<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { getRepository } from '@/lib/http'
import type { Repository } from '@/types/repository'

const route = useRoute()

const loading = ref(true)
const error = ref<string | null>(null)
const repository = ref<Repository | null>(null)

onMounted(async () => {
  const owner = String(route.params.owner)
  const repo = String(route.params.repo)

  try {
    loading.value = true
    error.value = null

    repository.value = await getRepository(owner, repo)
  } catch (e: unknown) {
    if (e instanceof Error) {
      error.value = e.message
    } else {
      error.value = 'Error loading repository details'
    }
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-gray-100 font-sans">
    <div class="max-w-6xl mx-auto px-6 py-12">
      <!-- Back -->
      <RouterLink
        to="/repositories"
        class="inline-flex items-center text-sm text-gray-400 hover:text-indigo-400 mb-6"
      >
        ← Back to search
      </RouterLink>

      <!-- Loading -->
      <div v-if="loading" class="text-gray-400 animate-pulse">Loading repository details…</div>

      <!-- Error -->
      <div
        v-else-if="error"
        class="rounded-lg border border-red-700 bg-red-900/20 p-6 text-red-300"
      >
        {{ error }}
      </div>

      <!-- Content -->
      <div v-else-if="repository" class="rounded-lg border border-gray-800 bg-gray-900 p-8">
        <!-- Header -->
        <div class="mb-6">
          <h1 class="text-2xl font-semibold">
            {{ repository.full_name }}
          </h1>

          <p class="text-gray-400 mt-2">
            {{ repository.description || 'No description provided.' }}
          </p>
        </div>

        <!-- Stats -->
        <div class="flex flex-wrap gap-6 text-sm text-gray-300">
          <!-- Stars -->
          <div class="flex items-center gap-2">
            <svg
              class="w-4 h-4 text-yellow-400 relative top-[-2px]"
              viewBox="0 0 16 16"
              aria-hidden="true"
            >
              <path
                d="M8 12.027 3.763 14.3l.81-4.73L1.146 6.2l4.75-.69L8 1.5l2.104 4.01 4.75.69-3.427 3.37.81 4.73L8 12.027Z"
                fill="currentColor"
              />
            </svg>
            <span class="font-medium">{{ repository.stars.toLocaleString() }}</span>
            <span class="text-gray-400">stars</span>
          </div>

          <!-- Forks -->
          <div class="flex items-center gap-2">
            <svg
              class="w-4 h-4 text-gray-400 relative top-[-1px]"
              viewBox="0 0 16 16"
              aria-hidden="true"
            >
              <path
                d="M5 5.372v.878c0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75v-.878a2.25 2.25 0 1 1 1.5 0v.878a2.25 2.25 0 0 1-2.25 2.25h-1.5v2.128a2.251 2.251 0 1 1-1.5 0V8.5h-1.5A2.25 2.25 0 0 1 3.5 6.25v-.878a2.25 2.25 0 1 1 1.5 0ZM5 3.25a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0Zm6.75.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm-3 8.75a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0Z"
                fill="currentColor"
              />
            </svg>
            <span class="font-medium">{{ repository.forks.toLocaleString() }}</span>
            <span class="text-gray-400">forks</span>
          </div>

          <!-- Language -->
          <div v-if="repository.language" class="flex items-center gap-2">
            <span
              class="inline-block w-3 h-3 rounded-full bg-indigo-400 relative top-[-1px]"
            ></span>
            <span class="font-medium">{{ repository.language }}</span>
          </div>

          <!-- Created -->
          <div class="flex items-center gap-2 text-gray-400">
            <svg class="w-4 h-4 relative top-[-1px]" viewBox="0 0 16 16" aria-hidden="true">
              <path
                d="M8 3.25a.75.75 0 0 1 .75.75v3.5h2a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75V4A.75.75 0 0 1 8 3.25Z"
                fill="currentColor"
              />
              <path
                d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm0-1.5A6.5 6.5 0 1 0 8 1.5a6.5 6.5 0 0 0 0 13Z"
                fill="currentColor"
              />
            </svg>
            <span>Created {{ new Date(repository.created_at).toLocaleDateString() }}</span>
          </div>

          <!-- Updated -->
          <div class="flex items-center gap-2 text-gray-400">
            <svg class="w-4 h-4 relative top-[-1px]" viewBox="0 0 16 16" aria-hidden="true">
              <path
                d="M8 3.25a.75.75 0 0 1 .75.75v3.5h2a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75V4A.75.75 0 0 1 8 3.25Z"
                fill="currentColor"
              />
              <path
                d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm0-1.5A6.5 6.5 0 1 0 8 1.5a6.5 6.5 0 0 0 0 13Z"
                fill="currentColor"
              />
            </svg>
            <span>Updated {{ new Date(repository.updated_at).toLocaleDateString() }}</span>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-8">
          <a
            :href="repository.html_url"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition-colors"
          >
            View on GitHub
            <svg class="w-4 h-4 rotate-90" viewBox="0 0 16 16" aria-hidden="true">
              <path
                d="M3.75 3.5a.75.75 0 0 1 .75-.75h7a.75.75 0 0 1 0 1.5H6.31l5.22 5.22a.75.75 0 1 1-1.06 1.06L5.25 5.31V10.5a.75.75 0 0 1-1.5 0v-7Z"
                fill="currentColor"
              />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
