<?
$form = new nbrAdminForms('sysModuleReports');

$form->AddFieldHidden('Published', 'Y');

$form->AddFieldString('Title', 'Titulo', 50, 2);
$form->AddFieldString('File', 'Arquivo', 100, 2);
$form->AddFieldList('Type', 'Tipo', 'PDF=Documento de PDF|XLS=Planilha Excel', 1);

$form->PrintHTML();
?>