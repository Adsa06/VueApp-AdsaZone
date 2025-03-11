import { createRouter, createWebHistory } from 'vue-router';
import ControladorRegistroLogin from './components/SistemaRegistroLogin/ControladorRegistroLogin.vue';
import Principal from './components/Principal.vue';
import MenuPrincipal from './components/MenuPrincipal/MenuPrincipal.vue';
import ListaTareas from './components/ListaTareas/ListaTareas.vue';
import Perfil from './components/PerfilConfig/Perfil.vue';
import ConfigCuenta from './components/PerfilConfig/ConfigCuenta.vue';
import ShopList from './components/Tienda/ShopList.vue';

const routes = [
  { path: '/', component: ControladorRegistroLogin },
  { path: '/home', component: Principal, children: [{ path: '', component: MenuPrincipal }] },
  { path: '/task-list', component: Principal, children: [{ path: '', component: ListaTareas }] },
  { path: '/profile', component: Principal, children: [{ path: '', component: Perfil }] },
  { path: '/config', component: Principal, children: [{ path: '', component: ConfigCuenta }] },
  { path: '/shop', component: Principal, children: [{ path: '', component: ShopList }] },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;