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
import CadastroDespesaIndividual from '../views/eventos/CadastroDespesaIndividual.vue'; 
import Login from "../views/cadastro/Login.vue";
import CadastroUsuario from "../views/cadastro/CadastroUsuario.vue";
 

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Home,
    children: [
      { path: "/", component: Login, meta: { title: 'Login' } },
      { path: '/home', name: 'Home', component: Home },
      { path: '/cadastro-evento', name: 'CadastroEventos', component: CadastroEvento },
      { path: '/eventos', name: 'ListaEventos', component: ListaEventos },
      { path: '/cadastro-evento', name: 'CadastroEvento', component: CadastroEvento },
      { path: '/gerenciar-eventos', name: 'GerenciarEventos', component: GerenciarEventos},
      { path: '/listar-eventos', name: 'ListaEventos', component: ListaEventos },
      { path: '/seus-eventos', name: 'SeusEventos', component: SeusEventos },
      { path: '/evento/:id/editar', name: 'EditarEvento', component: EditarEvento },
      { path: '/evento/:id/detalhes', name: 'DetalhesEvento', component: DetalhesEvento},
      { path: '/evento/enviar-convites', name: 'EnviarConvites', component: EnviarConvites},
      { path: '/evento/enviar-lembrete', name: 'EnviarLembrete', component: EnviarLembrete},
      { path: '/evento/cadastrar-despesas', name: 'CadastrarDespesas', component: CadastrarDespesas},
      { path: '/evento/gerenciar-despesas', name: 'GerenciarDespesas', component: GerenciarDespesas},
      { path: '/evento/visualizar-presencas', name: 'VisualizarPresencas', component: VisualizarPresencas},
      { path: '/evento/cobrar-finalizar', name: 'CobrarFinalizar', component: CobrarFinalizar},
      { path: '/listar-despesas', name: 'ListarDespesas', component: ListarDespesas },
      { path: '/editar-despesas', name: 'EditarDespesas', component: EditarDespesas },
      { path: 'cobranca-finalizacao', name: 'FinalizarEvento', component: FinalizarEvento },
      { path: '/pagamento-pix', name: 'PagamentoPix', component: PagamentoPix },
      { path: '/lista-presenca', name: 'ListaPresenca', component: ListaPresenca },
      { path: '/registro-evento', name: 'RegistrarEvento', component: RegistrarEvento },
      { path: '/cancelar-participacao', name: 'CancelarParticipacao', component: CancelarParticipacao },
      { path: '/cadastro-despesa-individual', name: 'CadastroDespesaIndividual', component: CadastroDespesaIndividual }, 
      { path: "/cadastro-usuario", component: CadastroUsuario },
    ],
  }
  
];

const router = new VueRouter({
  mode: 'history',
  routes,
});

export default router;
