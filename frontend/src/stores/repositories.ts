import {defineStore} from 'pinia';
import {ref} from 'vue';
import {searchRepositories} from '@/lib/http';
import type {Paginated, PaginationMeta, Repository} from '@/types/repository';

export const useRepositoriesStore = defineStore('repositories', () => {
  const loading = ref(false);
  const error = ref<string | null>(null);
  const repositories = ref<Repository[]>([]);
  const query = ref('');

  const meta = ref<PaginationMeta>({
    count: 0,
    current_page: 1,
    per_page: 10,
    total_pages: 1,
    total_items: 0,
  });

  /**
   * Executes a search for repositories based on the current query and pagination parameters.
   * Updates the repositories and metadata, and handles loading and error states.
   *
   * @param {number} [page] - The page number to fetch (optional). If not provided, the current page from metadata is used.
   * @return {Promise<void>} Resolves when the search operation is complete.
   */
  async function search(page?: number): Promise<void> {
    if (!query.value) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const resp = (await searchRepositories({
        query: query.value,
        page: page ?? meta.value.current_page,
        perPage: meta.value.per_page,
      })) as Paginated<Repository>;

      repositories.value = resp.data;
      meta.value = resp.metadata;
    } catch (e: unknown) {
      if (e instanceof Error) {
        error.value = e.message;
      } else {
        error.value = 'Error loading repositories. Try again later.';
      }
    } finally {
      loading.value = false;
    }
  }

  /**
   * Navigates to the specified page of content if the page number is within the valid range.
   * Updates the current page in the metadata and triggers a search for the specified page.
   *
   * @param {number} page - The page number to navigate to.
   * Must be greater than or equal to 1 and less than or equal to the total number of pages.
   */
  async function goToPage(page: number) {
    if (page < 1 || page > meta.value.total_pages) {
      return;
    }
    meta.value.current_page = page;
    await search(page);
  }

  return {
    loading,
    error,
    query,
    repositories,
    meta,
    search,
    goToPage,
  };
});
