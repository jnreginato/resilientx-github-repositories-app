<script setup lang="ts">
import RepositoryItem from './RepositoryItem.vue';

defineProps<{
  repositories: any[];
}>();
</script>

<template>
  <ul class="mt-6 space-y-3">
    <RepositoryItem
      v-for="repo in repositories"
      :key="repo.id"
      :repository="repo"
    />
  </ul>
</template>
