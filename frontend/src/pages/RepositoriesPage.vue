<script setup lang="ts">
import SearchBar from '@/components/SearchBar.vue';
import RepositoriesTable from '@/components/RepositoriesTable.vue';
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="max-w-6xl mx-auto px-6 py-12">
      <SearchBar/>
      <RepositoriesTable/>
    </div>
  </div>
</template>
