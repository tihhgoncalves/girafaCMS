# Objeto nbrAdminGrid

Objeto responsável por construir e administrar os formulário do painel de administração.

  new nbrAdminGrid($tableName, $title = null)
  
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
