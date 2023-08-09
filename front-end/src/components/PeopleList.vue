<template>
  <div class="container">
    <HeaderComponent message="Listagem de Pessoas" />
    <LoadingSpinner :active="loaderActive" text="Carregando pessoas..." />
    <div class="card">
      <div class="lista">
          <table class="table table-bordered" v-if="!loaderActive">
            <tr>
              <th>Cadastro</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>RG</th>
              <th>Data de nascimento</th>
              <th>sexo</th>
              <th>Data de cadastro</th>
              <th>&nbsp;</th>
              <th><router-link :to="{ name: 'save' }" class="btn btn-success" >Cadastrar Pessoa</router-link></th>
            </tr>
            <tr v-for="person in people" v-bind:key="person.id">
              <td>{{ person.id  }}</td>
              <td>{{ person.name  }}</td>
              <td>{{ formatCPF(person.cpf)  }}</td>
              <td>{{ person.rg  }}</td>
              <td>{{ formatDate(person.birth_date) }}</td>
              <td>{{ person.sex.name  }}</td>
              <td>{{ formatDateTime(person.created_at) }}</td>
              <!--<td><button class="info" @click="showPerson(person)">Editar</button></td>-->
              <td><router-link :to="{ name: 'save', params: {
                 isEdit: true, 
                  id: person.id,
                  name: person.name,
                  cpf: person.cpf,
                  rg: person.rg,
                  birth_date: person.birth_date,
                  sex_id: person.sex.id
                 } }" 
                  class="btn btn-info">Editar</router-link></td>
              <td><button type="button" class="btn btn-danger" @click="deletePerson(person.id, person.name)">Deletar</button></td>
            </tr>
          </table>
          <hr>
          <div class="pagination">
            <a
              class="pagination-link"
              href="#"
              @click="fetchPeople(pagination.prev)"
              v-if="pagination.prev"
            >
              <span>&lt;</span>
            </a>
            <span class="pagination-info">
              Página {{ pagination.current_page }} de {{ pagination.last_page }}
            </span>
            <a
              class="pagination-link"
              href="#"
              @click="fetchPeople(pagination.next)"
              v-if="pagination.next"
            >
            <span>&gt;</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</template>

<script>

import LoadingSpinner from './LoadingSpinner.vue'
import HeaderComponent from './HeaderComponent.vue'

export default {
  name: 'PeopleList',
  components: {
    LoadingSpinner,
    HeaderComponent
  },
  //mixins: [loaderMixin],
  data(){
    return {
      people: [],
      loaderActive: true,
      person: {
            id: '',
            name: '',
            cpf: '',
            rg: '',
            sex_id: '',
            birth_date: '',
        },
      pagination: {}
    }
  },
  methods: {
    fetchPeople( url ){
      let virtual = this
      this.showLoader();
      url = url || 'http://127.0.0.1:8081/person'
      fetch(url)
        .then(res => res.json())
        .then(res => {
          this.people = res.data.data
          virtual.paginate(res.data)
          this.hideLoader();
        })
        
    }, 
    paginate(data)
    {
      
        let pagination = {
          current_page: data.current_page,
          last_page: data.last_page,
          next: data.next_page_url,
          prev: data.prev_page_url
        }
        this.pagination = pagination
    },
    formatCPF(cpf) {
      if (cpf) {
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
      } else {
        return '';
      }
    },
    formatDate(date) {
      if (date) {
        const parsedDate = new Date(date);
        const day = parsedDate.getDate().toString().padStart(2, '0');
        const month = (parsedDate.getMonth() + 1).toString().padStart(2, '0');
        const year = parsedDate.getFullYear();
        return `${day}/${month}/${year}`;
      } else {
        return '';
      }
    },
    formatDateTime(dateTime) {
      if (dateTime) {
        const parsedDateTime = new Date(dateTime);
        const day = parsedDateTime.getDate().toString().padStart(2, '0');
        const month = (parsedDateTime.getMonth() + 1).toString().padStart(2, '0');
        const year = parsedDateTime.getFullYear();
        const hours = parsedDateTime.getHours().toString().padStart(2, '0');
        const minutes = parsedDateTime.getMinutes().toString().padStart(2, '0');
        return `${day}/${month}/${year} ${hours}:${minutes}`;
      } else {
        return '';
      }
    },
    deletePerson( id, name )
    {
      if(confirm('Deseja excluir '+name+'?'))
      {
        this.showLoader()
        fetch('http://127.0.0.1:8081/person/'+id,{
            method: 'DELETE'
        })
        .then( res => res.json() )
        .then(()=>{
          alert('Pessoa excluida com sucesso')
          this.fetchPeople()
        })
        .catch( err => console.log( err ))
        
      }
    },
    showLoader () {
      this.loaderActive = true;
    },
    hideLoader () {
      this.loaderActive = false;
    },

  },
  created(){
    this.fetchPeople()
  }
}
</script>

<style scoped>

.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-top: 20px;
}

.lista {
  overflow-x: auto;
}

.table-container {
  max-width: 100%;
  overflow-x: auto;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 12px;
  text-align: left;
}

.table th {
  background-color: #f2f2f2;
  font-weight: bold;
  color: #333;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination-link {
  display: inline-block;
  padding: 8px 12px;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin: 0 5px;
  text-decoration: none;
  transition: background-color 0.2s, color 0.2s, border-color 0.2s;
}

.pagination-link:hover {
  background-color: #f0f0f0;
  color: #666;
  border-color: #999;
}

.pagination-info {
  font-size: 16px;
  margin: 0 10px;
}

/* Adicione o ícone FontAwesome para as setas */
.pagination-link i {
  font-size: 14px;
}
</style>
