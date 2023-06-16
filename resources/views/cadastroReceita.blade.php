<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <header>
        <h1>Cadastro de Receitas</h1>
    </header>
    <main>
        <div id="cadastroReceita">
            <div class="title">
                <h2>Lista de Receitas</h2>
                <span>Receitas para Cadastro</span>
            </div>

            <div class="card">
                <form name="formCadastroReceita" method="post" @submit.prevent="cadastrarReceita">
                    <div class="lineInput">
                        <label>Nome Receita</label>
                        <input type="text" id="nomeReceita" name="nomeReceita" v-model="cadReceita.receita" placeholder="Nome da Receita">
                    </div>

                    <button type="submit">Salvar Receita</button>
                    <button type="button" @click="encerrarSessao">Encerrar Sessão</button>
                </form>
            </div>
            <div class="content">
                <table border="1">
                    <thead>
                        <th class="center">Código</th>
                        <th class="center">Nome Receita</th>
                        <th class="center">Adicionar Ingredientes</th>
                        <th class="center">Editar</th>
                        <th class="center">Excluir</th>
                    </thead>
                    <tbody>
                        <tr v-for="receita of listReceitas" :key="receita.id">
                            <td class="center">{{ receita.id }}</td>
                            <td class="center">{{ receita.receita }}</td>
                            <td class="center"><a :href="'/adicionarIngredientes/' + receita.id">Adicionar Ingredientes</a></td>
                            <td class="center"><a href="#" @click="editarReceita(receita.id)"><img src="/img/editar.png" alt="Editar"></a></td>
                            <td class="center"><a href="#" @click="excluirReceita(receita.id)"><img src="/img/excluir.png" alt="Excluir"></a></td>
                        </tr>
                      </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
<script>
    new Vue({
        el: '#cadastroReceita',
        data: {
            cadReceita: {
                receita: '',
            },
            listReceitas: [],
        },
        methods: {
            cadastrarReceita() {
                axios.post('/cadastrarReceita', {
                    receita: this.cadReceita.receita,
                })
                .then(response => {
                    console.log(response.data);

                    this.cadReceita.receita = '';
                    
                    Swal.fire({
                        title: "Receita Cadastrada!",
                        text: "Receita cadastrada com sucesso!.",
                        icon: "success"
                    });
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        title: "Receita não cadastrada!",
                        text: "Aconteceu algum problema ao cadastrar receita.",
                        icon: "error"
                    });
                });

                this.listarReceitas();
            },
            listarReceitas() {
                axios.get('/listarReceitas')
                    .then(response => {
                        this.listReceitas = response.data;
                        console.log(this.listReceitas);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            excluirReceita(receitaId) {
                Swal.fire({
                    title: "Confirmar exclusão",
                    text: "Tem certeza de que deseja excluir esta receita?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Cancelar"
                })
                .then(result => {
                    if (result.value) {
                        const receita = this.listReceitas.find(receita => receita.id === receitaId);

                        axios.delete(`/excluirReceita/${receitaId}`)
                            .then(response => {
                                this.listReceitas = this.listReceitas.filter(receita => receita.id !== receitaId);
                                
                                
                                Swal.fire({
                                    title: "Receita excluída!",
                                    text: "A receita foi excluída com sucesso.",
                                    icon: "success"
                                }).then(() => {
                                    this.listarReceitas();
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: "Erro ao excluir receita!",
                                    text: "Ocorreu um erro ao excluir a receita.",
                                    icon: "error"
                                });
                            });
                    }
                });
            },
            editarReceita(receitaId) {
                const receita = this.listReceitas.find(receita => receita.id === receitaId);
                console.log(receita);
                
                if (receita) {
                    Swal.fire({
                        title: "Edição!",
                        text: "Digite o novo nome da receita:",
                        input: 'text',
                        icon: "warning",
                        showCancelButton: true        
                    }).then((result) => {
                        if (result.value) {

                            axios.put(`/editarReceita/${receitaId}`, {
                                nome: result.value
                            })
                            .then(response => {
                                console.log(response.data);
                                Swal.fire({
                                    title: "Receita atualizada!",
                                    text: "A receita foi atualizada com sucesso.",
                                    icon: "success"
                                }).then(() => {
                                    this.listarReceitas();
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: "Erro ao atualizar receita!",
                                    text: "Ocorreu um erro ao atualizar a receita.",
                                    icon: "error"
                                });
                            });
                        }
                    });
                }
            },
            encerrarSessao() {
                axios.post('/encerrarSessao')
                .then(response => {
                    window.location.href = '/';
                })
                .catch(error => {
                    console.error(error);
                });
            }
        },
        mounted() {
            this.listarReceitas();
        }
    });
</script>
</html>
