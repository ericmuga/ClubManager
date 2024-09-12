
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { ref,onMounted,reactive} from 'vue';
// import { useForm } from '@inertiajs/vue3;
import { currencies } from '@/Composables/useCountries';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';


const toast = useToast();

const entryTypes = ref([]); // Entry types data


const modalMode = ref('add'); // Track modal mode (add or edit)
const entryTypeForm = reactive({
  id: null,
  code: '',
  description: ''
});

// Fetch all entry types from backend
const fetchEntryTypes = async () => {
  try {
    const response = await axios.get('entry-types');
    entryTypes.value = response.data;
  } catch (error) {
    console.error('Failed to fetch entry types:', error);
  }
};

// Open modal for adding or editing
const openModal = (entryType = null) => {
  if (entryType) {
    modalMode.value = 'edit';
    entryTypeForm.id = entryType.id;
    entryTypeForm.code = entryType.code;
    entryTypeForm.description = entryType.description;
  } else {
    modalMode.value = 'add';
    entryTypeForm.id = null;
    entryTypeForm.code = '';
    entryTypeForm.description = '';
  }
  showModal.value = true;
};

// Close modal
const closeModal = () => {
  showModal.value = false;
};

// Save entry type (add or edit)
const saveEntryType = async () => {
  try {
    if (modalMode.value === 'add') {
      await axios.post('entry-types', entryTypeForm);
      toast.add({ severity: 'success', summary: 'Success', detail: 'Entry Type added' });
    } else {
      await axios.put(`entry-types/${entryTypeForm.id}`, entryTypeForm);
      toast.add({ severity: 'success', summary: 'Success', detail: 'Entry Type updated' });
    }
    fetchEntryTypes();
    closeModal();
  } catch (error) {
    console.error('Failed to save entry type:', error);
  }
};

// Delete entry type
const deleteEntryType = async (id) => {
  try {
    await axios.delete(`entry-types/${id}`);
    toast.add({ severity: 'success', summary: 'Deleted', detail: 'Entry Type deleted' });
    fetchEntryTypes();
  } catch (error) {
    console.error('Failed to delete entry type:', error);
  }
};

// Fetch data on component mount


const props= defineProps({

  clubSetting:Object,


});
const state=ref('add');

onMounted(()=>{
    // console.log(props.clubSetting)
    if(props.clubSetting){
    state.value='update'
    }
    fetchEntryTypes();
})

const form = useForm({
  club_name: props.clubSetting?.club_name || '',
  change_log_active: props.clubSetting?.change_log_active || false,
  default_currency: props.clubSetting?.default_currency || '',
  logo: props.clubSetting?.logo || '',
  dispatch_emails: props.clubSetting?.dispatch_emails || false,
  active: props.clubSetting?.active || false,
  email: props.clubSetting?.email || '',
  telephone: props.clubSetting?.telephone || '',
  address: props.clubSetting?.address || '',
  slogan: props.clubSetting?.slogan || '',
  id: props.clubSetting?.id || '',
  pin: props.clubSetting?.pin || '',
  logoPreview: props.clubSetting?.logo ? `/storage/${props.clubSetting.logo}` : null,
  progress: null
});


const onFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.logo = file;
    form.logoPreview = URL.createObjectURL(file);
  }
};



const showModal = ref(false);


const createSetting = () => {

    form.post(route('club-settings.store'), {
        forceFormData: true,
        onSuccess: () => {
            Swal.fire('Success','Setting saved successfully','success');
        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        }

    });

};







</script>



