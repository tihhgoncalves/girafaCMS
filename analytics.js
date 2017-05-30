//verifica se rhinoJS está instalado
function girafa_verify() {
  if (typeof rhinoJS != 'object') {
    alert('Girafa CMS - Para utilizar o Analytics, é necessário que você carregue a biblioteca rhinoJS');
    return false;
  }

  if (typeof jQuery != 'function') {
    alert('Girafa CMS - Para utilizar o Analytics, é necessário que você carregue a biblioteca jQuery');
    return false;
  }

  if (typeof is != 'object') {
    alert('Girafa CMS - Para utilizar o Analytics, é necessário que você carregue a biblioteca is_js');
    return false;
  }

  return true;
}

/* Navegador */
var browser = '000';

if(is.ie())
  browser = 'IE';
else if(is.chrome())
browser = 'CHR';
else if(is.firefox())
browser = 'FFX';
else if(is.edge())
browser = 'EDG';
else if(is.opera())
browser = 'OPR';
else if(is.safari())
browser = 'SAF';
else if(is.phantom())
browser = 'PHA';

/* Plataforma */

var device = '000';

if(is.desktop())
  device = 'DSK';
else if(is.mobile())
  device = 'MOB';
else if(is.tablet())
  device = 'TAB';

/* Sistema Operacional */
var os = '000';

if(is.windows())
  os = 'WIN';
else if(is.mac())
  os = 'IOS';
else if(is.linux())
  os = 'LNX';

/* Verifica se é um Aparelho Touch */


if(girafa_verify()){

  jQuery.ajax({
    url: girafa_analytics_path + "analytics.php",
    type: 'POST',
    data: {
      URL: window.location.href,
      URLReferencia: document.referrer,
      Plataforma: device,
      Navegador: browser,
      Sistema: os,
      Touch: (is.touchDevice()?'S':'N'),
      Resolucao: (window.innerWidth + 'x' + window.innerHeight)
    }
  })
      .done(function( data ) {
        console.log(data);
      });


}