let elementCustomerIds = $('input[name="customer_ids"]');

$( document ).ready(function() {
    $('span.check').on( 'click', function () {
        let scope  = $(this);
        let action = scope.data('action');
        $.each( elementCustomerIds, function (index, element) {
            element = $(element);
            element. prop("checked", ( action === 1 ? true : false ) );
        } );
        updateTtCheckBox( elementCustomerIds );
    } );
} );

elementCustomerIds.on( 'click', function () {
    updateTtCheckBox( elementCustomerIds );
});

function updateTtCheckBox( elementCustomerIds ) {
    let tt         = 0;
    let elementTt  = $('.tt');
    let elementBtn = $('.btn-customer-ids');
    elementTt.html( 0 );
    elementBtn.hide();
    $.each( elementCustomerIds, function (index, element) {
        element = $(element);
        if( element. prop("checked") ){
            tt++;
        }
    } );
    if( tt > 0 ){
        elementBtn.off().show().on('click', function () {
            let destiny = $(this).data('destiny');
            swal({
                title: 'Deseja realmente excluir esses registros?',
                text: "Esta ação não poderá ser desfeita!",
                confirmButtonText: 'Sim',
                showCancelButton: true
            }).then((result) => {
                if ( typeof result.dismiss === "undefined" ) {
                    $('.swal-button--confirm').html(helper.htmlSpinner());
                    let ids = [];
                    $.each($("input[name='customer_ids']:checked"), function(){
                        ids.push($(this). val());
                    });
                    if( ids.length > 0 ){
                        $.ajax({
                            method: "POST",
                            url: "/api/delete/"+destiny+'/in-batch',
                            data: { ids: ids },
                            success: function (data, jqXHR) {
                            helper.alertSucess('Registros deletado com sucesso!');
                            location.reload();
                        },
                            error: function(data, jqXHR) {
                            helper.alertError(data.responseJSON.messages)
                            }
                        });
                    }
                }
            })
        });
    }
    elementTt.html( tt );
}