@extends('layout')

@section('content')

    <section class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="cardFilter" class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="background-color: #F1F1F4;margin-bottom: 20px" class="p-1">
                                    @php
                                     $qtyFree = array_get( $product, 'config.qty_free', 1 );
                                     $qtyFree = !empty( $qtyFree ) ? $qtyFree : 0;
                                    @endphp
                                    Qtd de itens grátis permitido:
                                    <input type="number"  data-sku="{{$product['sku']}}" class="form-control prod-qty-free col-sm-2 col-xl-1" style="display: inline-block;font-size: 1.2rem;"
                                           min="0" value="{{$qtyFree}}" autocomplete="off">
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                    <div class="input-group search-input">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ft-search"></i></span></div>
                                        <input type="text" class="form-control ac-remote-datasource ui-autocomplete-input" placeholder="Digite nome ou ID de um produto" autocomplete="off">
                                    </div>
                                    <div><small class="search-error text-danger font-weight-bold"></small></div>
                            </div>
                            <div class="col-md-12 col-xl-8 product-list">
                                <table class="table table-hover table-de mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0">Produtos</th>
                                        <th class="border-top-0">Grátis</th>
                                        <th class="border-top-0">Preço</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <!--<tr>
                                            <td class="td-line">@California Salada Chicken</td>
                                            <td class="td-line">
                                                <input type="checkbox" class="switchBootstrap" id="status" name="status" data-value="0"
                                                       data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger"/>
                                            </td>
                                            <td>
                                                <div class="input-group border-0">
                                                    <span class="text-unit"></span>
                                                    <input type="number" name="items[]" maxlength="60" placeholder="Preço" class="qtd form-control">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-repeater btn-danger" type="button" data-repeater-delete=""><i class="ft-x"></i></button>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
            <div id="cardFilter" class="card-content">
                <div class="card-body text-right">
                    <div>
                        <button type="submit" class="btn btn-primary btn-save"><i class="la la-check-square-o"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
            @include('pages.products.includes.list-grup')
        </nav>
    </section>
@endsection

@section('css')
    <style>
        .ui-autocomplete {max-height: 350px;}
        .ui-menu .ui-menu-item-wrapper {padding: 5px 0 5px 10px;font-size: 1.2em;}
        .product-list{margin: 20px 0 0 0;}
        .ac-remote-datasource{padding: 15px !important;font-size: 1.4rem !important;font-weight: 600;}
        table thead th, table tbody td{padding-left: 0 !important;}
        table tbody td{padding: 1.4rem 0 1.4rem 0 !important;}
        .td-line{line-height: 28px;}
        .section-price{margin-top: -5px;}
        @media only screen and (min-width: 768px) {
            table tbody td:first-child{width: 35%;}
        }
        @media only screen and (min-width: 1366px) {
            .search-input{margin-top: 33px;}
            table tbody td:first-child{width: 38%;}
        }
    </style>
