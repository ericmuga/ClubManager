import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// primevue components
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css';
import MultiSelect from 'primevue/multiselect';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Tooltip from 'primevue/tooltip';
import Checkbox from 'primevue/checkbox';
// import DatePicker from 'primevue/datePicker';
import DataTable from 'primevue/datatable';
import Select from 'primevue/select';
import Password from 'primevue/password';
import Badge from 'primevue/badge';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';


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
             .use(ToastService)

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
            // .component('DatePicker',DatePicker)
            .component('DataTable',DataTable)
            .component('Password',Password)
            .component('Badge',Badge)
            .component('Tab',Tab)
            .component('Tabs',Tabs)
            .component('TabList',TabList)
            .component('TabPanels',TabPanels)
            .component('TabPanel',TabPanel)
            .component('Accordion',Accordion)
            .component('AccordionPanel',AccordionPanel)
            .component('AccordionHeader',AccordionHeader)
            .component('AccordionContent',AccordionContent)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
