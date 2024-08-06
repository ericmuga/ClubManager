<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props=defineProps({meeting:Object,members:Object,guests:Object,meeting_lines:Object});


</script>


<template>
    <Head :title="`Meeting ${meeting.meeting_no}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Meeting {{ meeting.meeting_no }} </h2>
        </template>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">

            <div class="flex mb-2 gap-2 justify-end">
                <Button @click="value = '0'" rounded label="1" class="w-8 h-8 p-0" :outlined="value !== '0'" />
                <Button @click="value = '1'" rounded label="2" class="w-8 h-8 p-0" :outlined="value !== '1'" />
                <Button @click="value = '2'" rounded label="3" class="w-8 h-8 p-0" :outlined="value !== '2'" />
            </div>

            <Tabs v-model:value="value">
                <TabList>
                    <Tab value="0">Header I</Tab>
                    <Tab value="1">Header II</Tab>
                    <Tab value="2">Header III</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <p class="m-0">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </TabPanel>
                    <TabPanel value="1">
                        <p class="m-0">
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                            ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
                        </p>
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



