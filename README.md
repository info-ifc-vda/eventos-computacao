# EventIF - Gerenciamento de Eventos

## 🚀 Sobre o projeto

Projeto para gerenciamento de eventos, desenvolvido para fins acadêmicos no IFC Campus Videira. Esta aplicação backend oferece API REST para criação, consulta e manipulação de eventos, com controle de usuários e papéis.
O frontend é desenvolvido em Vue.js e faz o gerenciamento de eventos, permitindo que usuários criem, editem e visualizem eventos de forma intuitiva.

## 📦 Tecnologias Utilizadas

- **Backend:** Laravel, PHP
- **Frontend:** Vue.js
- **Banco de Dados:** PostgreSQL
- **Containerização:** Docker
- **Documentação:** Swagger
- **Autenticação:** JWT (JSON Web Tokens)
- **Gerenciamento de Dependências:** Composer
- **Gerenciamento de Pacotes:** NPM

---

## ⚙️ Instalação e Configuração

Siga os passos abaixo para configurar e executar o projeto localmente usando Docker:

1. **Copie os arquivos de ambiente e configuração:**

```bash
cp .env.example .env
cp docker-compose.dev.yml.example docker-compose.yml
```

2. **Inicie os containers Docker:**

```bash
docker compose up -d --build
```

3. **Instale as dependências do backend e configure o Laravel:**

```bash
docker compose exec api composer install
docker compose exec api cp .env.example .env
docker compose exec api php artisan key:generate
docker compose exec api php artisan migrate --force
docker compose exec api php artisan passport:keys -q
```

4. **(Opcional) Popule o banco de dados com usuários de teste:**

```bash
docker compose exec api php artisan db:seed
```

> ⚠️ _Execute este comando apenas uma vez para evitar registros duplicados._

**Usuários criados automaticamente:**

| Email                                                     | Senha      | Papel              |
| --------------------------------------------------------- | ---------- | ------------------ |
| [admin@gmail.com](mailto:admin@gmail.com)                 | Senha123\$ | Administrador      |
| [event_creator@gmail.com](mailto:event_creator@gmail.com) | Senha123\$ | Criador de eventos |
| [common_user@gmail.com](mailto:common_user@gmail.com)     | Senha123\$ | Usuário comum      |

---

## 🌐 Acesso à aplicação

Após subir os containers, a API estará disponível em:

```
http://eventos.fsw-ifc.brdrive.localhost/api/v1/events
```

> **Nota:** Em ambiente de desenvolvimento, o HTTPS não está configurado. Se houver erros de conexão, verifique se você está usando HTTP ao invés de HTTPS.

---

## 💻 Dicas para desenvolvimento Frontend

- O Hot Module Reload (HMR) pode não funcionar no Windows.
- Para evitar problemas, recomendamos usar **WSL** (Windows Subsystem for Linux) ou um sistema Linux nativo durante o desenvolvimento frontend.

---

## 📚 Documentação da API

Para gerar a documentação Swagger da API, rode:

```bash
docker compose exec api php artisan generate:docs
```

A documentação estará disponível em:

```
http://eventos.fsw-ifc.brdrive.localhost/swagger
```

> ⚠️ Recomendamos rodar este comando após cada pull para manter a documentação atualizada.

---

## 👥 Colaboradores

Agradecemos a todos que colaboraram com este projeto:

<p>
  <a href="https://github.com/WesleyLamb" title="WesleyLamb">
    <img src="https://avatars.githubusercontent.com/u/42122789?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="WesleyLamb" />
  </a>
  <a href="https://github.com/thalesfb" title="thalesfb">
    <img src="https://avatars.githubusercontent.com/u/15121152?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="thalesfb" />
  </a>
  <a href="https://github.com/valdirjunior" title="valdirjunior">
    <img src="https://avatars.githubusercontent.com/u/84672289?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="valdirjunior" />
  </a>
  <a href="https://github.com/FranciscoAugusto1238" title="FranciscoAugusto1238">
    <img src="https://avatars.githubusercontent.com/u/94983875?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="FranciscoAugusto1238" />
  </a>
  <a href="https://github.com/matheuswogt37" title="matheuswogt37">
    <img src="https://avatars.githubusercontent.com/u/107137623?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="matheuswogt37" />
  </a>
  <a href="https://github.com/IarlaBrito" title="IarlaBrito">
    <img src="https://avatars.githubusercontent.com/u/108465665?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="IarlaBrito" />
  </a>
  <a href="https://github.com/SrPatsu21" title="SrPatsu21">
    <img src="https://avatars.githubusercontent.com/u/109459945?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="SrPatsu21" />
  </a>
  <a href="https://github.com/maiconda" title="maiconda">
    <img src="https://avatars.githubusercontent.com/u/111695088?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="maiconda" />
  </a>
  <a href="https://github.com/henriqueprdlm" title="henriqueprdlm">
    <img src="https://avatars.githubusercontent.com/u/116076857?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="henriqueprdlm" />
  </a>
  <a href="https://github.com/CarolinaChagas" title="CarolinaChagas">
    <img src="https://avatars.githubusercontent.com/u/116077162?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="CarolinaChagas" />
  </a>
  <a href="https://github.com/thierry-msm" title="thierry-msm">
    <img src="https://avatars.githubusercontent.com/u/125670181?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="thierry-msm" />
  </a>
  <a href="https://github.com/wellingtonEliel" title="wellingtonEliel">
    <img src="https://avatars.githubusercontent.com/u/127947048?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="wellingtonEliel" />
  </a>
  <a href="https://github.com/felipebfava" title="felipebfava">
    <img src="https://avatars.githubusercontent.com/u/129697196?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="felipebfava" />
  </a>
  <a href="https://github.com/JedielSantos" title="JedielSantos">
    <img src="https://avatars.githubusercontent.com/u/130990281?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="JedielSantos" />
  </a>
  <a href="https://github.com/OtavioOLDG" title="OtavioOLDG">
    <img src="https://avatars.githubusercontent.com/u/131627256?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="OtavioOLDG" />
  </a>
  <a href="https://github.com/igupz" title="igupz">
    <img src="https://avatars.githubusercontent.com/u/138035194?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="igupz" />
  </a>
  <a href="https://github.com/Nogssz" title="Nogssz">
    <img src="https://avatars.githubusercontent.com/u/138179288?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="Nogssz" />
  </a>
  <a href="https://github.com/Alex6W2B" title="Alex6W2B">
    <img src="https://avatars.githubusercontent.com/u/138224286?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="Alex6W2B" />
  </a>
  <a href="https://github.com/thiagoluiz2711" title="thiagoluiz2711">
    <img src="https://avatars.githubusercontent.com/u/138491725?v=4" width="60" height="60" style="border-radius:50%; margin:5px" alt="thiagoluiz2711" />
  </a>
