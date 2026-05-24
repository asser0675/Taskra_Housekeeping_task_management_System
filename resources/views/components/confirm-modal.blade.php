<div id="confirm-modal" class="admin-modal confirm-modal">
    <div class="admin-modal-panel" role="dialog" aria-modal="true" aria-labelledby="confirm-modal-title">
        <h3 id="confirm-modal-title" class="modal-title">Please confirm</h3>
        <p id="confirm-modal-message" class="modal-message">Are you sure?</p>

        <div style="display:flex; gap:10px; justify-content:flex-end; margin-top: 16px;">
            <button id="confirm-modal-cancel" data-modal-close class="btn">Cancel</button>
            <button id="confirm-modal-accept" class="btn btn-primary">Yes, confirm</button>
        </div>
    </div>
</div>

<style>
.admin-modal.confirm-modal { position: fixed; inset: 0; display: none; align-items:center; justify-content:center; background: rgba(0,0,0,0.4); }
.admin-modal.confirm-modal.is-open { display: flex; }
.admin-modal-panel { background: white; padding: 20px; border-radius: 12px; max-width: 480px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
.modal-title { font-weight:700; margin:0 0 8px 0; }
.modal-message { color:#4a5565; margin:0; }
.btn { padding:8px 14px; border-radius:10px; border:none; cursor:pointer; }
.btn-primary { background:#8e51ff; color:white; }
</style>