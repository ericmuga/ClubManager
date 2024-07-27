<template>
    <Dialog
      :visible.sync="visible"
      :header="`Upload ${props.model}s`"
      modal
      :dismissable-mask="true"
      @hide="closeModal"
      :closeOnEscape="true"
      :closable="true"
    >
      <div class="p-4">
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
    </Dialog>
  </template>

  <script setup>
  import { ref } from 'vue'


  const props = defineProps({
    visible: Boolean,
    onClose: Function,
    model: String
  })

  const emit = defineEmits(['upload'])

  const selectedFile = ref(null)

  const downloadTemplate = () => {
    window.location.href = `/download-template/${props.model}`
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
  </script>
