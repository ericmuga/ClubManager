
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { ref,onMounted,watch} from 'vue';
import Modal from '@/Components/Modal.vue'
import MemberCard from '@/Components/MemberCard.vue';
import debounce from 'lodash/debounce';
// import { useForm } from '@inertiajs/inertia-vue3';
import {countryListAllIsoData} from '@/Composables/useCountries.js'
import ActionPanel  from '@/Components/ActionPanel.vue';

const props= defineProps({
  members:Object
});

const genders =[{code:'M', name:'Male'},{code:'F',name:'Female'}];
const membersArray=ref([]);
onMounted(() => {
  membersArray.value=props.members;
});

const showModal=ref(false);




const form=useForm({
    name:'',
    classification:'',
    email:'',
    nationality:'',
    avatar:'',
    gender:'',
    member_no:'',
    phone:'',
    id:null
})



const handleFileUpload = (file) => {
  const uploadForm = useForm({
    file: null
  })

  uploadForm.file = file

  uploadForm.post(route('members.upload'), {
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
  membersArray.value=props.members;
}
else membersArray.value=membersArray.value.filter(member=>member.name.toLower.includes(search.value))
},500))


const state=ref('add');

const createOrUpdateMember=(member=null,addOrEdit)=>{
        form.reset();
        if (member)
          {
           console.log(member);
            form.name=member.name
            form.classification=member.classification
            form.email=member.email
            form.nationality=member.nationality
            form.avatar=member.avatar
            form.gender=member.gender
            form.member_no=member.member_no
            form.phone=member.phone
            form.id=member.id
            state.value=addOrEdit;
          }

        showModal.value=true



}

const handleForm=()=>{

    if(state.value=='add')
     createMember();
    else
     updateMember();
}


const createMember=()=>{
   form.post(route('members.store'), {
                                    forceFormData: true,
                                    onSuccess: () => {console.log('Form submitted successfully');},
    onError: (errors) => {
      console.error('Error submitting form:', errors);
    }
  });
};

const updateMember=()=>{
    form.patch(route('members.update',form.id), {
                                    forceFormData: true,
                                    onSuccess: () => {console.log('Form submitted successfully');},
    onError: (errors) => {
      console.error('Error submitting form:', errors);
    }
  });
}


</script>

<template>
    <Head title="Members" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Members</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                      <ActionPanel
                        label="Member"
                        model="member"
                        @action="createOrUpdateMember(null,'add')"
                        @upload="handleFileUpload"
                        v-model:search="search"
                      />
                  <div class="grid p-5 text-center md:gap-2 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1">
                     <MemberCard
                            v-for="member in membersArray"
                            :member="member"
                            :key="member.id"
                        />
                            <!-- @click="createOrUpdateMember(member, 'edit')" -->
                  </div>
                </div>
            </div>
        </div>







    </AuthenticatedLayout>
    <Modal :show="showModal" @close="showModal=false" :errors="errors">
      <form @submit.prevent="handleForm()" class="p-5">
      <div class="p-fluid p-formgrid p-grid">
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="member_name" class="p-col-12 sm:p-col-4 p-justify-start">Member Name</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <InputText id="member_name" v-model="form.name" class="w-full" />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="classification" class="p-col-12 sm:p-col-4 p-justify-start">Classification</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <InputText id="classification" v-model="form.classification" class="w-full" />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="email" class="p-col-12 sm:p-col-4 p-justify-start">Email</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <InputText id="email" v-model="form.email" class="w-full" />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="phone" class="p-col-12 sm:p-col-4 p-justify-start">Phone No.</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <InputText id="phone" v-model="form.phone" class="w-full" />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="nationality" class="p-col-12 sm:p-col-4 p-justify-start">Nationality</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
             <Select id="nationality" v-model="form.nationality" :options=countryListAllIsoData
              optionLabel="name" optionValue="code" class="w-full text-black" filter />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="avatar" class="p-col-12 sm:p-col-4 p-justify-start">Avatar</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <div class="p-col-12 sm:p-col-8 p-justify-end">
            <input type="file" @input="form.avatar = $event.target.files[0]" />
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
            </progress>

            </div>
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="gender" class="p-col-12 sm:p-col-4 p-justify-start">Gender</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <Select id="gender" v-model="form.gender" :options=genders optionLabel="name" optionValue="code" class="w-full" filter />
          </div>
        </div>
        <div class="p-field p-col-12 sm:p-col-6">
          <label for="member_no" class="p-col-12 sm:p-col-4 p-justify-start">Member No.</label>
          <div class="p-col-12 sm:p-col-8 p-justify-end">
            <InputText id="member_no" v-model="form.member_no" class="w-full" />
          </div>
        </div>
        <div class="p-4 p-col-12">
          <Button label="Save" icon="pi pi-send" type="save" class="w-full text-center"/>
        </div>
      </div>
    </form>
    </Modal>
</template>



