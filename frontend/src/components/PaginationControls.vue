<script setup lang="ts">
import {computed} from 'vue';

/**
 * Represents metadata related to pagination.
 *
 * This interface provides information about the current state of pagination,
 * such as the current page number and the total number of pages available.
 */
interface PaginationMeta {
  current_page: number;
  total_pages: number;
}

const props = defineProps<{
  meta: PaginationMeta;
}>();

const emit = defineEmits<{
  (e: 'change-page', page: number): void;
}>();

const delta = 2;

const pages = computed<(number | 'ellipsis')[]>(() => {
  const pages: (number | 'ellipsis')[] = [];
  const {current_page, total_pages} = props.meta;

  if (total_pages <= 1) return pages;

  const rangeStart = Math.max(2, current_page - delta);
  const rangeEnd = Math.min(total_pages - 1, current_page + delta);

  pages.push(1);

  if (rangeStart > 2) {
    pages.push('ellipsis');
  }

  for (let i = rangeStart; i <= rangeEnd; i++) {
    pages.push(i);
  }

  if (rangeEnd < total_pages - 1) {
    pages.push('ellipsis');
  }

  if (total_pages > 1) {
    pages.push(total_pages);
  }

  return pages;
});

/**
 * Navigates to the specified page if it is different from the current page.
 *
 * @param {number} page - The page number to navigate to.
 */
function goTo(page: number): void {
  if (page === props.meta.current_page) return;
  emit('change-page', page);
}

</script>

<template>
  <div
    v-if="meta.total_pages > 1"
    class="flex flex-wrap items-center justify-center gap-2 mt-6"
  >
    <!-- Previous -->
    <button
      class="px-3 py-1 text-sm rounded-lg border border-gray-700 hover:bg-gray-800 disabled:opacity-40"
      :disabled="meta.current_page === 1"
      @click="goTo(meta.current_page - 1)"
    >
      ‹
    </button>

    <!-- Pages -->
    <template v-for="(item, index) in pages" :key="index">
      <span
        v-if="item === 'ellipsis'"
        class="px-2 text-gray-500 select-none"
      >
        …
      </span>

      <button
        v-else
        @click="goTo(item)"
        class="px-3 py-1 text-sm rounded-lg border transition-colors"
        :class="item === meta.current_page
          ? 'bg-indigo-600 border-indigo-600 text-white'
          : 'border-gray-700 hover:bg-gray-800'"
      >
        {{ item }}
      </button>
    </template>

    <!-- Next -->
    <button
      class="px-3 py-1 text-sm rounded-lg border border-gray-700 hover:bg-gray-800 disabled:opacity-40"
      :disabled="meta.current_page === meta.total_pages"
      @click="goTo(meta.current_page + 1)"
    >
      ›
    </button>
  </div>
</template>
