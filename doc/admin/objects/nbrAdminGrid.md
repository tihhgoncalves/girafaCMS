# Objeto nbrAdminGrid

Objeto responsável por construir e administrar os formulário do painel de administração.

  new nbrAdminGrid($tableName, $title = null)
  
### Parâmetros

* ```tableName``` - Nome da tabela (no MySQL).
* ```title``` - Título do grid.

### Exemplo
    
    <?
    $grid = new nbrAdminGrid('Clientes', 'Clientes');
    $grid->orders = 'Nome ASC';
    $grid->formFile = 'clientes.form.php';
    
    $grid->AddColumnString('Nome', 'Nome', 350);
    $grid->AddColumnString('Email', 'E-mail', 250);
    $grid->AddColumnString('Telefone', 'Telefone', 250);
    
    $grid->PrintHTML();
    ?>
  
## Variáveis Internas
* ```module``` - Herda o objeto ```nbrModules```.
* ```title``` - Título do formulário.
* ```tableName``` - Nome da tabela.
* ```fields``` - Array com campos.
* ```fieldTitle``` - Campo que assume o valor que identifica o registro.
* ```records``` - Consulta de registros do MySQL.
* ```totalRecords``` - Número total dos registros selecionados do grid.
* ```hubParams``` - Adiciona um parâmetro do ```nbrAdminHub``` da página.
* ```commands``` - Array com comandos do grid.
* ```controlOrders``` - Array que lista os campos que ordenarão a consulta de MySQL.
* ```recordsLimitFromPage``` - Número de registros por página.
* ```recordsPage``` - Número da página atual.
* ```totalPages``` - Número de total de páginas.

## Propriedades
* ```wheres``` - SQL de ```WHERE```.
* ```orders``` - SQL de ```ORDER```.
* ```formFile``` - Nome do arquivo de formulário.
* ```macroFile``` - Nome do arquivo de macro.
* ```securityNew = true``` - Mostra o botão de Novo.
* ```securityEdit = true``` - Mostra o botão de Editar.
* ```securityDelete = true``` - Mostra o botão de Excluir.
* ```filters = array()``` - Array que contém  a lista dos filtros do Grid.


## Funções

### função AddColumnString($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo ```string```.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (left, center ou right - Padrão: left).

#### Exemplo

    $grid->AddColumnString('Nome', 'Nome', 350, 'center');


### função AddColumnInteger($fieldName, $legend, $width, $align)

    Adicionar uma coluna de campo ```integer```.