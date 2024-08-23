<template>
    <Head :title="`${member.member_no}|${member.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{member.member_no}}|{{member.name}} </h2>
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
                    <Tab value="0">Attendance</Tab>
                    <Tab value="1">Details</Tab>

                    <Tab value="2">Financials</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Toolbar>
                            <template #center>

                                 <InputText placeholder="Search" v-model="searchTerm"/>

                            </template>
                        </Toolbar>
                         <DataTable :value="filteredMeetings" dataKey="id">
                                <Column field="meeting.meeting_no" header="Meeting No."></Column>
                                <Column field="meeting.date" header="Meeting Date"></Column>
                                <Column field="meeting.topic" header="Topic"></Column>
                                <Column field="meeting.host" header="Host"></Column>
                                <Column field="meeting.venue" header="Venue"></Column>
                                <Column field="score" header="Score"></Column>
                            </DataTable>
                    </TabPanel>
                    <TabPanel value="1">
                      Details
                    </TabPanel>
                    <TabPanel value="2">
                       Financial
                    </TabPanel>
                </TabPanels>
            </Tabs>

            </div>
        </div>
    </AuthenticatedLayout>


</template>


<script setup>
import { ref,defineProps,computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import PieChart from '@/Components/PieChart.vue';
import Swal from 'sweetalert2';

const props=defineProps(['member','meeting_lines'])
const meetingLinesArray=ref([...props.meeting_lines]);
const searchTerm=ref('');
const filterMeetings = (searchTerm,meetingLinesArray) => {
    if (meetingLinesArray.value.length>0)
    {
        const lowercasedSearchTerm = searchTerm.value.toLowerCase();
            return meetingLinesArray.value.filter(m =>
                m.meeting.meeting_no.toLowerCase().includes(lowercasedSearchTerm) ||
                m.meeting.host.toLowerCase().includes(lowercasedSearchTerm) ||
                m.meeting.topic.toLowerCase().includes(lowercasedSearchTerm)||
                m.meeting.venue.toLowerCase().includes(lowercasedSearchTerm)
            );
        }
        else return [];

    };




const filteredMeetings = computed(() => filterMeetings(searchTerm,meetingLinesArray));


</script>
