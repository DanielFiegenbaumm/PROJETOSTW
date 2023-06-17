
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Tela de Login</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="form-box">
                <form @submit.prevent="autenticacaoLogin">
                    <?php echo csrf_field(); ?>
                    <div>
                        <h1>Login</h1>
                    </div>
                    <div>
                        <input type="text" v-model="login.email" placeholder="Email" class="form-input" required>
                    </div>
                    <div>
                        <input type="password" v-model="login.password" placeholder="Senha" class="form-input" required>
                    </div>
                    <div>
                        <input type="submit" value="Entrar" class="form-btn">
                    </div>
                    <div style="font-size: 20px; margin-top: 10%;">
                        Não é Cadastrado? <a href="<?php echo e(route('cadastroLogin')); ?>">Crie uma Conta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                login: {
                    email: '',
                    password: ''
                }
            },
            methods: {
                autenticacaoLogin() {
                    axios.post('/auth', {
                        email: this.login.email,
                        password: this.login.password
                    })
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = response.data.redirectUrl;
                        } else {
                            Swal.fire({
                                title: "Login incorreto!",
                                text: "Verifique seu usuário e senha.",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\OneDrive\Área de Trabalho\ProjetoSTW\projetoSTW\resources\views/login.blade.php ENDPATH**/ ?>