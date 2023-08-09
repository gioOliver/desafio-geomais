<template>
    <div class="form-container">
        <HeaderComponent v-if="edit" message="Editar Pessoa" />
        <HeaderComponent v-else message="Cadastrar Pessoa " />
        <LoadingSpinner :active="loaderActive" text="Carregando pessoas..." />
        <form action="">
            <p>
                Nome 
                <input type="text" v-model="modelPerson.name">
            </p> 
            <p>
                CPF 
                <input type="text" v-mask="'###.###.###-##'" v-model="modelPerson.cpf">
            </p>
            <p>
                RG
                <input type="text" v-model="modelPerson.rg">
            </p>
            <p>
                Data de nascimento
                <input type="date" v-model="modelPerson.birth_date">
            </p>
            <p>
                Sexo
                <select v-model="modelPerson.sex_id">
                    <option value="" disabled>Selecione</option>
                    <option v-for="option in sexOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
                </select>
            </p>
            <input type="hidden" v-model="modelPerson.id">

            <button type="button" @click="back" class="btn btn-secondary">Voltar</button> 
            <button  type="button" v-if="edit" class="btn btn-info" @click="editPerson">Editar</button>
            <button   type="button" v-else class="btn btn-success" @click="storePerson">Cadastrar</button>
        </form>
    </div>
</template>

<script>
import LoadingSpinner from './LoadingSpinner.vue'
import HeaderComponent from './HeaderComponent.vue'
export default {
  name: 'PersonForm',
  props: {
        isEdit: Boolean,
        id: Number,
        name: String,
        cpf: String,
        rg: String,
        birth_date: String,
        sex_id: Number
    },
  components: {
    LoadingSpinner,
    HeaderComponent
  },
  data(){
    return{
        loaderActive: true,
        modelPerson: { 
            id: this.$route.params.id,
            name: this.$route.params.name,
            cpf: this.$route.params.cpf,
            rg: this.$route.params.rg,
            birth_date:this.formatDate(this.$route.params.birth_date),
            sex_id: this.$route.params.sex_id
         },
         edit: this.$route.params.isEdit,
         sexOptions: []
    }
  },
  methods: {
    formatDate(dateString) {
        if ( !dateString )
        {
            return ''
        }
        const dateParts = dateString.split(' ')[0].split('-');
        const formattedDate = `${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`;
        return formattedDate;
    },
    storePerson()
    {
        this.showLoader()
        fetch('http://127.0.0.1:8081/person',{
            
            method: 'POST',
            body: JSON.stringify(this.modelPerson),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then( res => res.json() )
        .then(data => {
            if (data.success) {
                alert('Dados cadastrados com sucesso');
                this.$router.push({ name: 'home' });
            } else {
                alert('Erro ao cadastrar dados: ' + data.errors[0].message);
            }
            this.hideLoader();
            })
            .catch(error => {
                console.error('Erro ao carregar opções de sexo:', error);
                this.hideLoader();
            });
        
    },
    editPerson( )
    {
        this.showLoader()
        fetch('http://127.0.0.1:8081/person/'+this.modelPerson.id,{
            
            method: 'PUT',
            body: JSON.stringify(this.modelPerson),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then( res => res.json() )
        .then(data => {
            if (data.success) {
                alert('Dados atualizados com sucesso');
                this.$router.push({ name: 'home' });
            } else {
                alert('Erro ao atualizar dados: ' + data.errors[0].message);
            }
            this.hideLoader();
        })
        .catch( err => console.log( err ))
        
      
    },
    loadSexOptions() {
        this.showLoader()
        fetch('http://127.0.0.1:8081/sex') 
        .then(response => response.json())
        .then(data => {
            this.sexOptions = data; 
            this.hideLoader()
        })
        .catch(error => {
            console.error('Erro ao carregar opções de sexo:', error);
            this.hideLoader();
        });
    },
    back() {
        this.$router.push({ name: 'home' });
    },
    showLoader () {
      this.loaderActive = true;
    },
    hideLoader () {
      this.loaderActive = false;
    },
  },
  created()
  {
    this.loadSexOptions();
  }
  }
</script>


<style scoped>
.form-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-field {
  margin-bottom: 20px;
}
.form-field label {
  display: block;
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 6px;
}
.form-field input[type="text"],
.form-field input[type="date"],
.form-field select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}
.form-field select {
  height: 38px;
}

.btn {
    margin: 3px;
}
</style>