<template>

    <Head title="Club Settings" />



    <AuthenticatedLayout>

        <template #header>

            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Club Settings</h2>

        </template>

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                  <div>

                    <div class="card">
                        <Tabs value="0">
                            <TabList>
                                <Tab value="0">General Settings</Tab>
                                <Tab value="1">Finance</Tab>
                                <Tab value="2">Projects</Tab>
                            </TabList>
                            <TabPanels>
                                <TabPanel value="0">


                                <div class="grid gap-1 p-3 md:grid-cols-2 sm:grid-cols-1 border-lime-50">
                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="club_name" size="large">Club Name:</label>
                                        <InputText v-model="form.club_name" id="club_name" size="large" />
                                        <span v-if="form.errors.club_name" class="text-red-600">{{ form.errors.club_name }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="address">Address:</label>
                                        <InputText v-model="form.address" id="address" size="large"/>
                                        <span v-if="form.errors.address" class="text-red-600">{{ form.errors.address }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="telephone">Telephone:</label>
                                        <InputText v-model="form.telephone" id="telephone" />
                                        <span v-if="form.errors.telephone" class="text-red-600">{{ form.errors.telephone }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="email">Email:</label>
                                        <InputText v-model="form.email" id="email" />
                                        <span v-if="form.errors.email" class="text-red-600">{{ form.errors.email }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="change_log_active">Change Log Active:</label>
                                        <input type="checkbox" v-model="form.change_log_active" id="change_log_active" />
                                        <span v-if="form.errors.change_log_active" class="text-red-600">{{ form.errors.change_log_active }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="default_currency">Default Currency:</label>
                                        <Select v-model="form.default_currency" placeholder="Default Currency" :options="currencies" option-value="symbol" option-label="name" filter />
                                        <span v-if="form.errors.default_currency" class="text-red-600">{{ form.errors.default_currency }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="PIN">PIN:</label>
                                        <InputText v-model="form.pin" id="PIN" />
                                        <span v-if="form.errors.pin" class="text-red-600">{{ form.errors.pin }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="logo">Logo:</label>
                                        <input type="file" @change="onFileChange" />
                                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                            {{ form.progress.percentage }}%
                                        </progress>
                                        <span v-if="form.errors.logo" class="text-red-600">{{ form.errors.logo }}</span>
                                        </div>

                                        <div v-if="form.logoPreview" class="col-span-1 mt-4 text-center">
                                        <img :src="form.logoPreview" alt="Logo Preview" class="w-auto h-32" />
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="slogan">Slogan:</label>
                                        <InputText v-model="form.slogan" id="slogan" size="large" />
                                        <span v-if="form.errors.slogan" class="text-red-600">{{ form.errors.slogan }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="dispatch_emails">Dispatch Emails:</label>
                                        <input type="checkbox" v-model="form.dispatch_emails" id="dispatch_emails" />
                                        <span v-if="form.errors.dispatch_emails" class="text-red-600">{{ form.errors.dispatch_emails }}</span>
                                        </div>

                                        <div class="flex flex-col py-2 mr-3">
                                        <label for="active">Active:</label>
                                        <input type="checkbox" v-model="form.active" id="active" />
                                        <span v-if="form.errors.active" class="text-red-600">{{ form.errors.active }}</span>
                                        </div>

                                        <div class="col-span-2 text-center">
                                        <Button :label="(state=='add')?'Save':'Update'" @click="createSetting()"
                                            :icon="(state=='add')?'pi pi-send':'pi pi-pencil'"
                                            :severity="(state=='add')?'success':'warn'"

                                            />
                                        </div>
                                    </div>

                                </TabPanel>
                                <TabPanel value="1">
                                     <div class="card">
                                        <Accordion value="0">
                                            <AccordionPanel value="0">
                                                <AccordionHeader>Entry Types</AccordionHeader>
                                                <AccordionContent>
                                                    <Button label="Add"  icon="pi pi-plus" @click="openModal()" />

                                                    <!-- Entry Types Table -->
                                                  <DataTable :value="entryTypes" responsiveLayout="scroll" sortMode="multiple" tableStyle="min-width: 50rem">
                                                    <Column field="code" header="Code" />
                                                    <Column field="description" header="Description" />

                                                    <Column header="Actions">
                                                        <template #body="slotProps">
                                                            <Button icon="pi pi-pencil" severity="info" text rounded @click="openModal(slotProps.data)" />
                                                            <Button icon="pi pi-trash" severity="danger" text rounded @click="deleteEntryType(slotProps.data.id)" />
                                                        </template>
                                                    </Column>
                                                </DataTable>


                                                </AccordionContent>
                                            </AccordionPanel>
                                            <AccordionPanel value="1">
                                                <AccordionHeader>Header II</AccordionHeader>
                                                <AccordionContent>
                                                    <p class="m-0">
                                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                                                        ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
                                                    </p>
                                                </AccordionContent>
                                            </AccordionPanel>
                                            <AccordionPanel value="2">
                                                <AccordionHeader>Header III</AccordionHeader>
                                                <AccordionContent>
                                                    <p class="m-0">
                                                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa
                                                        qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                                                    </p>
                                                </AccordionContent>
                                            </AccordionPanel>
                                        </Accordion>
                                    </div>
                                </TabPanel>
                                <TabPanel value="2">

                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </div>



                   </div>

            </div>

        </div>


</AuthenticatedLayout>
  <Modal :show="showModal" @close="showModal=false">
            <template #header>
                <h2>{{ modalMode === 'add' ? 'Add' : 'Edit' }} Entry Type</h2>
            </template>
            <template #default>
                <form @submit.prevent="saveEntryType">
                 <div class="flex flex-col w-full p-3">
                     <div class="flex items-center justify-between gap-4 my-2 ">
                        <label for="code">Code</label>
                        <InputText id="code" v-model="entryTypeForm.code" required />

                    </div>
                    <hr/>
                    <div class="flex items-center justify-between gap-4 my-2">
                        <label for="description">Description</label>
                        <InputText id="description" size="large" type="text" v-model="entryTypeForm.description" required />
                    </div>
                    <Button type="submit" label="Save" />
                 </div>

                </form>
            </template>
            </Modal>




</template>

<style scoped>
.text-red-600 {
  color: #e3342f;
}
</style>







