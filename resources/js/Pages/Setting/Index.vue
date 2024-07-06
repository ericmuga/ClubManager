<template>
    <div>
        <h1>Change Log Settings</h1>
        <form @submit.prevent="updateSettings">
            <div v-for="setting in settings" :key="setting.id" class="form-group">
                <label>{{ setting.table_name }} - {{ setting.field_name }}</label>
                <input type="checkbox" v-model="setting.log_changes">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        settings: Array,
    },
    methods: {
        updateSettings() {
            this.settings.forEach(setting => {
                Inertia.post(`/settings/${setting.id}`, setting);
            });
        },
    },
};
</script>
