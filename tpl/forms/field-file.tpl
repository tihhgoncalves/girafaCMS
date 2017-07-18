<div  id="campo_%%NAME%%" class="field file %%COLUMNS%% %%REQUIRED%%">
  <label class="legend">%%LEGEND%%</label>

  <div class="esquerda">

    <div class="painel">

      <input class="arquivo" %%READONLY%% type="file" name="%%NAME%%" id="%%NAME%%">
      <input type="hidden" name="%%NAME%%_status" value="N" class="_status" >

      <span class="status" style="%%TEM_ARQUIVO%%">

        <a href="%%DOWNLOAD_LINK%%" title="Clique aqui para baixar este arquivo">
          <img class="down" src="%%ADMIN_IMAGES_URL%%botao_input_down.gif" title="Clique aqui para baixar este arquivo">
        </a>
        <img class="delete" src="%%ADMIN_IMAGES_URL%%icon_form_image_delete.png" title="Limpar este campo">
        <span class="txt">%%TXT_STATUS%%</span>

      </span>

    </div>

    <div style="clear:both;"></div>

  </div>

</div>
