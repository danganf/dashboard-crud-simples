@extends('layout')

@section('css')
    <style>
        .obs{font-size: 1.3rem;font-style: italic;background-color: #f2f2f2;padding-left: 5px;margin-bottom: 10px;}
        .additionais{margin: 10px 0 0 0;font-weight: 600;text-transform: uppercase;}
        .salecode{float: left;position: relative;left: 93px;margin-top: -19px;opacity: 0.9;}
        .orderkey{float: right;position: relative;right: -2px;margin-top: -30px;font-size: 1.3rem;}
        .swal2-confirm, .swal2-cancel{height: 60px;line-height: 25px;font-size: 1.5rem !important;}
        .badge-secondary{background-color: #b9bbc6 !important;}
        ul{list-style: none;padding: 0;margin: 0;}
        ul li{font-size: 1.1rem;}
        .is-travel{font-size: 1.0rem;font-weight: 500;}
        .btn-options{float: right;margin-right: 25px;}
        .btn-options div{padding: 10px;margin-right: 5px;cursor: pointer;}
        .btn-options div:hover{opacity: 0.8;}
        .btn-options i{font-size: 3rem !important;}
        .border-alert{border:2px dashed white;background-color: olive;border-bottom: none;margin-top: -32px !important;}

        .timer-count-down{position: absolute;bottom: 0;}
        .bg-progressbar{background-color: #d9d9d9 !important;}
        .toast-message{font-size: 1.8rem; !important;}

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
            .custom-checkbox{margin-top: 11px;}
            .section-delivery-menu-dropdown{padding-bottom: 0;border-bottom: none;margin-bottom: 0;}
            .btn-options{margin-top: -90px;}
        }
        @media (min-width:1024px){
            .btn-options{margin-top: -65px;}
        }
    </style>
@endsection

@section('content')
    <div class="section-new-orders">
        <div class="badge badge-border btn-block border-danger font-weight-bold text-danger text-info-paid" style="background-color: #ffe6e6">
            <i class="la la-refresh"></i>
            EXISTEM NOVOS ITEM(NS)
        </div>
    </div>

    <div class="btn-options pb-1">
        <div class="badge badge-secondary refresh"><i class="la la-refresh"></i></div>
        <div class="badge badge-secondary fullscreen"><i class="la la-expand"></i></div>
    </div>

    <div class="row" style="width: 100%">
    @foreach( $items as $key => $item )
        @php
            $classBG          = '';
            $classBGIcon      = 'bg-warning';
            $classText        = '';
            $classTextMinutes = 'info';
            $badge            = 'badge-secondary';
            if( $item['minutes'] >= 15 ){
                $classBG          = 'bg-danger';
                $classBGIcon      = 'bg-danger bg-darken-2';
                $classText        = 'text-white';
                $classTextMinutes = 'text-white';
                $badge            = 'border-alert';
            } else if( $item['minutes'] >= 10 ){
                $classBG          = 'bg-warning';
                $classBGIcon      = 'bg-warning bg-darken-2';
                $classText        = 'text-white';
                $classTextMinutes = 'text-white';
                $badge            = 'border-alert';
            }
        @endphp
        <div class="col-lg-6 col-xl-4 card-item-{{$key+1}}">
            <div class="card overflow-hidden">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="{{$classBGIcon}} p-2 media-middle btn-ok key-{{($key+1)}} cursor-pointer"
                             data-code="{{$item['sale_code']}}" data-id="{{$item['id']}}" data-card-id="{{($key+1)}}" data-name="{{$item['qty'].'x '.$item['product_name']}}">
                            <i class="icon-control-play font-large-2 text-white"></i>
                        </div>
                        <div class="media-body {{$classBG}}" style="padding: 1rem 0 1rem 1rem;">
                            <h4 class="{{$classText}}">
                                <span class="font-weight-bold">{{$item['qty']}}x</span>
                                {{$item['product_name']}}
                            </h4>
                        @if( !empty( $item['observation'] ) )
                            <div class="obs {{$classText}} text-secondary">{{$item['observation']}}</div>
                        @endif
                        @if( !empty(  $item['items_additional'] ) )
                            <h5 class="additionais {{$classText}}">Adicionais:</h5>
                            <ul class="{{$classText}}" style="margin-bottom: 10px">
                            @foreach( $item['items_additional'] as $row )
                                <li>{{$row['qty']}}x {{$row['name']}}</li>
                            @endforeach
                            </ul>
                        @endif
                        @if( !empty(  $item['is_travel'] ) )
                            <h5 class="is-travel badge badge-info"><i class="icon-handbag"></i> Viajem!</h5>
                        @endif

                        @if( !empty(  $item['name_call'] ) )
                            <h5 class="is-travel badge badge-info"><i class="icon-user"></i><strong> {{$item['name_call']}}</strong></h5>
                        @endif

                            <h5 class="is-travel badge badge-success">Setor: <strong>{{$item['sector_name']}}</strong></h5>

                        </div>
                        <div class="media-right p-1 {{$classBG}} media-middle">
                            <h3 style="font-size: 1.7rem;" class="m-0 {{$classTextMinutes}} countdown-{{$item['id']}}"></h3>
                        </div>
                    </div>
                    {{--<span class="salecode badge {{$badge}}">#{{$item['sale_code']}}</span>--}}
                    @if( $key+1 <= 9 )
                    <span class="orderkey badge {{$badge}}">#{{($key+1)}}</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <div class="row"><div class="col-md-12 timer-count-down"></div></div>
@endsection

@section('js')
    <script>
        $( document ).ready(function() {

        @foreach( $items as $item )
            helper.timer('{{$item['id']}}', '{{$item['minutes']}}');
        @endforeach

            $('div.refresh').on('click', function(){
                location.reload();
            });
            $('div.fullscreen').on('click', function(){
                let scope = $(this);
                if (!document.fullscreenElement &&    // alternative standard method
                    !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    }
                    scope.html('<i class="la la-compress"></i>');
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                    scope.html('<i class="la la-expand"></i>');
                }
            });

            $('.btn-ok').on('click', function () {
                let scope  = $(this);
                let code   = scope.data('code');
                let id     = scope.data('id');
                let name   = scope.data('name');
                let cardID = scope.data('card-id');

                swal({
                    title: "Deseja confirmar o item\n"+name+"?",
                    html: '<div>' + 'Esta ação não poderá ser desfeita!' + '</div>',
                    confirmButtonText: "<i class=\"icon-like\"></i> 1 - SIM",
                    cancelButtonText: "2 - NÃO!",
                    cancelButtonColor: '#d33',
                    showCancelButton: true,
                    onBeforeOpen: function () {}
                }).then(function(dismiss){
                    if(dismiss.value){
                        $('.card-item-'+cardID).remove();
                        $.ajax({
                            url: "/api/put/item/flow@status@"+code+"@"+id+"@complete@complete",
                            success: function (data, jqXHR) {
                                //helper.alertSucess('Ação executada com sucesso!' );
                                location.href  = helper.currentUrl('?');
                            },
                            error: function(data, jqXHR) {
                                //helper.alertError(data.responseJSON.messages);
                                location.href  = helper.currentUrl('?');
                            }
                        });
                    }
                });
            });
        });

        @if( $currentID > 0 )
            let elemSectionNewsOrder = $('.section-new-orders');
            let timerCountDown       = new TimerCountDown();
            timerCountDown.initVerifyNewInPreparation( timerCountDown, '{{$currentID}}', $('.timer-count-down'), elemSectionNewsOrder );

            elemSectionNewsOrder.on('click',function () {
                window.location.href = window.location.href;
            });

        @endif

        $(document).keyup(function(event) {
            //console.log(event.keyCode+' = '+event.key);
            let key = event.key;
            if( key === 'Escape' || key === 'Backspace' ){
                $('.swal2-cancel').trigger('click');
            }
            else if( key === '/' ){
                $('.refresh').trigger('click');
            }
            else if( key === '*' ){
                $('.fullscreen').trigger('click');
            }
            else {
                key = parseInt(key);
                if ( key >= 0 && key <= 9 ) {

                    if( ( key === 1 || key === 2 ) && $('.swal2-popup').length === 1 ){
                        if( key === 1 ){
                            $('.swal2-confirm').trigger('click');
                        } else {
                            $('.swal2-cancel').trigger('click');
                        }
                    } else {
                        let elem = $('.key-' + key);
                        if (elem.length === 1) {
                            elem.trigger('click');
                        }
                    }
                }
            }

        });

    </script>
@endsection
