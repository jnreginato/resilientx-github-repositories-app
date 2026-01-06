import {Paginated, Repository} from "@/types/repository";

const BASE_URL = import.meta.env.VITE_API_BASE_URL ?? '';

/**
 * Searches for repositories based on the specified query and optional pagination parameters.
 *
 * @param {Object} params - Parameters for searching repositories.
 * @param {string} params.query - The search query to find repositories.
 * @param {number} [params.page] - The page number for paginated results (optional).
 * @param {number} [params.perPage] - The number of results per page (optional).
 * @return {Promise<Paginated<Repository>>} A promise that resolves with the search results as a JSON object.
 * @throws {Error} If the request fails or the response is not OK.
 */
export async function searchRepositories(params: {
  query: string;
  page?: number;
  perPage?: number;
}): Promise<Paginated<Repository>> {
  const qs = new URLSearchParams();

  qs.set('query', params.query);

  if (params.page) {
    qs.set('page', String(params.page));
  }

  if (params.perPage) {
    qs.set('per_page', String(params.perPage));
  }

  const res = await fetch(`${BASE_URL}/api/repositories?${qs}`, {
    headers: {Accept: 'application/json'},
  });

  if (!res.ok) {
    const body = await res.json().catch(() => null);
    throw new Error(body?.message ?? 'Error loading repositories');
  }

  return await res.json() as Promise<Paginated<Repository>>;
}

/**
 * Fetches repository data for the specified owner and repository name.
 *
 * @param {string} owner - The owner of the repository.
 * @param {string} repo - The name of the repository.
 * @return {Promise<Repository>} A promise that resolves to the repository data.
 * @throws {Error} If the request fails or the response is invalid.
 */
export async function getRepository(owner: string, repo: string): Promise<Repository> {
  const res = await fetch(
    `${BASE_URL}/api/repositories/${owner}/${repo}`,
    {headers: {Accept: 'application/json'}}
  );

  if (!res.ok) {
    const body = await res.json().catch(() => null);
    throw new Error(body?.message ?? 'Error loading repository');
  }

  return await res.json() as Promise<Repository>;
}