</p>

<!-- | Avatar                                                                                                               | Nome de Usuário                                                     | Papel       |
| -------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- | ----------- |
| <img src="https://avatars.githubusercontent.com/u/42122789?v=4" width="60" height="60" alt="WesleyLamb" />           | [**WesleyLamb**](https://github.com/WesleyLamb)                     | Admin       |
| <img src="https://avatars.githubusercontent.com/u/15121152?v=4" width="60" height="60" alt="thalesfb" />             | [**thalesfb**](https://github.com/thalesfb)                         | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/84672289?v=4" width="60" height="60" alt="valdirjunior" />         | [**valdirjunior**](https://github.com/valdirjunior)                 | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/94983875?v=4" width="60" height="60" alt="FranciscoAugusto1238" /> | [**FranciscoAugusto1238**](https://github.com/FranciscoAugusto1238) | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/107137623?v=4" width="60" height="60" alt="matheuswogt37" />       | [**matheuswogt37**](https://github.com/matheuswogt37)               | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/108465665?v=4" width="60" height="60" alt="IarlaBrito" />          | [**IarlaBrito**](https://github.com/IarlaBrito)                     | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/109459945?v=4" width="60" height="60" alt="SrPatsu21" />           | [**SrPatsu21**](https://github.com/SrPatsu21)                       | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/111695088?v=4" width="60" height="60" alt="maiconda" />            | [**maiconda**](https://github.com/maiconda)                         | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/116076857?v=4" width="60" height="60" alt="henriqueprdlm" />       | [**henriqueprdlm**](https://github.com/henriqueprdlm)               | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/116077162?v=4" width="60" height="60" alt="CarolinaChagas" />      | [**CarolinaChagas**](https://github.com/CarolinaChagas)             | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/125670181?v=4" width="60" height="60" alt="thierry-msm" />         | [**thierry-msm**](https://github.com/thierry-msm)                   | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/127947048?v=4" width="60" height="60" alt="wellingtonEliel" />     | [**wellingtonEliel**](https://github.com/wellingtonEliel)           | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/129697196?v=4" width="60" height="60" alt="felipebfava" />         | [**felipebfava**](https://github.com/felipebfava)                   | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/130990281?v=4" width="60" height="60" alt="JedielSantos" />        | [**JedielSantos**](https://github.com/JedielSantos)                 | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/131627256?v=4" width="60" height="60" alt="OtavioOLDG" />          | [**OtavioOLDG**](https://github.com/OtavioOLDG)                     | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/138035194?v=4" width="60" height="60" alt="igupz" />               | [**igupz**](https://github.com/igupz)                               | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/138179288?v=4" width="60" height="60" alt="Nogssz" />              | [**Nogssz**](https://github.com/Nogssz)                             | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/138224286?v=4" width="60" height="60" alt="Alex6W2B" />            | [**Alex6W2B**](https://github.com/Alex6W2B)                         | Colaborador |
| <img src="https://avatars.githubusercontent.com/u/138491725?v=4" width="60" height="60" alt="thiagoluiz2711" />      | [**thiagoluiz2711**](https://github.com/thiagoluiz2711)             | Colaborador | -->

---

## 🙌 Agradecimentos

Este projeto é fruto do esforço conjunto de estudantes, professores e colaboradores do IFC Campus Videira. Cada contribuição foi fundamental para o desenvolvimento desta iniciativa.
