 <div class="modal modal-cadastro" id="modal-global-container">
    <div class="modal-header">
        <span class="modal-header-title" id="modal-global-title"></span>
        <span class="material-symbols-outlined modal-header-action btn-close" id="modal-global-close-button">close</span>
    </div>
   
    <div class="modal-body" id="modal-global-body"></div>

    <div class="modal-action">
        <?php buttonComponent("primary", "Vincular", extraAttributes:"id='modal-global-action-button'" ) ?>
    </div>
</div>
<script src="<?php Config::getDirJs(). 'modal.js'?>"></script>
