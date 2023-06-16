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
        <h1>Cadastro de Ingrediente</h1>
    </header>
    <main>
        <div id="cadastroIngrediente">
            <div class="title">
                <h2>Lista de Ingredientes</h2>
                <span>Ingredientes para Cadastro</span>
            </div>

            <div class="card">
                <form name="formCadastroIngrediente" method="post" @submit.prevent="cadastrarIngrediente">
                    <div class="lineInput">
                        <label>Receita</label>
                        <input type="text" id="receita" name="receita" v-model="cadIngrediente.receita" placeholder="Receita" readonly :value="cadIngrediente.receita">
                    </div>                    
                    <div class="lineInput">
                        <label>Ordem</label>
                        <input type="text" id="ordem" name="ordem" v-model="cadIngrediente.ordem" placeholder="Ordem">
                    </div>
                    <div class="lineInput">
                        <label>Código</label>
                        <input type="text" id="codigo" name="codigo" v-model="cadIngrediente.codigo" placeholder="Código">
                    </div>
                    <div class="lineInput">
                        <label>Descrição</label>
                        <input type="text" id="descricao" name="descricao" v-model="cadIngrediente.descricao" placeholder="Descrição Ingrediente">
                    </div>
                    <div class="lineInput">
                        <label>Previsto em KG</label>
                        <input type="text" id="previstoKG" name="previstoKG" v-model="cadIngrediente.previstoKG" placeholder="Previsto em KG">
                    </div>
                    <button type="submit">Salvar Ingrediente</button>
                    <button type="button" onclick="goBack()">Voltar</button>
                </form>
            </div>
            <div class="content">
                <table border="1">
                    <thead>
                        <th class="center">Ordem</th>
                        <th class="center">Código</th>
                        <th class="center">Descrição</th>
                        <th class="center">Previsto em KG</th>
                        <th class="center">Editar</th>
                        <th class="center">Excluir</th>
                    </thead>
                    <tbody>
                        <tr v-for="ingrediente of listIngredientes" :key="ingrediente.id">
                            <td class="center">{{ ingrediente.ordem }}</td>
                            <td class="center">{{ ingrediente.codigo }}</td>
                            <td class="center">{{ ingrediente.descricao }}</td>
                            <td class="center">{{ ingrediente.previstoKG }}</td>
                            <td class="center"><a href="#" @click="editarReceita(ingrediente.id)"><img src="/img/editar.png" alt="Editar"></a></td>
                            <td class="center"><a href="#" @click="excluirIngrediente(ingrediente.id)"><img src="/img/excluir.png" alt="Excluir"></a></td>
                        </tr>
                      </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
<script>
    new Vue({
        el: '#cadastroIngrediente',
        data: {
            cadIngrediente: {
                receita: '',
                ordem: '',
                codigo: '',
                descricao: '',
                previstoKG: '',
            },
            listIngredientes: [],
        },
        methods: {
            listarIngredientes() {
                axios.get('/listarIngredientes')
                    .then(response => {
                        this.listIngredientes = response.data;
                        console.log(this.listIngredientes);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            cadastrarIngrediente() {
                const receitaId = "{{ $id }}";
                const url = '/cadastrar/ingredientes/' + receitaId;
                
                axios.post(url, this.cadIngrediente)
                .then(response => {
                    Swal.fire({
                    icon: 'success',
                    title: 'Cadastro realizado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                })
                .catch(error => {
                    Swal.fire({
                    icon: 'error',
                    title: 'Erro ao cadastrar',
                    text: error.message
                    });
                });
                this.listarIngredientes();
            },
            buscarNomeReceita(id) {
                axios.get('/busca/receitas/' + id)
                    .then(response => {
                        console.log(response.data);
                        this.cadIngrediente.receita = response.data.nome;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            editarReceita(ingredienteId) {
                const ingrediente = this.listIngredientes.find((ingrediente) => ingrediente.id === ingredienteId);

                const vm = this;

                Swal.fire({
                    title: 'Editar Ingrediente',
                    html: `
                        <input type="text" id="ordem" name="ordem" value="${ingrediente.ordem}" placeholder="Ordem" class="swal2-input">
                        <input type="text" id="codigo" name="codigo" value="${ingrediente.codigo}" placeholder="Código" class="swal2-input">
                        <input type="text" id="descricao" name="descricao" value="${ingrediente.descricao}" placeholder="Descrição Ingrediente" class="swal2-input">
                        <input type="text" id="previstoKG" name="previstoKG" value="${ingrediente.previstoKG}" placeholder="Previsto em KG" class="swal2-input">
                    `,
                    confirmButtonText: 'Salvar',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    preConfirm: function () {
                        const ordem = Swal.getPopup().querySelector('#ordem').value;
                        const codigo = Swal.getPopup().querySelector('#codigo').value;
                        const descricao = Swal.getPopup().querySelector('#descricao').value;
                        const previstoKG = Swal.getPopup().querySelector('#previstoKG').value;

                        ingrediente.ordem = ordem;
                        ingrediente.codigo = codigo;
                        ingrediente.descricao = descricao;
                        ingrediente.previstoKG = previstoKG;

                        axios.put(`/editarIngrediente/${ingredienteId}`, ingrediente)
                            .then(response => {
                                console.log(response.data);

                                vm.cadIngrediente = {
                                    receita: '',
                                    ordem: '',
                                    codigo: '',
                                    descricao: '',
                                    previstoKG: ''
                                };

                                vm.listarIngredientes();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Ingrediente atualizado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            })
                            .catch(error => {
                                console.error(error);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao atualizar o ingrediente!',
                                    text: 'Ocorreu um erro ao atualizar o ingrediente.',
                                });
                            });
                    }
                });
            },
            excluirIngrediente(ingredienteId) {
                Swal.fire({
                    title: "Confirmar exclusão",
                    text: "Tem certeza de que deseja excluir este Ingrediente?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Cancelar"
                })
                .then(result => {
                    if (result.value) {
                        const ingrediente = this.listIngredientes.find(ingrediente => ingrediente.id === ingredienteId);
                        console.log(ingrediente);

                        axios.delete(`/excluirIngrediente/${ingredienteId}`)
                            .then(response => {
                                this.listIngredientes = this.listIngredientes.filter(ingrediente => ingrediente.id !== ingredienteId);

                                
                                Swal.fire({
                                    title: "Ingrediente excluído!",
                                    text: "O ingrediente foi excluído com sucesso.",
                                    icon: "success"
                                }).then(() => {
                                    this.listarIngredientes();
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: "Erro ao excluir ingrediente!",
                                    text: "Ocorreu um erro ao excluir o Ingrediente.",
                                    icon: "error"
                                });
                            });
                    }
                });
            },

        },
        mounted() {
            const receitaId = "{{ $id }}";
            this.buscarNomeReceita(receitaId);
            this.listarIngredientes();
        }
    });

    function goBack() {
        history.back();
    }
</script>
</html>
