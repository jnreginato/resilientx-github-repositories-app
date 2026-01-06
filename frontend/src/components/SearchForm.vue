<script setup lang="ts">
import { ref } from 'vue';

const query = ref('');
const emit = defineEmits<{
  (e: 'search', query: string): void;
}>();

function submit() {
  if (query.value.trim().length >= 2) {
    emit('search', query.value.trim());
  }
}
</script>

<template>
  <form @submit.prevent="submit" class="flex gap-2">
    <input
      v-model="query"
      type="text"
      placeholder="Search repositories..."
      class="flex-1 border rounded px-3 py-2"
    />
    <button
      type="submit"
      class="bg-blue-600 text-white px-4 py-2 rounded"
    >
      Search
    </button>
  </form>
</template>
