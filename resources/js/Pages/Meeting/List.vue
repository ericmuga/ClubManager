
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,onMounted,watch} from 'vue';
import Modal from '@/Components/Modal.vue'
import meetingCard from '@/Components/meetingCard.vue';
import debounce from 'lodash/debounce';
import { useForm } from '@inertiajs/inertia-vue3';
import {countryListAllIsoData} from '@/Composables/useCountries.js'
import ActionPanel  from '@/Components/ActionPanel.vue';

import { usePage } from '@inertiajs/inertia-vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const props= defineProps({
  meetings:Object
});

const meetingsArray=ref([]);
onMounted(() => {
  meetingsArray.value=props.meetings;
});

// const showModal=ref(false);

// const { props } = usePage();
const meetings = ref(props.meetings);

const form = useForm({
    type: '',
    description: '',
    meeting_date: null,
    venue: '',
    topic: '',
    detail: '',
    host: '',
    uuid: '',
    meeting_no: '',
    official_start_time: null,
    official_end_time: null,
    id: null
});

const state = ref('add');
const showModal = ref(false);

const createOrUpdateMeeting = (meeting = null, addOrEdit) => {
    form.reset();
    if (meeting) {
        form.type = meeting.type;
        form.description = meeting.description;
        form.meeting_date = meeting.meeting_date;
        form.venue = meeting.venue;
        form.topic = meeting.topic;
        form.detail = meeting.detail;
        form.host = meeting.host;
        form.uuid = meeting.uuid;
        form.meeting_no = meeting.meeting_no;
        form.official_start_time = meeting.official_start_time;
        form.official_end_time = meeting.official_end_time;
        form.id = meeting.id;
        state.value = addOrEdit;
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
        forceFormData: true,
        onSuccess: () => {
            console.log('Form submitted successfully');
            showModal.value = false;
        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        }
    });
};

const updateMeeting = () => {
    form.patch(route('meetings.update', form.id), {
        forceFormData: true,
        onSuccess: () => {
            console.log('Form submitted successfully');
            showModal.value = false;
        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        }
    });
};






const handleFileUpload = (file) => {
  const uploadForm = useForm({
    file: null
  })

  uploadForm.file = file

  uploadForm.post(route('meetings.upload'), {
    forceFormData: true,
    onSuccess: () => {
      console.log('File uploaded successfully')
      // Handle post-upload actions, e.g., refresh data
    },
    onError: (errors) => {
      console.error('Error uploading file:', errors)
    }
  })
}


const search=ref('')

watch(search, debounce(() => {
    if(search.value=='')
{
  meetingsArray.value=props.meetings;
}
else meetingsArray.value=meetingsArray.value.filter(meeting=>meeting.name.includes(search.value))
},500))





</script>

<template>
    <Head title="meetings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Meetings</h2>
        </template>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                      <ActionPanel
                        label="meeting"
                        model="meeting"
                        @action="createOrUpdatemeeting(null,'add')"
                        @upload="handleFileUpload"
                        v-model:search="search"
                      />
                   <div>
                   <DataTable :value="meetings">
                       <Column field="type" header="Type" />
                       <Column field="description" header="Description" />
                       <Column field="meeting_date" header="Meeting Date" />
                       <Column field="venue" header="Venue" />
                       <Column field="topic" header="Topic" />
                       <Column field="detail" header="Detail" />
                       <Column field="host" header="Host" />
                       <Column field="uuid" header="UUID" />
                       <Column field="meeting_no" header="Meeting Number" />
                       <Column field="official_start_time" header="Official Start Time" />
                       <Column field="official_end_time" header="Official End Time" />
                   </DataTable>

                </div>
            </div>
        </div>







    </AuthenticatedLayout>
       <Dialog header="Meeting Form" :visible="showModal" @hide="showModal = false">
            <form @submit.prevent="handleForm">
                <div class="p-field">
                    <label for="type">Type</label>
                    <InputText id="type" v-model="form.type" />
                </div>
                <div class="p-field">
                    <label for="description">Description</label>
                    <InputText id="description" v-model="form.description" />
                </div>
                <div class="p-field">
                    <label for="meeting_date">Meeting Date</label>
                    <Calendar id="meeting_date" v-model="form.meeting_date" dateFormat="yy-mm-dd" />
                </div>
                <div class="p-field">
                    <label for="venue">Venue</label>
                    <InputText id="venue" v-model="form.venue" />
                </div>
                <div class="p-field">
                    <label for="topic">Topic</label>
                    <InputText id="topic" v-model="form.topic" />
                </div>
                <div class="p-field">
                    <label for="detail">Detail</label>
                    <InputTextarea id="detail" v-model="form.detail" rows="5" />
                </div>
                <div class="p-field">
                    <label for="host">Host</label>
                    <InputText id="host" v-model="form.host" />
                </div>
                <div class="p-field">
                    <label for="uuid">UUID</label>
                    <InputText id="uuid" v-model="form.uuid" />
                </div>
                <div class="p-field">
                    <label for="meeting_no">Meeting Number</label>
                    <InputText id="meeting_no" v-model="form.meeting_no" />
                </div>
                <div class="p-field">
                    <label for="official_start_time">Official Start Time</label>
                    <Calendar id="official_start_time" v-model="form.official_start_time" timeOnly hourFormat="24" />
                </div>
                <div class="p-field">
                    <label for="official_end_time">Official End Time</label>
                    <Calendar id="official_end_time" v-model="form.official_end_time" timeOnly hourFormat="24" />
                </div>
                <Button label="Submit" type="submit" />
            </form>
        </Dialog>

</template>



