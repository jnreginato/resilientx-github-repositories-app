<script setup lang="ts">
defineProps<{
  repository: any;
}>();
</script>

<template>
  <li class="border rounded p-4">
    <router-link
      :to="`/repositories/${repository.owner}/${repository.name}`"
      class="text-blue-600 font-semibold"
    >
      {{ repository.full_name }}
    </router-link>

    <p class="text-sm text-gray-600">
      ⭐ {{ repository.stars }}
      <span v-if="repository.language">
        · {{ repository.language }}
      </span>
    </p>
  </li>
</template>
