<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <h1 class="text-3xl font-bold text-gray-900">Task Manager</h1>
          <button 
            @click="logout" 
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Logout
          </button>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div class="py-6">
        <!-- Add Task Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Add New Task</h2>
          <form @submit.prevent="addTask" class="flex gap-4">
            <input 
              v-model="newTaskTitle" 
              placeholder="Enter task title..." 
              required 
              class="flex-1 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-500 px-3"
            />
            <button 
              type="submit" 
              :disabled="loading"
              class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400"
            >
              {{ loading ? 'Adding...' : 'Add Task' }}
            </button>
          </form>
        </div>

        <!-- Tasks and Chart Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
          <!-- Tasks Section -->
          <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Your Tasks</h2>
            <TaskList 
              :tasks="tasks" 
              @toggle="toggleTask" 
              @delete="deleteTask" 
            />
          </div>

          <!-- Chart Section -->
          <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Task Overview</h2>
            <TaskChart :tasks="tasks" />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../axios';
import TaskList from '../components/TaskList.vue';
import TaskChart from '../components/TaskChart.vue';

const router = useRouter();
const tasks = ref([]);
const newTaskTitle = ref('');
const loading = ref(false);

onMounted(() => {
  fetchTasks();
});

async function fetchTasks() {
  try {
    console.log('Fetching tasks from API...');
    const response = await api.get('/tasks');
    console.log('Tasks fetched successfully:', response.data);
    tasks.value = response.data;
  } catch (error) {
    console.error('Failed to fetch tasks:', error);
    if (error.response?.status === 401) {
      // Token expired, redirect to login
      localStorage.removeItem('token');
      router.push('/login');
    }
  }
}

async function addTask() {
  if (!newTaskTitle.value.trim()) return;
  
  loading.value = true;
  try {
    const response = await api.post('/tasks', { 
      title: newTaskTitle.value 
    });
    tasks.value.push(response.data);
    newTaskTitle.value = '';
  } catch (error) {
    console.error('Failed to add task:', error);
  } finally {
    loading.value = false;
  }
}

async function toggleTask(task) {
  try {
    const newStatus = task.status === 'done' ? 'pending' : 'done';
    const response = await api.put(`/tasks/${task.id}`, { 
      status: newStatus 
    });
    
    const index = tasks.value.findIndex(t => t.id === task.id);
    if (index !== -1) {
      tasks.value[index] = response.data;
    }
  } catch (error) {
    console.error('Failed to toggle task:', error);
  }
}

async function deleteTask(task) {
  if (!confirm('Are you sure you want to delete this task?')) return;
  
  try {
    await api.delete(`/tasks/${task.id}`);
    tasks.value = tasks.value.filter(t => t.id !== task.id);
  } catch (error) {
    console.error('Failed to delete task:', error);
  }
}

async function logout() {
  try {
    await api.post('/logout');
  } catch (error) {
    console.error('Logout error:', error);
  } finally {
    localStorage.removeItem('token');
    router.push('/login');
  }
}
</script>

