/**
 * Represents a software repository.
 *
 * @interface Repository
 * @property {number} id The unique identifier for the repository.
 * @property {string} name The name of the repository.
 * @property {string} full_name The full name of the repository, including the owner's name.
 * @property {string} owner The owner of the repository.
 * @property {string|null} description A brief description of the repository, or null if not provided.
 * @property {number} stars The number of stars the repository has.
 * @property {number} forks The number of times the repository has been forked.
 * @property {string|null} language The primary programming language used in the repository, or null if unspecified.
 * @property {string} html_url The web URL for accessing the repository.
 * @property {string} created_at The ISO 8601 formatted timestamp when the repository was created.
 * @property {string} updated_at The ISO 8601 formatted timestamp when the repository was last updated.
 */
export interface Repository {
  id: number;
  name: string;
  full_name: string;
  owner: string;
  description: string | null;
  stars: number;
  forks: number;
  language: string | null;
  html_url: string;
  created_at: string;
  updated_at: string;
}

/**
 * Represents metadata information related to pagination.
 *
 * This interface defines properties that are used to describe
 * the structure of paginated data, such as the number of items per page,
 * the current page being viewed, and the overall total count of items.
 *
 * Properties:
 * - `count`: The number of items on the current page.
 * - `current_page`: The index of the current page being accessed.
 * - `per_page`: The number of items displayed per page.
 * - `total_pages`: The total number of pages available.
 * - `total_items`: The total number of items across all pages.
 */
export interface PaginationMeta {
  count: number;
  current_page: number;
  per_page: number;
  total_pages: number;
  total_items: number;
}

/**
 * Represents a paginated response structure.
 *
 * @template T - The type of items contained in the paginated data.
 * @property {T[]} data - The list of items on the current page.
 * @property {PaginationMeta} metadata - Metadata information related to the pagination, such as current page, total items, etc.
 */
export interface Paginated<T> {
  data: T[];
  metadata: PaginationMeta;
}
