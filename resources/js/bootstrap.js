//const { config } = require('dotenv');

//const { use } = require('vue/types/umd');

//const { response } = require('express');

//const { reject } = require('core-js/fn/promise');

//const { log } = require('console');

//const { request } = require('http');

//window._ = require('lodash');

/**
* Este arquivo não tem a ver com o framework bootstrap css.
* Este é para inicializacao das configurações do javascript
* no fronte da aplicacao.
*/


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }



/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/* "Interceptors" do axios:
    Intercepta as requisições antes que elas sejam feitas e repostas
    depois dos seus recebimentos. */
/* O método use() espera dois métodos de callback. */

/* Após esta implementação, todas as requisições feitas pelo "axios",
   tanto request como response, serão interceptadas. */

/* Interceptar os "requests" da aplicação: */
axios.interceptors.request.use(
    /* arrow functions */
    config => {

        /* Definir para todas as requisições, os parâmetros de accept e authorization */
        /* Usando sintaxe de "array" para acesso aos atributos do cabeçário da requisição */
        config.headers['Accept'] = 'application/json'

        /* O método "find()"" retorna uma posição do array, somente se a mesma retornar "true",
           ou seja, que comece com parâmetro do método "includes()"" */
        /* Recuperando o token de autorização dos cookies */
        let token = document.cookie.split(";").find((indice) => {
            return indice.includes("token=");
        });
        /* Pegando a posição "1" do array, que é somente o token atribuindo */
        token = token.split("=")[1];
        /* Concatenando essa string com o próprio token em si */
        token = "Bearer " + token;
        
        /* Usando sintaxe de "objeto" para acesso aos atributos do cabeçário da requisição */
        config.headers.Authorization = token

        console.log('Interceptando o request antes do envio', config)
        return config
    },
    error => {
        console.log('Erro na requisição: ', error)
        return Promise.reject(error)
    }
)

/* Interceptar os "responses" da aplicação: */
axios.interceptors.response.use(
    /* arrow functions */
    response => {
        console.log('Interceptando a resposta antes da aplicação', response)
        return response
    },
    error => {
        console.log('Erro na resposta: ', error)
        return Promise.reject(error)
    }
)

