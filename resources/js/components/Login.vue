<template>
    <!-- Aqui no componente vue, somente html e javascript -->
    <!-- Como os componentes são executador do lado do front,
    não tem acesso a nenhum recursos php ou laravel-->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login (Componente Vue)</div>

                    <!--  {{ email }} - {{ passowrd }} -->

                    <div class="card-body">
                        <!-- Interceptando o envio deste form: Recuperando o evento de "submit"
                             deste form e modificando o comportamento padrão, por meio da diretiva
                        v-on(@) e o modificador prevent(), e trocando por um método-->
                        <form method="POST" action @submit.prevent="login($event)">
                            <input type="hidden" name="_token" :value="csrf_token" />

                            <div class="form-group row">
                                <label
                                    for="email"
                                    class="col-md-4 col-form-label text-md-right"
                                >E-mail</label>

                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        value
                                        required
                                        autocomplete="email"
                                        autofocus
                                        v-model="email"
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-right"
                                >Senha</label>

                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        v-model="password"
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="remember"
                                            id="remember"
                                        />

                                        <label
                                            class="form-check-label"
                                            for="remember"
                                        >Mantenha-me conectado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Login</button>

                                    <a class="btn btn-link" href="#">Esqueci a senha</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/* Objeto literal de configuração do vueJS */
/* Parte dedicada para codificação javascript */
/* Agora, após ter exportado este objeto literal, estas propriedades
   estarão disponíveis para o template e para este script também. */
/* Objeto padrão de exportação para configuração do vueJS, no front */
export default {
    /* Aqui, as props são sempre convertidas para letras minúsculas */
    props: ["csrf_token"],
    /* Quando o vueJS é implementado com o laravel, a implementação
    do atributo "data" é um pouco diferente, na forma de método */
    data() {
        /* Objeto literal */
        return {
            /* Two-way-data binding (v-model) com os inputs do formulário */
            email: '',
            password: ''
        }
    },
    methods: {
        login(evento) {

            /*  console.log(this.email, this.password)
             return false; */

            /* endpoint de autenticação pela api */
            let url = 'http://localhost:8000/api/login'
            /* Objeto literal */
            let configuração = {
                method: 'post',
                /* Determinando a forma de encoded dos parâmetros
                passados, como no postman. Neste caso será
                 "x-www.form-urlencoded" (URLSearchParams)  */
                /* Objeto literal */
                body: new URLSearchParams({
                    'email': this.email,
                    'password': this.password
                })
            }
            /* Fazendo uma requisição htttp: */
            /* O fetch() é assíncrono */
            fetch(url, configuração)
                /* Recuperando de modo assíncrono a resposta
                desta requisição fetch(). Uma arrow function.
                .then encadeados */
                .then(response => response.json())
                /* "data" é o conteúdo desta resposta,
                   é apenas a parte útil da resposta */
                .then(data => {
                    /* Agora isolando somente o token, para
                    guardar no front da aplicação, na forma de cookies */
                    console.log(data.token)
                    /* Escrevendo o token JWT na parte de "cookies" do navegador */
                    /* O laravel vai automaticamente entender que estamos
                    encaminhando um token JWT de "autorização" */
                    document.cookie = 'token=' + data.token + ';SameSite=Lax'
                    /* De fato disparar, fazer o envio do formulário no final do processo */
                    /* Dar sequência no envio do form de "autenticação por sessão" */
                    evento.target.submit()
                })

        }
    }
};
</script>

<style></style>
