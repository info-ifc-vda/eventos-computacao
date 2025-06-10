import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/home/HomeTela.vue';
import FinalizarEvento from '../views/cobrancafinalizacao/FinalizarEvento.vue';
import CadastroEvento from '../views/eventos/CadastrarEvento.vue';
import ListaEventos from '../views/eventos/Eventos.vue';
import GerenciarEventos from '../views/evento/GerenciarEventos.vue';
import SeusEventos from '../views/evento/SeusEventos.vue';
import EditarEvento from '../views/evento/EditarEvento.vue';
import DetalhesEvento from '../views/evento/DetalhesEvento.vue';
import EnviarConvites from '../views/evento/EnviarConvites.vue';
import EnviarLembrete from '../views/evento/EnviarLembrete.vue';
import CadastrarDespesas from '../views/evento/CadastrarDespesas.vue';
import GerenciarDespesas from '../views/evento/GerenciarDespesas.vue';
import VisualizarPresencas from '../views/evento/VisualizarPresencas.vue';
import CobrarFinalizar from '../views/evento/CobrarFinalizar.vue';
import ListarDespesas from '@/views/eventos/ListarDespesas.vue';
import EditarDespesas from '@/views/eventos/EditarDespesas.vue';
import ListaPresenca from '../views/pagamento/ListaPresenca.vue';
import PagamentoPix from '../views/pagamento/PagamentoPix.vue';
import CancelarParticipacao from '../views/eventos/CancelarParticipacao.vue';
import RegistrarEvento from '../views/eventos/RegistrarEvento.vue';
import Login from "../views/cadastro/Login.vue";
import CadastroUsuario from "../views/cadastro/CadastroUsuario.vue";
import UsuarioService from '@/services/UsuarioService';
import { JWT_TOKEN_KEY } from '@/constants'; // importe a constante do token



Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Home,
    children: [
      {
        path: "/", component: Login, meta: { title: 'Login' }, beforeEnter: (to, from, next) => {
          const token = localStorage.getItem(JWT_TOKEN_KEY);
          if (token) return next({ path: '/home' });
          next();
        }
      },
      { path: '/home', name: 'Home', component: ListaEventos },
      { path: '/eventos', name: 'ListaEventos', component: ListaEventos, meta: { title: 'Lista de Eventos', requiresAuth: true } },
      { path: '/cadastro-evento/:id?', name: 'CadastroEvento', component: CadastroEvento, meta: { title: 'Cadastro de Evento', requiresAuth: true } },
      { path: '/gerenciar-eventos', name: 'GerenciarEventos', component: GerenciarEventos, meta: { title: 'Gerenciar Eventos', requiresAuth: true } },
      { path: '/listar-eventos', name: 'ListaEventos', component: ListaEventos },
      { path: '/seus-eventos', name: 'SeusEventos', component: SeusEventos, requiresAuth: true },
      { path: '/evento/:id/editar', name: 'EditarEvento', component: EditarEvento, requiresAuth: true },
      { path: '/evento/:id/detalhes', name: 'DetalhesEvento', component: DetalhesEvento, requiresAuth: true },
      { path: '/evento/enviar-convites', name: 'EnviarConvites', component: EnviarConvites, requiresAuth: true },
      { path: '/evento/enviar-lembrete', name: 'EnviarLembrete', component: EnviarLembrete, requiresAuth: true },
      { path: '/evento/cadastrar-despesas', name: 'CadastrarDespesas', component: CadastrarDespesas, requiresAuth: true },
      { path: '/evento/gerenciar-despesas', name: 'GerenciarDespesas', component: GerenciarDespesas, requiresAuth: true },
      { path: '/evento/visualizar-presencas', name: 'VisualizarPresencas', component: VisualizarPresencas, requiresAuth: true },
      { path: '/evento/cobrar-finalizar', name: 'CobrarFinalizar', component: CobrarFinalizar, requiresAuth: true },
      { path: '/listar-despesas', name: 'ListarDespesas', component: ListarDespesas, requiresAuth: true },
      { path: '/editar-despesas', name: 'EditarDespesas', component: EditarDespesas, requiresAuth: true },
      { path: 'cobranca-finalizacao', name: 'FinalizarEvento', component: FinalizarEvento, requiresAuth: true },
      { path: '/pagamento-pix', name: 'PagamentoPix', component: PagamentoPix, requiresAuth: true },
      { path: '/lista-presenca', name: 'ListaPresenca', component: ListaPresenca, requiresAuth: true },
      { path: '/registro-evento', name: 'RegistrarEvento', component: RegistrarEvento, requiresAuth: true },
      { path: '/cancelar-participacao', name: 'CancelarParticipacao', component: CancelarParticipacao, requiresAuth: true },
      {path: '/evento/:id/cadastro-despesa-individual', name: 'CadastroDespesaIndividual', component: () => import('../views/eventos/CadastroDespesaIndividual.vue')},
      { path: "/cadastro-usuario", component: CadastroUsuario },
      { path: "/login", component: Login },
    ],
  }

];

const router = new VueRouter({
  mode: 'history',
  routes,
});

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem(JWT_TOKEN_KEY);
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth) {
    if (!token) {
      // Não tem token, redireciona pro login
      return next({ path: '/' });
    }

    try {
      // Tenta fazer refresh do token para validar e renovar
      await UsuarioService.refresh();
      // Se passar, continua na rota
      next();
    } catch (error) {
      // Token inválido ou refresh falhou: limpa token e redireciona para login
      localStorage.removeItem(JWT_TOKEN_KEY);
      next({ path: '/' });
    }
  } else {
    // Rota que não precisa de login
    next();
  }
});

export default router;
