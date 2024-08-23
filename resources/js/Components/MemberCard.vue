<template>
    <div>
        <div class="w-full max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 pt-4"></div>
            <div class="flex flex-col items-center pb-5" v-if="m.id > 0">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" :src="m.avatar" alt="Bonnie image">
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ m.name }}</h5>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ m.classification }}</span>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ m.member_no }}</span>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ m.nationality }}</span>
                <div class="flex mt-4 space-x-3 lg:mt-6">
                    <Link :href="route('members.show', m.id)">
                        <Button icon="pi pi-user" class="p-button-rounded p-button-info" />
                    </Link>

                    <Button icon="pi pi-pencil" class="p-button-rounded p-button-secondary" @click="emitUpdate" />

                    <Drop :dropRoute="route('members.destroy', m.id)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import Drop from '@/Components/Drop.vue';

const props = defineProps({
    member: Object,
});

const emits = defineEmits(['update-member']);

const m = ref({});

onMounted(() => {
    if (props.member.id > 0) {
        m.value = props.member;
    }
});

const emitUpdate = () => {
    emits('update-member', m.value);
};
</script>