@endsection
@section('js')
    <script>
        $(document).ready(function(){

            {!! js_code_product_page() !!}

            // Remote Datasource
            let cache = {};
            $(".ac-remote-datasource").autocomplete({
                source: function(request, response) {

                    let term = request.term;
                    if (term in cache) {
                        window.setTimeout(function(){
                            $(".ac-remote-datasource").removeClass('ui-autocomplete-loading');
                            response(cache[term]);
                        }, 150);
                        return;
                    }

                    $('.search-error').html('');

                    $.ajax({
                        url: "/api/get/product/?limit=15&is_input=N&fields=id,name,sku,price&order=name%20asc",
                        data: {
                            search_pdv: request.term
                        },
                        success: function(data) {
                            let array = data.error ? [] : $.map(data, function(m) {
                                return {
                                    label: m.id+' - '+m.name+' - R$ '+m.price,
                                    value: m.id,
                                    name : m.name,
                                    price: m.price,
                                };
                            });
                            $(".ac-remote-datasource").removeClass('ui-autocomplete-loading');
                            cache[term] = array;
                            response(array);
                        },
                        error: function (data, xhr, ajaxOptions, thrownError) {
                            $(".ac-remote-datasource").removeClass('ui-autocomplete-loading');
                            $('.search-error').html(data.responseJSON.messages);
                        }
                    });

                },
                minLength: 2,
                highlight: true,
                select: function (event, ui) {
                    addProduct( ui.item.value, ui.item.name, ui.item.price );
                    bind();
                    event.preventDefault();
                    return false;
                },
                change: function () {
                    $('.search-error').html('');
                },
                close : function(event)
                {
                    if ( $(".ac-remote-datasource").is(":focus") )
                    {
                        event.preventDefault();
                        $(".ac-remote-datasource").autocomplete("search");
                    }
                }
            }).focus();
        });

        @php $additional = array_get( $product, 'additional', [] ); @endphp
        @if( !empty( $additional ) )
            @foreach( $additional as $row )
                @php
                    $price = !is_null( $row['price'] ) ? $row['price'] : $row['original_price'];
                @endphp
                addProduct( '{!! $row['id'] !!}', '{!! $row['name'] !!}', '{!! format_number($price, 2) !!}', '{!! $row['free'] !!}' );
            @endforeach
            bind();
        @endif

        function addProduct( id, name, price, free ){

            let check      = (  parseFloat(price) > 0 ? ''  : 'checked' );
            let checkValue = (  parseFloat(price) > 0 ? '0' : '1' );

            if ( typeof free !== "undefined" ){
                check      = (  parseInt(free) === 0 ? ''  : 'checked' );
                checkValue = (  parseInt(free) === 0 ? '0' : '1' );
            }

            if( $('.tr-'+id).length === 0 ) {
                $('.product-list tbody').append('<tr class="tr-' + id + ' tr-section" data-id="' + id + '">\n' +
                    '     <td class="td-line">' + name + '</td>\n' +
                    '     <td class="td-line">' +
                    '       <input type="checkbox" class="switchBootstrap free-'+id+'" data-id="'+id+'" name="status" data-value="'+checkValue+'"\n' +
                    '              data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" '+check+' />\n' +
                    '     <td>\n' +
                    '         <div class="input-group section-price border-0">\n' +
                    '             <span class="text-unit"></span>\n' +
                    '             <input type="text" value="' + price + '" maxlength="60" placeholder="Preço" class="price-'+id+' price form-control">\n' +
                    '             <span class="input-group-append">\n' +
                    '                 <button class="btn btn-delete btn-danger" data-id="' + id + '" type="button"><i class="ft-x"></i></button>\n' +
                    '             </span>\n' +
                    '         </div>\n' +
                    '     </td>\n' +
                    ' </tr>');
            }
        }

        function bind() {

            let elemSwitch = $('.switchBootstrap');
            let elemPrice  = $('.price');

            elemSwitch.bootstrapSwitch('destroy', true);
            elemSwitch/*.on('change.bootstrapSwitch', function(e, data) {
                let scope      = $(this);
                let id         = scope.attr('data-id');
                let elemPrice  = $('.price-'+id);
                let state      = !$(this).bootstrapSwitch('state');
                elemPrice.attr('disabled', true);
                if( state === false ){
                    elemPrice.attr('disabled', false);
                }
            })*/.bootstrapSwitch();

            elemPrice.maskMoney('destroy');
            elemPrice.maskMoney({thousands:'.', decimal:',', symbolStay: false});

            $('.btn-save').off().on( 'click', function () {
                let elemBtn   = $( this );
                let textBtn   = elemBtn.html();

                elemBtn.html( helper.htmlSpinner() ).attr('disabled',true);

                let elemTr    = $('.tr-section');
                let elemProd  = $('.prod-qty-free');
                let dataItems = { qty_free: parseInt( elemProd.val() ), items: [] };
                $.each( elemTr, function (index, elem ) {
                    elem = $( elem );
                    let prodID = elem.data('id');
                    let isFree = $('.free-'+prodID).bootstrapSwitch('state') ? 1 : 0;
                    let price  = parseFloat( $( '.price-'+prodID ).val().toString().replace('.','').replace(',','.') );

                    dataItems.items.push({ prod_id: prodID, free: isFree, price: price });
                } );

                $.ajax({
                    url: "/api/put/product@"+elemProd.data('sku')+"@additional",
                    data: dataItems,
                    success: function(data) {
                        helper.alertSucess('Ação efetuada com sucesso!');
                        location.reload();
                    },
                    error: function (data, xhr, ajaxOptions, thrownError) {
                        elemBtn.html( textBtn ).attr('disabled',false);
                        helper.alertError(data.responseJSON.messages);
                    }
                });
            });

            $('.btn-delete').off().on( 'click', function () {
                let scope = $(this);
                $('.tr-'+scope.data('id')).remove();
                /*swal({
                    title: 'Atenção!',
                    html: 'Deseja realmente excluir esse item?',
                    type: "warning",
                    confirmButtonText: "SIM",
                    cancelButtonText: "NÃO",
                    width: '462px',
                    showCancelButton: true
                }).then((dismiss) => {
                    if (dismiss.value) {
                        $('.tr-'+scope.data('id')).remove();
                    }
                });*/
            } );
        }

    </script>
@endsection
