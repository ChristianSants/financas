# Testes

Esta seção contém a documentação dos testes realizados no projeto. Os testes são divididos em duas categorias principais: Testes Unitários e Testes de Componentes.

* Testes Unitários: São testes focados em verificar o comportamento de unidades isoladas de código, como métodos e classes. Eles garantem que partes específicas do código funcionem conforme o esperado.

* Testes de Componentes: Estes testes abrangem casos de uso mais amplos, envolvendo a interação de vários componentes do sistema. Eles visam validar o comportamento do sistema como um todo em diferentes cenários.

## Testes Unitários

### CategoriaServiceTest

#### listCategorias
- **Descrição:** Verifica se o método `list` retorna uma coleção de categorias do usuário.
- **Pré-condições:** Usuário autenticado, 5 categorias cadastradas.
- **Entrada:** Chamada do método `list`.
- **Saída Esperada:** Coleção contendo 5 categorias.

#### testFindCategoria
- **Descrição:** Verifica se o método `find` retorna a categoria correta do usuário.
- **Pré-condições:** Usuário autenticado, categoria específica cadastrada.
- **Entrada:** Chamada do método `find`.
- **Saída Esperada:** Categoria com os detalhes correspondentes.

#### testCreateCategoria
- **Descrição:** Verifica se o método `create` adiciona uma nova categoria para o usuário.
- **Pré-condições:** Usuário autenticado.
- **Entrada:** Chamada do método `create` com dados válidos.
- **Saída Esperada:** Categoria criada no banco de dados.

#### testUpdateCategoria
- **Descrição:** Verifica se o método `update` atualiza os dados de uma categoria do usuário.
- **Pré-condições:** Usuário autenticado, categoria específica cadastrada.
- **Entrada:** Chamada do método `update` com dados válidos.
- **Saída Esperada:** Categoria atualizada no banco de dados.

#### testDeleteCategoria
- **Descrição:** Verifica se o método `delete` remove uma categoria específica do usuário.
- **Pré-condições:** Usuário autenticado, categoria específica cadastrada.
- **Entrada:** Chamada do método `delete`.
- **Saída Esperada:** Categoria removida do banco de dados.


### LancamentoServiceTest

#### listLancamentos
- **Descrição:** Verifica se o método `list` retorna uma coleção de lançamentos do usuário.
- **Pré-condições:** Usuário autenticado, 5 lançamentos cadastrados.
- **Entrada:** Chamada do método `list`.
- **Saída Esperada:** Coleção contendo 5 lançamentos.

#### testFindLancamento
- **Descrição:** Verifica se o método `find` retorna o lançamento correto do usuário.
- **Pré-condições:** Usuário autenticado, lançamento específico cadastrado.
- **Entrada:** Chamada do método `find`.
- **Saída Esperada:** Lançamento com os detalhes correspondentes.

#### testCreateLancamento
- **Descrição:** Verifica se o método `create` adiciona um novo lançamento para o usuário.
- **Pré-condições:** Usuário autenticado.
- **Entrada:** Chamada do método `create` com dados válidos.
- **Saída Esperada:** Lançamento criado no banco de dados.

#### testUpdateLancamento
- **Descrição:** Verifica se o método `update` atualiza os dados de um lançamento do usuário.
- **Pré-condições:** Usuário autenticado, lançamento específico cadastrado.
- **Entrada:** Chamada do método `update` com dados válidos.
- **Saída Esperada:** Lançamento atualizado no banco de dados.

#### testDeleteLancamento
- **Descrição:** Verifica se o método `delete` remove um lançamento específico do usuário.
- **Pré-condições:** Usuário autenticado, lançamento específico cadastrado.
- **Entrada:** Chamada do método `delete`.
- **Saída Esperada:** Lançamento removido do banco de dados.

---

## Testes de Componentes

### CategoriaTest

#### indexWithSuccess
- **Descrição:** Verifica se a listagem de categorias retorna com sucesso e a quantidade esperada.
- **Entrada:** Usuário autenticado, 10 categorias criadas para o usuário.
- **Saída Esperada:** Resposta HTTP 200 e lista com 10 categorias.

