<template>
  <div class="space-y-3">
    <div v-if="tasks.length === 0" class="text-center py-8 text-gray-500">
      <p>No tasks yet. Add one above to get started!</p>
    </div>
    
    <div v-else class="space-y-3">
      <div 
        v-for="task in tasks" 
        :key="task.id" 
        class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition-colors"
        :class="{ 
          'bg-green-50 border-green-200': task.status === 'done',
          'bg-white border-gray-200': task.status === 'pending'
        }"
      >
        <div 
          class="flex-1 cursor-pointer" 
          @click="$emit('toggle', task)"
        >
          <div class="flex items-center justify-between">
            <span 
              class="text-gray-900 font-medium"
              :class="{ 'line-through text-gray-500': task.status === 'done' }"
            >
              {{ task.title }}
            </span>
            <span 
              class="px-2 py-1 text-xs font-medium rounded-full"
              :class="{
                'bg-green-100 text-green-800': task.status === 'done',
                'bg-yellow-100 text-yellow-800': task.status === 'pending'
              }"
            >
              {{ task.status }}
            </span>
          </div>
        </div>
        <button 
          @click="$emit('delete', task)" 
          class="ml-4 p-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-colors"
          title="Delete task"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  tasks: {
    type: Array,
    required: true
  }
});

defineEmits(['toggle', 'delete']);
</script>

