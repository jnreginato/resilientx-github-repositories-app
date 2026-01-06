<script setup>
import { onMounted, ref } from 'vue';
import api from '../services/api';
import { useRoute } from 'vue-router';

const route = useRoute();
const repository = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  try {
    const { owner, repo } = route.params;
    const response = await api.get(`/repositories/${owner}/${repo}`);
    repository.value = response.data.data;
  } catch (err) {
    error.value = err.response?.data?.message || 'Error loading repository';
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="max-w-4xl mx-auto p-6">
    <p v-if="loading">Loading...</p>
    <p v-if="error" class="text-red-600">{{ error }}</p>

    <div v-if="repository">
      <h1 class="text-2xl font-bold">{{ repository.full_name }}</h1>
      <p class="mt-2">{{ repository.description }}</p>

      <div class="mt-4 text-sm text-gray-600">
        ⭐ {{ repository.stars }} · 🍴 {{ repository.forks }} · {{ repository.language }}
      </div>

      <a
        :href="repository.html_url"
        target="_blank"
        class="inline-block mt-4 text-blue-600"
      >
        View on GitHub
      </a>
    </div>
  </div>
</template>
