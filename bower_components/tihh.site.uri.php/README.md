# Objeto de PHP - tihh_uri()
Objeto de PHP que retorna a url base do site.

[![Versão](http://app.tiago.art.br/flags/version.php?path=tihhgoncalves/tihh.site.uri.php)](#)
[![Size](http://app.tiago.art.br/flags/size.php?path=tihhgoncalves/tihh.site.uri.php)](#)


### Instalação
Para utilizar esse script, utilize o seguinte comando:

```sh
$ bower install tihh.site.uri.php --save
```

P.S.: Caso prefira, você pode fazer o download do projeto manualmente.

### Exemplo

```php
  <?php
  
  require('bower_components/tihh.site.uri.php/load.php');

  $uri = new tihh_URI();

  echo $uri->base(); // http://www.teste.com.br/base/

  ?>
```

### Autor
![logo](https://raw.githubusercontent.com/tihhgoncalves/tihh.site.uri.php/master/logo.png)


Esse script de PHP foi desenvolvido por Tihh Gonçalves (tiago@tiago.art.br). 

Mais informações: www.tiago.art.br