#### indexWithAnotherUser
- **Descrição:** Testa a listagem de categorias de outro usuário, que deve retornar vazia.
- **Entrada:** Usuário autenticado, 10 categorias criadas para outro usuário.
- **Saída Esperada:** Resposta HTTP 200 e lista vazia.

#### findWithSuccess
- **Descrição:** Testa a busca de uma categoria com sucesso.
- **Entrada:** Usuário autenticado, categoria criada para o usuário.
- **Saída Esperada:** Resposta HTTP 200 e categoria encontrada.

#### findWithAnotherUser
- **Descrição:** Verifica que a busca de uma categoria de outro usuário resulta em um erro 404.
- **Entrada:** Usuário autenticado, categoria criada para outro usuário.
- **Saída Esperada:** Resposta HTTP 404.

#### storeCategoria
- **Descrição:** Testa a criação de uma nova categoria.
- **Entrada:** Usuário autenticado, dados da nova categoria.
- **Saída Esperada:** Resposta HTTP 201 e categoria criada no banco de dados.

#### updateCategoria
- **Descrição:** Verifica se a atualização de uma categoria ocorre com sucesso.
- **Entrada:** Usuário autenticado, categoria existente, dados atualizados.
- **Saída Esperada:** Resposta HTTP 200 e categoria atualizada no banco de dados.

#### updateCategoriaAnotherUser
- **Descrição:** Testa a atualização de uma categoria por outro usuário, que deve resultar em um erro.
- **Entrada:** Usuário autenticado, categoria existente para outro usuário, dados atualizados.
- **Saída Esperada:** Resposta HTTP 500 com mensagem de erro.

#### deleteCategoria
- **Descrição:** Testa a exclusão de uma categoria.
- **Entrada:** Usuário autenticado, categoria existente.
- **Saída Esperada:** Resposta HTTP 200 e categoria removida do banco de dados.

### LancamentoTest

#### indexWithSuccess
- **Descrição:** Verifica se a listagem de lançamentos retorna com sucesso e a quantidade esperada.
- **Entrada:** Usuário autenticado, 10 lançamentos criados para o usuário.
- **Saída Esperada:** Resposta HTTP 200 e lista com 10 lançamentos.

#### indexWithAnotherUser
- **Descrição:** Testa a listagem de lançamentos de outro usuário, que deve retornar vazia.
- **Entrada:** Usuário autenticado, 10 lançamentos criados para outro usuário.
- **Saída Esperada:** Resposta HTTP 200 e lista vazia.

#### findWithSuccess
- **Descrição:** Testa a busca de um lançamento com sucesso.
- **Entrada:** Usuário autenticado, lançamento criado para o usuário.
- **Saída Esperada:** Resposta HTTP 200 e lançamento encontrado.

#### findWithAnotherUser
- **Descrição:** Verifica que a busca de um lançamento de outro usuário resulta em um erro 404.
- **Entrada:** Usuário autenticado, lançamento criado para outro usuário.
- **Saída Esperada:** Resposta HTTP 404.

#### storeLancamento
- **Descrição:** Testa a criação de um novo lançamento.
- **Entrada:** Usuário autenticado, dados do novo lançamento.
- **Saída Esperada:** Resposta HTTP 201 e lançamento criado no banco de dados.

#### updateLancamento
- **Descrição:** Verifica se a atualização de um lançamento ocorre com sucesso.
- **Entrada:** Usuário autenticado, lançamento existente, dados atualizados.
- **Saída Esperada:** Resposta HTTP 200 e lançamento atualizado no banco de dados.

#### updateLancamentoAnotherUser
- **Descrição:** Testa a atualização de um lançamento por outro usuário, que deve resultar em um erro.
- **Entrada:** Usuário autenticado, lançamento existente para outro usuário, dados atualizados.
- **Saída Esperada:** Resposta HTTP 500 com mensagem de erro.

#### deleteLancamento
- **Descrição:** Testa a exclusão de um lançamento.
- **Entrada:** Usuário autenticado, lançamento existente.
- **Saída Esperada:** Resposta HTTP 200 e lançamento removido do banco de dados.
