
<div class="modal modal-item fade hidden">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="truncate">Atualizar item <span style="font-weight: 500;font-style: italic" class="order-name-item"></span>
                    <br><small>Pedido: <strong class="order-sale-code"></strong></small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-close-item" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-12 body-item-html"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close-modal-item btn-close-item btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary btn-save-status-item" data-id="" data-code="" data-state="" data-status="" data-label="" data-reason="">Atualizar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /.modal-fecha-compra -->
<div class="modal modal-order fade hidden">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Atualizar pedido <span class="modal-title-ordercode font-weight-bold"></span>
                    no valor de <span class="modal-title-orderprice text-danger font-weight-bold"></span>
                    <span class="badge badge-border border-info text-info text-info-paid">JÁ PAGO</span>
                </h4>
                <button type="button" class="close btn-close-sale-finalize" data-dismiss="modal" aria-label="Close">
                    <span class="modal-close-order" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body modal-order">
                <div class="row">
                    <input type="hidden" id="sale-code" class="sale-code-input" value="">
                    <input type="hidden" id="final-price" class="final-price-input" value="0">
                    <input type="hidden" id="paid-value" class="paid-value-input" value="0">
                    <input type="hidden" id="sale-change" class="sale-change-input" value="0">
                    <input type="hidden" id="method-pay-slug" class="method-pay-slug-input" value="">
                    <input type="hidden" id="method-pay-card" class="method-pay-card-input" value="">
                    <input type="hidden" id="is-delivery" class="is-delivery-input" value="0">
                    <div class="col-md-12 body-order-html"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="payment_change"></div>
                <button type="button" class="btn btn-secondary close-modal-order is-delivery" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary btn-save-status-order" data-code="" data-state="" data-status="" data-pay-slug="" data-pay-type="" data-reason="" data-deliveryman="">Atualizar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
