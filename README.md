# ResilientX Github Repositories App

[![Technology][php-badge]][php-url]
[![Technology][laravel-badge]][laravel-url]
[![Technology][nginx-badge]][nginx-url]
[![Technology][vue-badge]][vue-url]
[![Technology][vite-badge]][vite-url]
[![Technology][docker-badge]][docker-url]

This project was developed as part of a **technical assessment for [ResilientX][resilientx-url]**, showcasing a modular
architecture based on **PHP with [Laravel][laravel-url] and a [Vue][vue-url] 3 SPA frontend**.

The application allows users to search GitHub repositories, browse paginated results, and view detailed repository
information, handling rate limits, caching, error scenarios, and API constraints in a robust and user-friendly way.

## Project context

- **Project Name:** ResilientX GitHub Repositories App
- **Scenario:** GitHub public repositories search and exploration
- **Focus:** Resiliency, clean architecture, pagination, caching, and UX consistency
- **Architecture Style:** Decoupled backend and SPA frontend

**Objectives:**

- Demonstrate capability in requirements analysis and modeling
- Consume the GitHub Search API safely and efficiently
- Handle rate limits, pagination constraints, and API errors
- Apply backend resiliency patterns (cache, validation, error normalization)
- Build a modern Vue 3 SPA with clean state management
- Deliver a fully containerized development environment
- Maintain strong typing, linting, and formatting standards

## Technology stack

| Layer           | Technology                | Purpose                                       |
|-----------------|---------------------------|-----------------------------------------------|
| Backend         | PHP 8.4 + Laravel         | REST API, validation, caching, error handling |
| Frontend        | Vue 3 + Vite + TypeScript | SPA for repository search and visualization   |
| Infrastructure  | Docker + Docker Compose   | Local orchestration and isolation             |
| Version Control | GitHub                    | Commit history and project documentation      |

## Key features

### Repository search

- Search public GitHub repositories by keyword
- Supports pagination via `page` and `per_page`
- Fully aligned with GitHub API constraints

### Pagination metadata

The backend normalizes GitHub pagination into a clean metadata object:

```json
{
  "count": 10,
  "current_page": 1,
  "per_page": 10,
  "total_pages": 100,
  "total_items": 1000
}
```

> ⚠️ GitHub limits search results to the first **1000 items** – this rule is enforced and reflected in the API design.

### Repository details page

- Dedicated route per repository: `/repositories/{owner}/{repo}`
- Displays:
    - Fully description
    - Language
    - Stars count
    - Forks count
    - Creation and update dates
    - GitHub link

### Resiliency & error handling

**Backend handles:**

- GitHub rate limit errors
- Invalid pagination requests
- API failures with normalized JSON responses
- Validation errors (query params)
- Cache fallback logic

**Frontend handles:**

- Loading states
- Empty results
- Friendly error messages
- Defensive typing (`unknown`, `no any`)

### Caching strategy

- GitHub search responses are cached based on:
    - query
    - page
    - per_page
- Reduces API calls and prevents hitting rate limits unnecessarily
- Cache layer is fully transparent to the frontend

### Frontend architecture

- Vue 3
- Pinia for state management
- Typed API responses
- Centralized pagination component
- ESLint + Prettier enforced
- No unused dependencies

## Development environment setup

### Requirements

- [Docker][docker-url] installed on your machine
- [Docker Compose v2][docker-compose-url] for service orchestration

### Dockerized architecture

The project is fully containerized using Docker Compose, providing isolated environments for:

- Backend
    - NGINX reverse proxy
    - Laravel (PHP 8.4 FPM)
    - Exposed on port `8080` (http) and `8081` (https)
- Frontend
    - Vue 3 SPA (Vite dev server)
    - Exposed on port `5173`

### Quick Start

To build and start all containers, run the following command from the project root:

```bash
$ docker compose up --build
```

This command will:

- Build and start all containers (backend and frontend)
- Generate a self-signed SSL certificate for HTTPS
- Mount local source code for live development

### Available Services

| Service          | Description      | URL / Port                                                  |
|------------------|------------------|-------------------------------------------------------------|
| Frontend (Vue 3) | Vue 3            | http://localhost:5173                                       |
| Backend          | Laravel REST API | HTTP: http://localhost:8080 / HTTPS: https://localhost:8081 |

## Directory structure

```
resilientx-github-repositories-app/
├── backend/               # Laravel backend
│   ├── app/
│   ├── routes/
│   ├── tests/
│   └── ...
├── frontend/              # Vue 3 SPA
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── stores/
│   │   └── lib/
│   └── ...
├── docker/                # Docker configuration
├── compose.yaml           # Docker compose orchestration
└── README.md
```

## References

- [GitHub REST API – Search](https://docs.github.com/en/rest/search/search)
- [Laravel](https://laravel.com/)
- [Vue 3](https://vuejs.org/)
- [Vite](https://vitejs.dev)
- [Pinia](https://pinia.vuejs.org/)
- [Tailwind](https://tailwindcss.com/)
- [Docker Documentation](https://docs.docker.com/get-docker)
- [Docker Compose v2 Documentation](https://docs.docker.com/compose/install/)

## Postman Collection

A [Postman collection](ResilientX.postman_collection.json) is available for testing the API endpoints.

[php-url]: https://www.php.net/

[php-badge]: https://img.shields.io/badge/php-8.4-grey?style=for-the-badge&logo=php&logoColor=white&logoSize=auto&label=&labelColor=blue&color=grey

[laravel-url]: https://laravel.com/

[laravel-badge]: https://img.shields.io/badge/laravel-f53003?style=for-the-badge&logo=laravel&labelColor=21201c

[nginx-url]: https://www.nginx.com/

[nginx-badge]: https://img.shields.io/badge/nginx-009639?style=for-the-badge&logo=nginx&logoColor=white

[vue-url]: https://vuejs.org/

[vue-badge]: https://img.shields.io/badge/vue-3-gray?style=for-the-badge&logo=vuedotjs&labelColor=42B883&logoColor=white

[vite-url]: https://vitejs.dev/

[vite-badge]: https://img.shields.io/badge/vite-7-gray?style=for-the-badge&logo=vite&labelColor=646CFF&logoColor=white

[docker-url]: https://www.docker.com/

[docker-badge]: https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=Docker&logoColor=white

[docker-compose-url]: https://docs.docker.com/compose/install/

[resilientx-url]: https://www.resilientx.com/
