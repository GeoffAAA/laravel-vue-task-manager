<template>
  <div class="min-h-screen w-full bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full space-y-8 flex flex-col justify-center min-h-full mx-auto" style="max-width: 31rem;">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Task Manager
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Sign in to your account
        </p>
      </div>
      
      <!-- Login Form -->
      <div v-if="!showRegister" class="bg-white py-8 px-6 lg:px-12 shadow rounded-lg w-full">
        <form @submit.prevent="login" class="space-y-6">
          <div>
            <input 
              v-model="email" 
              type="email" 
              placeholder="Email address" 
              required 
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            />
          </div>
          <div>
            <input 
              v-model="password" 
              type="password" 
              placeholder="Password" 
              required 
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            />
          </div>
          <div>
            <button 
              type="submit" 
              :disabled="loading"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400"
            >
              {{ loading ? 'Signing in...' : 'Sign in' }}
            </button>
          </div>
        </form>
        
        <div class="mt-6">
          <p class="text-center text-sm text-gray-600">
            Don't have an account? 
            <button @click="showRegister = true" class="font-medium text-indigo-600 hover:text-indigo-500">
              Sign up
            </button>
          </p>
        </div>
      </div>
      
      <!-- Register Form -->
      <div v-if="showRegister" class="bg-white py-8 px-6 lg:px-12 shadow rounded-lg w-full">
        <form @submit.prevent="register" class="space-y-6">
          <div>
            <input 
              v-model="registerData.name" 
              type="text" 
              placeholder="Full name" 
              required 
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            />
          </div>
          <div>
            <input 
              v-model="registerData.email" 
              type="email" 
              placeholder="Email address" 
              required 
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            />
          </div>
          <div>
            <input 
              v-model="registerData.password" 
              type="password" 
              placeholder="Password (min. 8 characters)" 
              required 
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            />
            <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
          </div>
          <div>
            <button 
              type="submit" 
              :disabled="loading"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400"
            >
              {{ loading ? 'Creating account...' : 'Sign up' }}
            </button>
          </div>
        </form>
        
        <div class="mt-6">
          <p class="text-center text-sm text-gray-600">
            Already have an account? 
            <button @click="showRegister = false" class="font-medium text-indigo-600 hover:text-indigo-500">
              Sign in
            </button>
          </p>
        </div>
      </div>
      
      <!-- Error Messages -->
      <div v-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md">
        <p class="font-semibold mb-1">{{ error }}</p>
        <ul v-if="validationErrors && Object.keys(validationErrors).length > 0" class="list-disc list-inside space-y-1 text-sm mt-2">
          <li v-for="(messages, field) in validationErrors" :key="field">
            <strong class="capitalize">{{ field }}:</strong> {{ messages.join(', ') }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../axios';

const router = useRouter();
const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');
const validationErrors = ref(null);
const showRegister = ref(false);

const registerData = ref({
  name: '',
  email: '',
  password: ''
});

async function login() {
  loading.value = true;
  error.value = '';
  validationErrors.value = null;
  
  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    });
    
    localStorage.setItem('token', response.data.token);
    router.push('/dashboard');
  } catch (err) {
    if (err.response?.data?.errors) {
      error.value = 'Please fix the following errors:';
      validationErrors.value = err.response.data.errors;
    } else {
      error.value = err.response?.data?.error || 'Login failed';
    }
  } finally {
    loading.value = false;
  }
}

async function register() {
  loading.value = true;
  error.value = '';
  validationErrors.value = null;
  
  try {
    const response = await api.post('/register', registerData.value);
    
    localStorage.setItem('token', response.data.token);
    router.push('/dashboard');
  } catch (err) {
    console.error('Registration error:', err.response);
    
    // Laravel validation errors
    if (err.response?.data?.errors) {
      error.value = 'Please fix the following errors:';
      validationErrors.value = err.response.data.errors;
    } 
    // Other error messages
    else if (err.response?.data?.message) {
      error.value = err.response.data.message;
    }
    // Network or server error
    else if (err.response?.status) {
      error.value = `Registration failed (Error ${err.response.status}). Please try again.`;
    }
    // No response from server
    else if (err.request) {
      error.value = 'Cannot connect to server. Please check if the API is running on http://localhost:8001';
    }
    // Unknown error
    else {
      error.value = 'Registration failed: ' + err.message;
    }
  } finally {
    loading.value = false;
  }
}
</script>

