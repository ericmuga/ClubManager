<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref,computed,onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';

const props=defineProps({meeting:Object,members:Object,guests:Object,meeting_lines:Object});
const membersArray=ref([...props.members]);
const guestsArray=ref([...props.guests]);

const updateAttendance = (id, attended, userType) => {
    const score = attended ? '1' : '0'; // Score is sent as a string

    axios.post(route('meetings.attend'), {
                userId: id,
                userType,
                score,
                attendedFrom: '18:00', // Replace with actual value if applicable
                attendedTo: '20:00',   // Replace with actual value if applicable
                meeting_id:props.meeting.id /* Replace with actual meeting ID */
            })
            .then(response => {
                console.log('Attendance updated successfully', response.data);
                focusSearchInput()
            })
            .catch(error => {
                console.error('Error updating attendance', error);
            });
};




const updateScore = (id, score, userType, attendedFrom, attendedTo) => {
    axios.post(route('meetings.attend'), {
        userId: id,
        userType,
        score,
        attendedFrom,
        attendedTo,
        meeting_id: props.meeting.id
    })
    .then(response => {
        console.log('Score updated successfully', response.data);
        focusSearchInput()
    })
    .catch(error => {
        console.error('Error updating score', error);
    });
};


const searchMember=ref('')
const searchGuest=ref('')

const filteredMembers = computed(() => {
    const searchTerm = searchMember.value.toLowerCase();
    return membersArray.value.filter(member =>
        member.name.toLowerCase().includes(searchTerm) ||
        member.email.toLowerCase().includes(searchTerm) ||
        member.phone.toLowerCase().includes(searchTerm)
    );
});

const filteredGuests = computed(() => {
    const searchTerm = searchGuest.value.toLowerCase();
    return guestsArray.value.filter(guest =>
        guest.name.toLowerCase().includes(searchTerm) ||
        guest.email.toLowerCase().includes(searchTerm) ||
        guest.phone.toLowerCase().includes(searchTerm)
    );
});


// Function to initialize member data from meeting_lines
const initializeMemberData = () => {
    props.meeting_lines.forEach(line => {
        const member = membersArray.value.find(m => m.id === line.user_id);

        if (member) {
            member.attended = line.score === '1'; // Set checkbox status
            member.attendedFrom = line.attended_from;
            member.attendedTo = line.attended_to;
            member.score = line.score;
            // Ensure meetingId is set
            member.meetingId = line.meeting_id;
        }
    });
};

const initializeGuestData = () => {
    props.meeting_lines.forEach(line => {
        const guest = guestsArray.value.find(m => m.id === line.user_id);

        if (guest) {
            guest.attended = line.score === '1'; // Set checkbox status
            guest.attendedFrom = line.attended_from;
            guest.attendedTo = line.attended_to;
            guest.score = line.score;
            // Ensure meetingId is set
            guest.meetingId = line.meeting_id;
        }
    });
};


const focusSearchInput = () => {
    if (searchMember.value) {
        searchMember.value.focus();
    }
};

const value = ref('0'); // Set default tab value to '0'

// On mounted lifecycle hook
onMounted(() => {
    initializeMemberData();
    initializeGuestData();
    // focusSearchInput();
});
</script>


<template>
    <Head :title="`Meeting ${meeting.meeting_no}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Meeting {{ meeting.meeting_no }} </h2>
        </template>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">

            <div class="flex justify-end gap-2 mb-2">
                <Button @click="value = '0'" rounded label="1" class="w-8 h-8 p-0" :outlined="value !== '0'" />
                <Button @click="value = '1'" rounded label="2" class="w-8 h-8 p-0" :outlined="value !== '1'" />
                <Button @click="value = '2'" rounded label="3" class="w-8 h-8 p-0" :outlined="value !== '2'" />
            </div>

            <Tabs v-model:value="value">
                <TabList>
                    <Tab value="0">Members</Tab>
                    <Tab value="1">Guests</Tab>
                    <Tab value="2">Stats</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Toolbar>
                            <template #center>

                                 <InputText placeholder="Search" v-model="searchMember"/>

                            </template>
                        </Toolbar>
                         <DataTable :value="filteredMembers" dataKey="id">
                                <Column field="name" header="Member Name"></Column>
                                <Column field="phone" header="Phone Number"></Column>
                                <Column field="email" header="Email"></Column>
                                <Column header="Attended?">
                                    <template #body="{ data }">
                                        <input type="checkbox" v-model="data.attended" @change="updateAttendance(data.id, data.attended, 'member')" />
                                    </template>
                                </Column>
                                <Column header="Score">
                                    <template #body="{ data }">
                                        <InputText size="small" style="width: 40px;" v-model="data.score" @input="updateScore(data.id, data.score, 'member')" />
                                    </template>
                                </Column>
                                 <!-- From Column -->
                                <Column header="From">
                                    <template #body="{ data }">
                                        <InputText
                                            v-model="data.attendedFrom"
                                            :placeholder="'18:00'"
                                            size="small"
                                            @input="updateAttendance(data.id, data.attended, data.user_type, data.attendedFrom, data.attendedTo)"
                                        />
                                    </template>
                                </Column>
                                <!-- To Column -->
                                <Column header="To">
                                    <template #body="{ data }">
                                        <InputText
                                            v-model="data.attendedTo"
                                            :placeholder="'20:00'"
                                            size="small"
                                            @input="updateAttendance(data.id, data.attended, data.userType, data.attendedFrom, data.attendedTo)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                    </TabPanel>
                    <TabPanel value="1">
                          <Toolbar>
                            <template #center>

                                 <InputText placeholder="Search" v-model="searchGuest"/>

                            </template>
                        </Toolbar>
                         <DataTable :value="filteredGuests" dataKey="id">
                                <Column field="name" header="Guest Name"></Column>
                                <Column field="phone" header="Phone Number"></Column>
                                <Column field="email" header="Email"></Column>
                                <Column header="Attended?">
                                    <template #body="{ data }">
                                        <input type="checkbox" v-model="data.attended" @change="updateAttendance(data.id, data.attended, 'guest')" />
                                    </template>
                                </Column>
                                <Column header="Score">
                                    <template #body="{ data }">
                                        <InputText size="small" style="width: 40px;" v-model="data.score" @input="updateScore(data.id, data.score, 'guest')" />
                                    </template>
                                </Column>
                                 <!-- From Column -->
                                <Column header="From">
                                    <template #body="{ data }">
                                        <InputText
                                            v-model="data.attendedFrom"
                                            :placeholder="'18:00'"
                                            size="small"
                                            @input="updateAttendance(data.id, data.attended, data.user_type, data.attendedFrom, data.attendedTo)"
                                        />
                                    </template>
                                </Column>
                                <!-- To Column -->
                                <Column header="To">
                                    <template #body="{ data }">
                                        <InputText
                                            v-model="data.attendedTo"
                                            :placeholder="'20:00'"
                                            size="small"
                                            @input="updateAttendance(data.id, data.attended, data.userType, data.attendedFrom, data.attendedTo)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                    </TabPanel>
                    <TabPanel value="2">
                        <p class="m-0">
                            At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa
                            qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                        </p>
                    </TabPanel>
                </TabPanels>
            </Tabs>

            </div>
        </div>
    </AuthenticatedLayout>


</template>



