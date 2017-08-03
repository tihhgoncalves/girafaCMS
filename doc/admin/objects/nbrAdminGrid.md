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

### AddColumnString($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo ```string```.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```left```).

#### Exemplo

    $grid->AddColumnString('Nome', 'Nome', 350);

---

### AddColumnInteger($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo ```integer```.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```center```).

#### Exemplo

    $grid->AddColumnInteger('Idade', 'Idade', 150);
    
---

### AddColumnNumber($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo ```integer```.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```right```).

#### Exemplo

    $grid->AddColumnNumber('Valor', 'Valor', 125);
    
---

### AddColumnImage($fieldName, $legend, $width, $height, $align)

Adicionar uma coluna de campo imagem.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid e largura da imagem. (Padrão: 100).
* ```$height``` - Altura da imagem. (Padrão: 50).
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```right```).

#### Exemplo

    $form->AddFieldImage('Capa', 'Imagem');
    
---

### AddColumnDate($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo de Data.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```right```).

#### Exemplo

    $form->AddColumnDate('DataNascimento', 'Dt. Nascimento', 150);
    
---

### AddColumnDateTime($fieldName, $legend, $width, $align)

Adicionar uma coluna de campo de Data e Hora.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```right```).

#### Exemplo

    $form->AddColumnDateTime('DataNascimento', 'Dt. Nascimento', 150);
    
---

### AddColumnBoolean($fieldName, $legend, $width, $align, $controlOn)

Adicionar uma coluna de campo de Data e Hora.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid (Padrão: 75).
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```center```).
* ```controlOn``` - Controle de valor por clique. (Padrão: ```true```).

#### Exemplo

    $form->AddColumnBoolean('Publicado', 'Publicado');
    
---

### AddColumnList($fieldName, $legend, $width, $options, $align = 'left')

Adicionar uma coluna de campo de Data e Hora.

#### Parâmetros

* ```$fieldName``` - Nome do campo (no MySQL).
* ```$legend``` - Legenda da coluna no grid.
* ```$width``` - Tamanho da coluna no grid (Padrão: 75).
* ```$options``` - Texto com opções da lista.
* ```$align``` - Alinhamento da coluna no grid (```left```, ```center``` ou ```right``` - Padrão: ```center```).

#### Exemplo

    $form->AddColumnList('Situacao', 'Situação', 200, 'CAS=Casa|APT=Apartamento');
    
---
