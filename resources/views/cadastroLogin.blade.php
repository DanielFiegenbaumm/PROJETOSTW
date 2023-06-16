
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<html>
    <body>
        <main>
            <div id="cadastrarLogin">
                <div class="container">
                    <div class="form-box">
                        <form name="formCadastroLogin" method="post" @submit.prevent="cadastrarUsuario">
                            <div>
                                <h1>Cadastro do Usuário</h1>
                            </div>
                            <div>
                                <input type="text" name="name" v-model="cadastroLogin.name" placeholder="Informe o seu Nome" class="form-input" required>
                            </div>
                            <div>
                                <input type="text" name="email" v-model="cadastroLogin.email" placeholder="Informe o seu Usuário" class="form-input" required>
                            </div>
                            <div>
                                <input type="text" name="senha" v-model="cadastroLogin.password"placeholder="Informe a sua Senha" class="form-input" required>
                            </div>
                            <div>
                                <input type="submit" value="Salvar" class="form-btn">
                            </div>
                        </form>
                        <div style="font-size: 14px;">
                            Você já tem uma conta? <a href="{{ route('loginView') }}">Efetue o seu Login</a>
                        </div>       
                    </div>
                </div>
            </div>
        </main>
        <script>
            new Vue({
                el: '#cadastrarLogin',
                data: {
                    cadastroLogin: {
                        name: '',
                        email: '',
                        password: ''
                    }
                },
                methods: {
                    cadastrarUsuario() {
                        axios.post('/cadastrarUsuario', {
                            name: this.cadastroLogin.name,
                            email: this.cadastroLogin.email,
                            password: this.cadastroLogin.password
                        })
                        .then(response => {
                            console.log(response.data);
                            Swal.fire({
                                title: "Usuário Cadastrado!",
                                text: "Usuário cadastrado com sucesso!.",
                                icon: "success"
                            });

                            this.cadastroLogin = {};
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: "Usuário não cadastrado!",
                                text: "Aconteceu algum problema ao cadastrar usuário.",
                                icon: "error"
                            });
                        });
                    }
                }
            });
        </script>
    </body>
</html>
