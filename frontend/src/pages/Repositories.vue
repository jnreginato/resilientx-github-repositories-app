<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';
import SearchForm from '../components/SearchForm.vue';
import RepositoryList from '../components/RepositoryList.vue';

const repositories = ref<any[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

async function onSearch(query: string) {
  loading.value = true;
  error.value = null;

  try {
    const response = await api.get('/repositories', {
      params: { query },
    });

    repositories.value = response.data.data;
  } catch (e: any) {
    error.value = e.response?.data?.message ?? 'Unexpected error';
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">
      GitHub Repository Search
    </h1>

    <SearchForm @search="onSearch" />

    <p v-if="loading" class="mt-4">Loading...</p>
    <p v-if="error" class="mt-4 text-red-600">
      {{ error }}
    </p>

    <RepositoryList
      v-if="repositories.length"
      :repositories="repositories"
    />
  </div>
</template>
