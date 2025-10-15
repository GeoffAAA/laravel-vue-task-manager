# Task Manager Frontend

Vue 3 + TypeScript frontend for the Task Manager application.

## Features

- **Authentication**: Login/Register with Laravel Sanctum (personal access tokens)
- **Task Management**: Create, read, update, delete tasks
- **Task Chart**: Chart.js pie chart of task status
- **Responsive Design**: Modern, responsive layout
- **Route Protection**: Authenticated routes with token validation

## Tech Stack

- Vue 3 with Composition API
- TypeScript
- Vue Router
- Axios for API communication
- Chart.js for data visualization
- Tailwind CSS for styling

## Development

```powershell
# Install dependencies
npm ci

# Start development server (configured on port 5174)
npx vite

# Build for production
npx vite build
```

## API Integration

The frontend connects to the Laravel API at `http://localhost:8001/api` (see `src/axios.js`). Update this if your API runs on a different host/port.

Endpoints:

- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/tasks` - Get user tasks
- `POST /api/tasks` - Create new task
- `PUT /api/tasks/{id}` - Update task
- `DELETE /api/tasks/{id}` - Delete task

## Project Structure

```
src/
├── components/
│   ├── TaskList.vue      # Task list with toggle/delete
│   └── TaskChart.vue     # Chart.js visualization
├── views/
│   ├── LoginView.vue     # Login/Register form
│   └── DashboardView.vue # Main dashboard
├── router/
│   └── index.ts          # Vue Router configuration
├── axios.js              # API client configuration
└── main.ts               # Application entry point
```