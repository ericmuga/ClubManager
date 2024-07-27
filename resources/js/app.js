import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// primevue components
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
// import 'primevue/resources/themes/lara-light-indigo/theme.css';
// import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import MultiSelect from 'primevue/multiselect';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
// import Pagination from '@/Components/Pagination.vue'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Tooltip from 'primevue/tooltip';
import Checkbox from 'primevue/checkbox';
import DatePicker from 'primevue/datePicker';
import DataTable from 'primevue/datatable';
import Select from 'primevue/select';
import Password from 'primevue/password';
import Badge from 'primevue/badge';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';

///end of primevue components

const appName = import.meta.env.VITE_APP_NAME || 'Club Manager';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura
                }
             })
            .component('ToolBar',Toolbar)
            .component('Checkbox',Checkbox)
            .component('Button',Button)
            .component('InputText',InputText)
            .component('Dialog',Dialog)
            .component('InputNumber',InputNumber)
            .directive('Tooltip',Tooltip)
            .component('MultiSelect',MultiSelect)
            .component('Select',Select)
            .component('FileUpload',FileUpload)
            // .component('Pagination',Pagination)
            // .component('SearchBox',SearchBox)
            .component('DatePicker',DatePicker)
            .component('DataTable',DataTable)
            .component('Password',Password)
            .component('Badge',Badge)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
