<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import {debounce} from 'lodash';
import { useForm } from '@inertiajs/inertia-vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Swal from 'sweetalert2';

const props = defineProps({
  meetings: Array,
});

const meetingsArray = ref([...props.meetings]);

const search = ref('');

watch(search, debounce(() => {
  // Normalize the search value to lower case for case-insensitive search
  const searchTerm = search.value.toLowerCase();

  if (searchTerm === '') {
    meetingsArray.value = props.meetings;
  } else {
    meetingsArray.value = props.meetings.filter(meeting => {
      // Convert all searchable fields to lower case for case-insensitive search
      const type = meeting.type.toLowerCase();
      const venue = meeting.venue.toLowerCase();
      const topic = meeting.topic.toLowerCase();
      const host = meeting.host.toLowerCase();
      const date = meeting.date.toLowerCase(); // Ensure date is a string and lowercase

      // Check if the search term is present in any of the properties
      return (
        type.includes(searchTerm) ||
        venue.includes(searchTerm) ||
        topic.includes(searchTerm) ||
        host.includes(searchTerm) ||
        date.includes(searchTerm)
      );
    });
  }
}, 500));

const form = useForm({
  type: '',
  description: '',
  date: null,
  venue: '',
  topic: '',
  detail: '',
  host: '',
  uuid: '',
  official_start_time: null,
  official_end_time: null,
  id: null,
});

const state = ref('add');
const showModal = ref(false);

const createOrUpdateMeeting = (meeting = null) => {
  form.reset();

  if (meeting) {
    form.type = meeting.type;
    form.date = meeting.date;
    form.venue = meeting.venue;
    form.topic = meeting.topic;
    form.detail = meeting.detail;
    form.host = meeting.host;
    form.uuid = meeting.uuid;
    form.official_start_time = meeting.official_start_time;
    form.official_end_time = meeting.official_end_time;
    form.id = meeting.id;
    state.value = 'edit';
  } else {
    state.value = 'add';
  }

  showModal.value = true;
};

const handleForm = () => {
  if (state.value === 'add') {
    createMeeting();
  } else {
    updateMeeting();
  }
};

const createMeeting = () => {
  form.post(route('meetings.store'), {
    onSuccess: () => {
      console.log('Meeting created successfully');
      showModal.value = false;
    },
    onError: (errors) => {
      console.error('Error creating meeting:', errors);
    }
  });
};

const updateMeeting = () => {
  form.put(route('meetings.update', form.id), {
    onSuccess: () => {
      console.log('Meeting updated successfully');
      showModal.value = false;
    },
    onError: (errors) => {
      console.error('Error updating meeting:', errors);
    }
  });
};

const confirmDeleteMeeting = (meeting) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
  }).then((result) => {
    if (result.isConfirmed) {
      Inertia.delete(route('meetings.destroy', meeting.id), {
        onSuccess: () => {
          Swal.fire('Deleted!', 'The meeting has been deleted.', 'success');
        },
        onError: () => {
          Swal.fire('Error!', 'There was an error deleting the meeting.', 'error');
        },
      });
    }
  });
};

const viewMeeting = (meeting) => {
  Inertia.get(route('meetings.show', meeting.id));
};

const meeting_types = [{ code: 'Physical' }, { code: 'GoogleMeet' }, { code: 'Zoom' }];
</script>


<template>
    <Head title="meetings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Meetings</h2>
        </template>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <Toolbar>
                    <template #start>
                        <Button icon="pi pi-plus" class="mr-2" severity="success" @click="createOrUpdateMeeting(null,'add')" />
                        <!-- <Button icon="pi pi-print" class="mr-2" severity="secondary" text /> -->
                        <!-- <Button icon="pi pi-upload" severity="secondary" text /> -->
                    </template>

                    <template #center>
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText placeholder="Search" v-model="search" />
                        </IconField>
                    </template>

                    <template #end> <SplitButton label="Save" :model="items"></SplitButton></template>
                </Toolbar>
                <div>
                    <DataTable :value="meetingsArray">
                        <Column field="meeting_no" header="Meeting Number" />
                        <Column field="type" header="Type" />
                        <!-- <Column field="description" header="Description" /> -->
                        <Column field="date" header="Meeting Date" />
                        <Column field="venue" header="Venue" />
                        <Column field="topic" header="Topic" />
                        <Column field="host" header="Host" />
                         <Column header="Actions">
                            <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="p-button-rounded p-button-info p-mr-2" @click="createOrUpdateMeeting(slotProps.data)" />
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger p-mr-2" @click="confirmDeleteMeeting(slotProps.data)" />
                            <Button icon="pi pi-eye" class="p-button-rounded p-button-secondary" @click="viewMeeting(slotProps.data)" />
                            </template>
                        </Column>
                        <!-- <Column field="uuid" header="UUID" /> -->


                    </DataTable>

                </div>
            </div>
        </div>







    </AuthenticatedLayout>
    <Modal :show="showModal" @close="showModal=false">
        <form @submit.prevent="handleForm" class="m-6">
            <div class="p-3 mx-5 my-3 font-bold text-center text-black uppercase bg-teal-400 rounded-md "> {{state}} Meeting</div>
            <div class="grid gap-3 md:grid-cols-2 sm:grid-cols-1 ">

                <div class="flex flex-row justify-between p-field">
                    <label for="type">Type</label>
                    <Select id="type" v-model="form.type" :options="meeting_types" optionLabel="code" optionValue="code" />
                </div>

                <div class="flex flex-row justify-between p-field">
                    <label for="date">Meeting Date</label>
                    <input type="date" id="date" v-model="form.date"  class="p-2 rounded-md"/>
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="venue">Venue</label>
                    <InputText id="venue" v-model="form.venue" />
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="topic">Topic</label>
                    <InputText id="topic" v-model="form.topic" />
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="detail">Detail</label>
                    <InputTextarea id="detail" v-model="form.detail" rows="5" />
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="host">Host</label>
                    <InputText id="host" v-model="form.host" />
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="uuid">UUID</label>
                    <InputText id="uuid" v-model="form.uuid" />
                </div>
                <!-- <div class="flex flex-row justify-between p-field">
                    <label for="meeting_no">Meeting Number</label>
                    <InputText id="meeting_no" v-model="form.meeting_no" />
                </div> -->
                <div class="flex flex-row justify-between p-field">
                    <label for="official_start_time">Official Start Time</label>
                    <input type="time" id="official_start_time" v-model="form.official_start_time"  />
                </div>
                <div class="flex flex-row justify-between p-field">
                    <label for="official_end_time">Official End Time</label>
                    <input type="time" id="official_end_time" v-model="form.official_end_time" />
                </div>
                <Button label="Submit" type="submit" />
            </div>
        </form>
    </Modal>

</template>



