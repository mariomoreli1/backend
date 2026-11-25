// ЛР11. Создаёт Vue-приложение и монтирует компонент App.vue в #app.
import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue';

const app = createApp(App);

app.mount('#app');
