<template>
  <div class="flex flex-row justify-center w-full gap-2 p-6 text-gray-900 dark:text-gray-100">



        <Toolbar>
        <template #start>
            <Button icon="pi pi-plus" @click="handleAction" class="mr-2" severity="secondary" text />
            <Button icon="pi pi-download" @click="downloadList" class="mr-2" severity="secondary" text />
            <Button icon="pi pi-print" @click="downloadPDFList" class="mr-2" severity="secondary" text />
            <Button icon="pi pi-upload" severity="secondary" @click="showModal=true" text />
        </template>

        <template #center>
            <IconField>

                <InputText
                :placeholder="`Search ${label}`"
                v-model="search"
                class="justify-center text-center bg-slate-300"
                />
            </IconField>
        </template>

        <template #end> <SplitButton label="Save" :model="items"></SplitButton></template>
    </Toolbar>

    <Modal :show="showModal" @close="showModal=false">



     <div class="flex flex-col items-center gap-4 p-5 text-center">
        <Button
          label="Download Template"
          icon="pi pi-download"
          @click="downloadTemplate"
          class="mb-4"
        />
        <FileUpload
          ref="fileupload"
          mode="basic"
          name="file"
          accept=".xlsx,.xls"
          :maxFileSize="1000000"
          @select="handleFileSelect"
          class="mb-4"
        />
        <Button
          label="Upload"
          icon="pi pi-upload"
          @click="handleSubmit"
          :disabled="!selectedFile"
        />


      </div>

    </Modal>


  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import Modal from '@/Components/Modal.vue'
import IconField from 'primevue/iconfield';
import Toolbar from 'primevue/toolbar';




 const showModal=ref(false)

  const selectedFile = ref(null)

  const downloadTemplate = () => {
    window.location.href = `/download-template/${props.model}`
  }

   const downloadList = () => {
    window.location.href = `/download-list/${props.model}`
  }

   const downloadPDFList = () => {
    window.location.href = `/download-pdf-list/${props.model}`
  }

  const handleFileSelect = (event) => {
    selectedFile.value = event.files[0]
  }

  const handleSubmit = () => {
    if (selectedFile.value) {
      emit('upload', selectedFile.value)
    }
    closeModal()
  }

  const closeModal = () => {
    props.onClose()
  }

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
