<template>
  <div class="flex justify-between w-full gap-2 p-6 text-gray-900 dark:text-gray-100">
    <Button
      :icon="icon"
      @click="handleAction"
      class="justify-start"
    />
    <Button
      label="Upload List"
      icon="pi pi-upload"
      @click="showUploadModal"
      class="justify-start"
    />
    <InputText
      :placeholder="`Search ${label}`"
      v-model="search"
      class="justify-center text-center bg-slate-300"
    />

    <UploadModal
      :visible="isUploadModalVisible"
      :model="model"
      @upload="handleUpload"
      :onClose="hideUploadModal"
    />
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'

import UploadModal from './UploadModal.vue'

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    default: 'pi pi-plus'
  },
  model: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['action', 'upload', 'update:search'])

const search = ref('')
const isUploadModalVisible = ref(false)

const handleAction = () => {
  emit('action')
}

const showUploadModal = () => {
  isUploadModalVisible.value = true
}

const hideUploadModal = () => {
  isUploadModalVisible.value = false
//   const isUploadModalVisible = ref(false)
}

const handleUpload = (file) => {
  emit('upload', file)
}

watch(search, (newValue) => {
  emit('update:search', newValue)
})
</script>
