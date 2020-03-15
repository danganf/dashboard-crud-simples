
@extends('layout')

@section('css')
    <style>
        .card-body{padding-bottom: 0 !important;}
        .card-header{padding: 10px;}
        .card-header h5{margin-bottom: 5px !important;}
        .card-title{cursor: pointer;}
        .card-footer{padding: 10px 10px 10px 10px;}
        li.delivery {font-size: 1.2rem;padding-top: 5px;line-height: 35px; }
        li.delivery i{font-size: 2.2rem;margin: 7px 8px 0 0;}
        li.delivery i.no-place{margin-top: 2px;}
        li.delivery div.customer-name{font-size: 0.9rem;}
        li.delivery div.place{margin-left: 40px;margin-bottom: 15px;line-height: 13px;margin-top: 17px;}
        li.delivery div.delivery-customer-cellphone{margin-left: 40px;line-height: 15px;margin-top: -10px;margin-bottom: 8px;}

        li.deliveryman i{font-size: 2.2rem;margin-top: -2px;}

        .list-group{margin-left: -5px;}
        .list-group-item{padding: 5px 5px 3px 0;font-size: 0.8rem;line-height: 15px;background: transparent;}
        .btn-outline-click{background-color: #666EE8;color: white;}
        .heading-elements{top: 7px !important;}
        .payment_change{margin-right: 25px !important;font-size:20px;}
        .payment_change span{font-size: 2rem;}

        .modal{display: block;opacity:1;background: rgba(0, 0, 0, 0.5);}
        .modal-header{padding: 9px 10px 0 10px;}
        .no-padding{padding: 0;}

        .badge-origin{margin-top: -1px;float: left; margin-right: 5px;border: 1px solid #e3e4e8;
            display: inline-table;}

        /*coloca ... no final da div pro testo n quebrar*/
        .truncate {text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}

        div.payment{margin-top: 15px;padding: 0 0 0 0;}
        div.payment i{font-size: 2.2rem;margin: -5px 5px 0 0;}

        .section-pay-method h5{color: #2C303B;border-bottom: 2px dashed #2C303B;line-height: 2rem;margin-bottom: 25px;font-weight: 600;text-transform: uppercase;}

        .modal-payment-method{background-color: #f2f2f3;padding: 0 10px 0 10px;line-height: 58px;}
        .modal-payment-method div.pay-methods{margin-bottom: -7px;}
        .modal-payment-method div.form-group{display: flow-root;margin: -74px 0 0 70px;}
        .money-pay{float: right; /* width: 73% */;font-weight: 600;display: none;}
        .money-pay input{margin: -47px 0 0 85px;}
        .modal-title-orderprice{font-size: 1.6rem;}
        .title-order-price{font-size: 1.0rem !important;margin-left: 5px;}
        
        .badge{font-size: 0.8rem;}
        .order-item, .pdv-order-item{cursor: pointer;}
        .decision-buttons{display:flex;margin-right: -10px;}
        .swal-footer {background-color: rgb(245, 248, 250);margin-top: 32px;border-top: 1px solid #E9EEF1;overflow: hidden;}
        .swal-button {padding: 7px 19px;border-radius: 2px;font-size: 12px;}
        .p-t-5{padding-top:5px;}
        .modal:before {content: '';display: inline-block;height: 40%;vertical-align: middle;margin-right: -4px;}
        .order-sale-code{font-size: 1.1rem;}
        .opacity-0-6{opacity: 0.6;}
        .badge-pdv-obs{padding-top: 7px;font-size: 0.9rem;}
        .section-pay-method, .text-info-paid{display: none;}
        .badge-order-item{margin-top: 2px !important;}
        .order-reason, .order-deliveryman{margin: 10px 0;background-color: #F4F5FA;padding: 10px 10px 18px 10px;display: none;}
        .section-pay-method{margin-top: 10px;}
        .section-delivery-pay-method span{font-weight: 600;}

        /* ORDER MONITOR */
        .order-col-header-info {padding: 0px}
        .order-badge{margin-right: 1px; }
        .order-badge-balcony{ }
        .order-badge-delivery{background-color: lawngreen !important;}
        .order-badge-pickup{background-color: cyan !important;}
        .order-badge-price{ }


        .order-paid{color: #1bab86;}
        .order-not-paid{color: #fc3d39;}

        /*KANBAN*/
        #card-order-kanban .container-fluid div.row h4{border-bottom: 5px dashed #d4d6de;padding-bottom: 8px;font-weight: 500;text-transform: uppercase;text-align: center;}
        #card-order-kanban .container-fluid div.row .card{margin-bottom: 0.8rem !important;}
        .kanban-step{padding: 0 20px 0 0;}
        /*END KANBAN*/

        /* .btn-nfc {position: absolute;right: 0;margin-top: -2px;} */
        .btn-nfc i {font-size: 1.2rem !important;}
        .btn-nfc:hover{opacity: 0.7;}

        .table-order-accomplished td{padding: 1rem 1.2rem !important;}
        .swal2-popup .swal2-actions{z-index: 0 !important;}

        @-webkit-keyframes blackWhite {
            0% { background-color: #ffdd99;border-style: solid; }
            50% { background-color: #ffdd99;border-style: solid; }
            51% { background-color: #ffe6e6;border-style: dashed; }
            100% { background-color: #ffe6e6;border-style: dashed; }
        }

        @-webkit-keyframes blackWhiteFade {
            0% { background-color: #ffdd99;border-style: solid; }
            50% { background-color: #ffe6e6;border-style: dashed; }
            100% { background-color: #ffdd99;border-style: solid; }
        }

        @media (min-width:320px){
            li.deliveryman div{display: grid;padding-left: 9px;}
            .list-delivery{margin-top: -10px;}
            div.payment{margin-left: 10px;}
            .order-icon{float: left;margin-top: -2px;margin-right: 0;}
            .pay-icon{float: left;margin-top: -27px;margin-left: 42px;}
            .title-order-price {margin-top: -26px;}
            .order-status-label{display: none;}
            /*.section-delivery-pay-method{padding-left: 36px;}*/
            .section-delivery-pay-method{margin-left: 5px;display: inline-block;}
            .section-delivery-menu-dropdown{padding-bottom: 15px;border-bottom: dashed 2px white;margin-bottom: 15px;}
        }
        @media (min-width:425px){
            .order-icon{margin-top: 0;}
            .title-order-price {margin-top: -29px;}
        }
        @media (min-width:768px){
            .modal:before {height: 22%;}
            .title-order-price{margin-top: -2px !important;}
            .order-icon{float: right;margin-right: -19px;}
            .pay-icon{margin-left: -18px;}
            .badge.badge-striped{margin-top: -3px;}
            div.payment{margin-left: 0;}
            .list-delivery{margin-top: 0;}
            .dropdown-menu {max-height: 500px;}
            .scrollable-container {max-height: 450px;}
            .section-new-orders{display: none;cursor: pointer;width: 100%;margin-bottom: 25px;}
            .section-new-orders div{
                display: inline-block;padding: 10px;font-size: 1.8rem !important;
                -webkit-animation-name: blackWhite;
                /* -webkit-animation-name: blackWhiteFade; */
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-duration: 2s;
            }
            .section-new-orders div i{font-size: 1.8rem !important;}

            .section-orders-change-processing{display: none;cursor: pointer;width: 100%;margin-bottom: 25px;}
            .section-orders-change-processing div{
                display: inline-block;padding: 10px;font-size: 1.8rem !important;
                -webkit-animation-name: blackWhite;
                /* -webkit-animation-name: blackWhiteFade; */
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-duration: 2s;
            }
            .section-orders-change-processing div i{font-size: 1.8rem !important;}
            .custom-checkbox{margin-top: 11px;}
            .section-delivery-menu-dropdown{padding-bottom: 0;border-bottom: none;margin-bottom: 0;}
        }
        @media (min-width:1024px){
            .modal-payment-method div.pay-methods{margin-bottom: 0;}
            .title-order-price{margin-top: 0;}
            .order-icon{margin-top: -2px;margin-right: -41px;}
            .order-icon-balcony{margin-right: -34px;}
            .order-icon-delivery{margin-right: -38px;background-color: lawngreen !important;}
            .order-icon-pickup{background-color: cyan !important;}
            .card-header h5{padding-right: 5px;}
            .content-main-default{overflow-y: auto;max-height: 500px;}
            .pay-icon {margin-left: 20px;}
            .pay-icon-delivery {margin-left: 22px;}
        }
        @media (min-width:1366px){
            .modal:before {height: 25%;}
            .order-icon{float: right;margin-right: -48px;}
            .order-icon-balcony{float: right;margin-right: -39px;}
            .order-icon-delivery{float: right;margin-right: -45px;background-color: lawngreen !important;}
            .order-icon-pickup{background-color: cyan !important;}
            .pay-icon{margin-left: 25px;}
            .heading-elements{right: 13px !important;}
            li.deliveryman div{line-height: 25px;display: inherit;padding-left: 40px;}
            .order-status-label{display: initial;}
            .dropdown-menu {max-height: 600px;}
            .scrollable-container {max-height: 550px;}
            .badge.badge-striped{margin-top: 1px;}
        }
        @media (min-width:1440px){
            .order-icon, .pay-icon{margin-top: -2px !important;}
            .order-icon{margin-right: -43px;}
            .order-icon-balcony{margin-right: -36px;}
            .order-icon-delivery{margin-right: -41px;background-color: lawngreen !important;}
            .order-icon-pickup{background-color: cyan !important;}
            .title-order-price{margin-top: 0 !important;}
            .section-delivery-pay-method{margin-left: 0;display: inline-block;}
        }
        @media (min-width:1920px){
            .order-icon, .pay-icon{margin-top: 0 !important;}
            .order-icon{margin-right: -23px;}
            .order-icon-balcony{margin-right: -17px;}
            .order-icon-delivery{margin-right: -21px;background-color: lawngreen !important;}
            .order-icon-pickup{background-color: cyan !important;}
            .pay-icon{margin-right: 0;margin-left: 0;}
        }
        @media (min-width:2560px){
            .order-icon{margin-right: 4px;}
            .order-icon-balcony{margin-right: 11px;}
            .order-icon-delivery{margin-right: 6px;background-color: lawngreen !important;}
            .order-icon-pickup{background-color: cyan !important;}
            .pay-icon{margin-left: -20px;}
        }

        @media (min-width:575px) and (max-width:960px){
            .decision-buttons{display:block;}
            .decision-buttons .btn{width:100px;margin-top:7px;margin-bottom:5px;}
        }

        .nav.nav-tabs .nav-item .nav-link.active{background: transparent;border-top: 3px solid red;font-weight: 600;}
        .nav-tabs .nav-link.active{border-color: #BABFC7 #BABFC7 #F4F5FA;}
        .badge-count{margin-left: 3px;height: 21px;margin-top: 2px;}

        .timer-count-down{position: absolute;bottom: 0;}
        .bg-progressbar{background-color: #d9d9d9 !important;}
        .toast-message{font-size: 1.8rem; !important;}

    </style>
@endsection

@section('content')

    <div class="section-new-orders">
        <div class="badge badge-border btn-block border-danger font-weight-bold text-danger text-info-paid" style="background-color: #ffe6e6">
            <i class="la la-refresh"></i>
            EXISTEM NOVOS PEDIDO(S)
        </div>
    </div>

    <div class="section-orders-change-processing">
        <div class="badge badge-border btn-block border-danger font-weight-bold text-danger text-info-paid" style="background-color: #ffe6e6">
            <i class="la la-refresh"></i>
            PEDIDO(S) COM STATUS ATUALIZADO
        </div>
    </div>

    <section id="tabs-options" style="margin-bottom: 20px">

    <div class="row"><div class="col-md-12 timer-count-down"></div></div>

    <div class="pull-right position-absolute" style="right: 0;margin: -18px 31px 0 0;">
        <div class="dropdown nav-item">
            @component('pages.pdv.components.fast-options') @endcomponent
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">
                Pedidos
                <span class="badge badge-pill badge-count badge-count-new badge-default badge-danger" style="background: #F76278"></span>
                <span class="badge badge-pill badge-count badge-count-processing badge-default" style="background: #FDA263"></span>
                <span class="badge badge-pill badge-count badge-count-ready badge-default" style="background: #7D84EB"></span>
                <span class="badge badge-pill badge-count badge-count-delivery badge-default" style="background: #34A69A"></span>
            </a>
        </li>
    </ul>

    <div class="tab-content pt-1">
        <div class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1" role="tabpanel">

            <section id="card-order-kanban">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 kanban-step kanban-new">
                            <h4>Novo</h4>
                            @component('pages.orders.components.order-template', [ 'orders' => array_get( $orderSteps, 'new', [] ), 'currentOrder' => $currentOrder ] )
                                @slot('class')          danger bg-lighten-1  @endslot;
                                @slot('showCardFooter') true                 @endslot;
                                @slot('classControl')   app-order-status-new @endslot;
                                @slot('posID')          {{$posID}}           @endslot;
                            @endcomponent
                        </div>
                        <div class="col-md-3 kanban-step kanban-processing">
                            <h4>em Preparo</h4>
                            @component('pages.orders.components.order-template', [
                                'orders'               => array_get( $orderSteps, 'processing', [] ),
                                'currentOrder'         => $currentOrder,
                                'sectorsNotProcessing' => $sectorsNotProcessing,
                                ] )
                                @slot('class')                 warning bg-lighten-1        @endslot;
                                @slot('showCardFooter')        false                       @endslot;
                                @slot('classControl')          app-order-status-processing @endslot;
                                @slot('approvedInPreparingAll'){{$approvedInPreparingAll}} @endslot;
                            @endcomponent
                        </div>
                        <div class="col-md-3 kanban-step kanban-ready">
                            <h4>Pronto</h4>
                            @component('pages.orders.components.order-template', [ 'orders' => array_get( $orderSteps, 'ready', [] ), 'currentOrder' => $currentOrder ] )
                                @slot('class')          primary bg-lighten-1   @endslot;
                                @slot('showCardFooter') true                   @endslot;
                                @slot('classControl')   app-order-status-ready @endslot;
                            @endcomponent
                        </div>
                        <div class="col-md-3 kanban-step kanban-delivery">
                            <h4>Em entrega</h4>
                            @component('pages.orders.components.order-template', [ 'orders' => array_get( $orderSteps, 'delivery', [] ), 'currentOrder' => $currentOrder ] )
                                @slot('class')          teal bg-lighten-1            @endslot;
                                @slot('showCardFooter') true                         @endslot;
                                @slot('classControl')   app-order-status-in-delivery @endslot;
                            @endcomponent
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    @include('pages.orders.sections.modal')
    @include('components.modal-default')

</section>

@endsection

@section('js')

<script>

    $( document ).ready(function() {
        let elem                 = $('.scrollable-container');
        let elemSectionNewsOrder = $('.section-new-orders');
        //  Notifications & messages scrollable
        if(elem.length > 0){
            elem.perfectScrollbar({theme:"dark"});
        }

        @if( $currentID > 0 )
        let timerCountDown = new TimerCountDown();
        timerCountDown.initVerifyNewOrdes( timerCountDown, '{{$currentID}}', $('.timer-count-down'), elemSectionNewsOrder, '{{implode(',',$ordersIdsProcessing)}}' );
        @endif

        elemSectionNewsOrder.on('click',function () {
            window.location.href = window.location.href;
        });

        $('.section-orders-change-processing').on('click',function () {
            window.location.href = window.location.href;
        });

        let order                 = new OrderProcess();
        let pdvMenus              = new PDVMenus();
        let orderTemplates        = new OrderTemplate();
        let elemOrderAccomplished = $('#menu-order-accomplished');
        let elemCancelOrder       = $('.btn-cancel-order');

        pdvMenus.bindNFCe( pdvMenus, true );
        pdvMenus.bindRePrint( pdvMenus, true );
        order.init( order, orderTemplates );

        if( elemOrderAccomplished.is(':visible') ){
            elemOrderAccomplished.off().on('click', function () {

                let elemContentMainDefault = helper.startModalDefault('Pedidos concluídos');
                $.ajax({
                    url: "/api/get/order/accomplished",
                    success: function (data, jqXHR) {
                        elemContentMainDefault.html( orderTemplates.renderModalOrderAccomplished( data ) );
                        pdvMenus.bindNFCe( pdvMenus, true );
                        pdvMenus.bindRePrint( pdvMenus, true );
                    },
                    error: function(data, jqXHR) {
                        elemContentMainDefault.html( data.responseJSON.messages );
                    }
                });

            });
        }

        /*if( elemCancelOrder.is(':visible') ){*/
            elemCancelOrder.off().on('click', function () {

                let scope = $(this);

                swal({
                    title: "Deseja realmente cancelar o pedido "+scope.attr('data-code')+"?",
                    text: '',
                    confirmButtonText: "SIM",
                    cancelButtonText: "Cancelar",
                    cancelButtonColor: '#d33',
                    showCancelButton: true
                }).then(function(dismiss){

                    if(dismiss.value){
                        let htmlBtn = scope.html();
                        scope.html( helper.htmlSpinner() );
                        $.ajax({
                            url: "/api/put/order/flow@status@"+scope.attr('data-code')+"@"+scope.attr('data-state')+"@"+scope.attr('data-status'),
                            success: function (data, jqXHR) {
                                helper.alertSucess('Ação executada com sucesso!' );
                                location.href  = helper.currentUrl('?');
                            },
                            error: function(data, jqXHR) {
                                scope.html( htmlBtn ).attr('disabled', false);
                                helper.alertError(data.responseJSON.messages);
                            }
                        });
                    }

                })

            });
        /*}*/

    });

    function isInternetExplorer(){
        let ua   = window.navigator.userAgent;
        let msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
            return true;
        else  // If another browser, return 0
            return false;
    }
</script>

@endsection
