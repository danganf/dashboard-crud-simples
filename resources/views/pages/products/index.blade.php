@extends('layout')

@section('css')

    <style>
        ul.attributes{margin: -2px 0 0 19px;list-style: none;}
        ul.attributes li{line-height: 0;}
        .modal{display: block;opacity:1;background: rgba(0, 0, 0, 0.5);}
        .modal-dialog{opacity:1 !important;margin-top:10%;}
        .modal-body{max-height: 450px;overflow: hidden;overflow-y: auto;}
        .border{margin-top: 15px;}
        .border tr td.value-total{font-weight: 700;font-size: 1.3rem;}
        .border tr th, .border tr td{border: 1px solid #e3ebf3 !important;}
        .image-datasheet, .name-recipe, .logo{display: none;}
        img.datasheet {height: 26%;margin-top: 14px;}
        .badge-price {font-size: 110%}
        .bs-callout-pink.callout-transparent p:last-child { margin-bottom: 0; }
        .bs-callout-pink.callout-transparent { display: block;  border-color: #ffa000 !important; background-color: transparent; border-radius: 0.25rem; color: #070103;}
        .border-gray { border: 1px solid #cccccc !important; }
        .gray { color: #cccccc !important; }
        .cards-background { background-color: whitesmoke; margin-top: 26px;}
        .tag-insumo-unit {padding-bottom: 10px;}
        .container-tags {padding-bottom: 10px;}
        .cards-title-style {margin-bottom: 0.5rem;}
        .product-quick-actions { overflow: visible; white-space: nowrap; margin-bottom: 0;}
        .product-title {margin-top: 10px;}
        .margin-b-5{margin-bottom: 5px;}
        .badge-top-right {position: absolute;right: 10px;margin-top: 6px;background-color: #fff !important;}
        .card-body {flex: 1 1 auto;padding: 1.0rem;}
        .subrecipe{background-color: #F1F1F4;font-weight: 600;}
        .dropdown-item{color: #1e2122 !important;}
        .dropdown-item-section{margin-top: 7px;padding-top: 10px;border-top:1px dashed #e3ebf3}

        @media only screen and (min-width: 768px) {
            .modal-dialog{top: 100px;}
            .modal-body{max-height: 470px;}
            .section-mode{margin-bottom: 0;}
            .margin-b-5{margin-bottom: 0;}
        }
        @media only screen and (min-width: 1024px) {

        }
        @media only screen and (min-width: 1300px) {

        }
        @media only screen and (min-width: 1440px) {

        }
        @media only screen and (min-width: 1920px) {

        }
        @media (min-width: 576px) {
            .container {
                max-width: 800px; 
            }
        }

    </style>
@endsection
@section('content')

    <!-- FILTROS -->
    <div class="row">
        @include('pages.products.includes.filter')
    </div>
    <!--/ FILTROS -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header reload-card" id="last-orders">
                    <h4 class="card-title"></h4>
                    <div class="heading-elements">
                        <button onclick="location.href='{{route('catalog.products.new_'.$action)}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
                        <span class="dropdown"></span>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div id="last-orders" class="media-list position-relative">
                        <div class="content-wrapper cards-background">
                                                    
                                @if( count( $products ) > 0 )

                                    <div class="row match-height">

                                    @foreach( $products AS $key => $product )

                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            @php
                                                $urlImg   = ( empty( $product['image'] ) ) ? '/app-assets/images/portfolio/portfolio-1.jpg' : $product['image'];
                                                $prodTags = '';
                                                if( is_array( $product['tags'] ) ){
                                                    $prodTags = implode(', ', pluckMatriz($product['tags'], 'name'));
                                                }
                                            @endphp
                                                <div class="card" >
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="row no-gutters">
                                                                <div class="col-9">
                                                                    <div class="dropdown">
                                                                        <button id="btnSearchDrop2" style="border-radius: 1.25rem;opacity: 0.8" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-secondary btn-sm btn-light dropdown-toggle margin-b-5 dropdown-menu-right"><i class="ft-menu"></i></button>
                                                                        <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right" data-image="{!! $urlImg !!}" data-name="{{$product['name']}}" data-sku="{{$product['sku']}}">

                                                                            <a href="{{route('catalog.products.view_'.$action, $product['sku'])}}" class="dropdown-item" data-id="{{$product['sku']}}">
                                                                                    <i class="la la-edit"></i> Editar
                                                                            </a>

                                                                            <a href="{{route('catalog.products.view_'.$action.'_duplicate', $product['sku'])}}" class="dropdown-item"><i class="la la-copy"></i> Duplicar</a>

                                                                            @if( $action === 'main' && !empty( array_get( $product, 'manufacture' ) ) && array_get( $product, 'manufacture' ) == 'PRÓPRIA' )
                                                                                <a class="dropdown-item btn-financial"><i class="la la-money"></i> Financeiro</a>
                                                                                <a class="dropdown-item btn-datasheet"><i class="la la-newspaper-o"></i> Ficha técnica</a>
                                                                            @endif

                                                                            @if( array_get(sessionOpen('get'),'role_name','') === 'Administrador' )
                                                                            <a class="dropdown-item dropdown-item-section btn-delete" data-id="{{$product['sku']}}"><i class="la la-trash"></i> Excluir</a>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div class="product-title">
                                                                        <h4 class="card-title cards-title-style"><a href="{{route('catalog.products.view_'.$action, $product['sku'])}}" class="card-link pink">{{$product['name']}}</a></h4>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3 text-right">
                                                                    <div class="form-group product-quick-actions">
                                                                        <input type="checkbox" id="switch-key-{{$key}}" name="status" class="switchery" data-size="xs" {{$product['status'] ? 'checked' : ''}} data-sku="{{$product['sku']}}" data-key="{{$key}}" data-switchery="true" style="display: none;">
                                                                        <label for="switch-key-{{$key}}" ><i class="la la-plug"></i></label>
                                                                    </div>
                                                                    @if( $action === 'main' )
                                                                        <div class="form-group product-quick-actions">
                                                                                <input type="checkbox" id="switch-key-{{$key}}" name="in_app" class="switchery" data-size="xs" {{$product['in_app'] ? 'checked' : ''}} data-sku="{{$product['sku']}}" data-key="{{$key}}" data-switchery="true" style="display: none;"> <label for="switch-key-{{$key}}" ><i class="la la-mobile-phone"></i></label>
                                                                        </div>
                                                                        <div class="form-group product-quick-actions">
                                                                                <input type="checkbox" id="switch-key-{{$key}}" name="in_home_app" class="switchery" data-size="xs" {{$product['in_home_app'] ? 'checked' : ''}} data-sku="{{$product['sku']}}" data-key="{{$key}}" data-switchery="true" style="display: none;">
                                                                                <label for="switch-key-{{$key}}" ><i class="la la-star-o"></i></label>
                                                                        </div>     
                                                                    @endif                                                                                                                                           
                                                                </div>
                                                            </div>
                                                            @if( $action === 'main' )
                                                                <div style="display: inline-block">
                                                                    <h6 class="card-subtitle text-muted pink">R$ {{$product['price']}}</h6>
                                                                </div>
                                                            @endif
                                                            @if( $product['qty_ready'] > 0 )
                                                                <div><small>Disponível: <strong>{{$product['qty_ready']}}</strong></small></div>
                                                            @endif
                                                            <div><small>Setor: <strong>{{ $product['sector_name'] }}</strong></small></div>
                                                            <div><small>ID: <strong>{{$product['id']}}</strong></small></div>
                                                        </div>
                                                        <div>
                                                            <a href="{{route('catalog.products.view_'.$action, $product['sku'])}}">
                                                                <img class="img-fluid" style="width: 100%" src="{!! $urlImg !!}" alt="{{$product['name']}}">
                                                            </a>
                                                            @if( $action === 'main' )
                                                                @if( !empty( array_get( $product, 'manufacture' ) ) ) 
                                                                    @if ($product['manufacture'] == 'PRÓPRIA')
                                                                        <div class="badge badge-pill margin-b-5 badge-border border-success success badge-top-right">Fabricação Própria</div>
                                                                    @elseif ($product['manufacture'] == 'REVENDA') 
                                                                        <div class="badge badge-pill badge-border border-warning warning badge-top-right">Revenda</div>
                                                                    @else 
                                                                        <div class="badge badge-pill badge-border border-info info badge-top-right">Outros</div>
                                                                    @endif
                                                                @else 
                                                                    <div class="badge badge-pill badge-border border-gray gray badge-top-right">Indefinido</div>
                                                                @endif
                                                            @else
                                                                    <div class="badge badge-pill badge-border border-info info badge-top-right">{{array_get( $product, 'unit.initials', 'Não Definido' )}}</div>
                                                            @endif                                                            
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row no-gutters container-tags">
                                                                <div class="col-6">    
                                                                    <!-- p class="card-text" -->
                                                                        @if( !empty( $product['categories'] ) )
                                                                            @foreach( $product['categories'] as $row )
                                                                                <div><small>{{$row['name']}}</small></div>
                                                                            @endforeach
                                                                        @endif                                                                    
                                                                    <!-- /p -->
                                                                </div>
                                                                <div class="col-6 text-right">
                                                                    <p class="card-text">
                                                                        @if( !empty( $prodTags ) )
                                                                            <span><small>{!!  $prodTags  !!} <i class="la la-tag align-middle"></i></small></span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>   
                                        </div>                                                                         
                                    @endforeach
                                    </div>
                                @else
                                    <div>Ops! Não encontrei nenhum produto...</div>
                                @endif                          
                        </div>
                    </div>
                    @component('components.paginator', ['paginator'=>$paginator, 'paginator_info' => $paginator_info])@endcomponent
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-default')

    <div class="hidden template-datasheet">
            <div class="container">
                <div class="col-md-12 text-center logo">
                    <img src="/assets/images/logo-full.jpg" alt="logo">
                </div>
                <div class="col-md-12">
                    <h4>
                        <span class="name-recipe">
                            Receita: <strong>_NAME_RECIPE_</strong>
                            <br>
                        </span>
                        Redimento: <strong>_TT_YIELD_ porções</strong>
                    <div class="pull-right btn-print font-weight-bold cursor-pointer badge badge-secondary"><i class="la la-print"></i> Imprimir</div>
                    </h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-hover table-striped table-de table-products border mb-0">
                        <thead>
                        <tr>
                            <th class="border-top-0">Insumo</th>
                            <th class="border-top-0 text-center">Quantidade de Saída</th>
                            <th class="border-top-0 text-center">Volume</th>
                        </tr>
                        </thead>
                        <tbody class="product-list datasheet-body"></tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-1 section-mode">
                    <h4 class="text-center" style="background-color: #F1F1F4;padding: 10px 10px 5px 10px;">Modo de preparo</h4>
                    <table class="table table-hover table-striped table-de border mb-0">
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-2 image-datasheet" align="center"></div>
            </div>

    </div>

    <div class="hidden template-financial">
        @component('components.catalog.financial-information', [ 'markup' => true, 'yeild' => true ] ) @endcomponent
    </div>

@endsection

@section('js')

    <script>

        $( document ).ready(function() {
            $(".switchery").on('change', function(e, data) {

                //var $el = $(data.el);
                let scope        = $(this);
                let key          = scope.attr('data-key');
                let name         = scope.attr('name');

                let currentState   =  scope[0].checked;
                let nextState      =  ((currentState) ? 1 : 0);

                $('.switch-toggle-' + name + key).css("opacity", "0.35");

                let dataSend = {in_app: nextState, no_process_sync: true};

                if ( name === 'in_home_app' ){
                    dataSend = {in_home_app: nextState, no_process_sync: true};
                } else if ( name === 'status' ){
                    dataSend = {status: nextState, no_process_sync: true};
                }

                $.ajax({
                    url: "/api/patch/product@"+scope.attr('data-sku'),
                    method: 'POST',
                    data: dataSend,
                    success: function (data, jqXHR) {
                        $('.switch-toggle-'+name+key).css("opacity", "1");
                        //$('.show-icon-spin'+key).hide();
                    },
                    error: function(data, jqXHR) {
                        $('.switch-toggle-'+name+key).css("opacity", "1");
                        helper.alertError(data.responseJSON.messages);
                    }
                });

            });
            $("#tags_filter, #category_filter").select2({
                placeholder: "Selecione",
                width: '100%',
            });
        });

        $('.btn-financial').on( 'click', function () {
            let scope = $( this );

            let elemModal = helper.startModalDefault( 'Informações financeiras' );
            elemModal.html( helper.htmlSpinner() );

            $.ajax({
                url: "/api/get/product@"+scope.parent().attr('data-sku')+'@production-sheet',
                success: function (data, jqXHR) {
                    elemModal.html( $('.template-financial').html() );
                    elemModal.css('padding', '0 30px 30px 30px');
                    $('td.yeild').html( data.tt_yield );
                    $('td.markup').html( data.markup );
                    $('td.total-cost').html( 'R$ ' + data.total_cost );
                    $('td.portion-cost').html( 'R$ ' + data.portion_cost );
                    $('td.kilo-cost').html( 'R$ ' + data.kilo_cost );
                    $('td.price-sale-portion').html( 'R$ ' + data.price_sale_portion );
                    $('td.price-sale-kilo').html( 'R$ ' + data.price_sale_kilo );
                },
                error: function(data, jqXHR) {

                    elemModal.html( '<p class="text-danger">' + data.responseJSON.messages + '</p>' );
                }
            });
        } );

        $('.btn-datasheet').on( 'click', function () {
            let scope = $( this );

            let elemModal = helper.startModalDefault( 'Ficha Ténica de Produção' );
            elemModal.html( helper.htmlSpinner() );
            elemModal.css('padding', '0');

            $.ajax({
                url: "/api/get/product@"+scope.parent().attr('data-sku')+'@production-sheet',
                success: function (data, jqXHR) {

                    let textHtml    = '';
                    let inSubRecipe = false;
                    $.each( data.items, function (key, elem) {

                        let qtd = parseFloat(elem.item_gross_weight.replace(',', '.'));
                        qtd = ( (qtd % 1 != 0) ? qtd : qtd.toFixed(0) );

                        let volume = parseFloat(elem.volume.replace(',', '.'));
                        volume = volume * qtd;

                        let volume_type = helper.getVolumeUnitLabel(volume, elem.volume_type);

                        if( elem.item_session === 'subrecipe' && inSubRecipe === false ){
                            textHtml += '<tr>' +
                                            '<td class="td-line subrecipe" colspan="3">SUB-RECEITAS</td>' +
                                        '</tr>';
                            inSubRecipe = true;
                        }

                        textHtml += '<tr>' +
                                        '<td class="td-line truncate">'+elem.name+'</td>' +
                                        '<td class="td-line truncate text-center">'+ qtd +'x ' + elem.initials+ '</td>' +
                                        '<td class="td-line truncate text-center">'+ volume +' '+ volume_type +'</td>' +
                                    '</tr>';
                    } );

                    let text = $('.template-datasheet').html();
                        text = text.replace('_TT_YIELD_', data.tt_yield);
                        text = text.replace('_NAME_RECIPE_', scope.parent().attr('data-name'));

                    elemModal.html( text );

                    $('.datasheet-body').html( textHtml );
                    $('.image-datasheet').html(
                        '<h4 class="text-center" style="background-color: #F1F1F4;padding: 10px 10px 5px 10px;text-align: center">Foto</h4>' +
                        '<img src="'+scope.parent().data('image')+'" class="media-object datasheet" alt="imagem">'
                    );

                   if( data.mode !== null ){
                       $('.section-mode h4').show();
                       let elemSectionMode = $('.section-mode table tbody');
                       elemSectionMode.html('');
                       $.each( data.mode, function ( index, value ) {
                           elemSectionMode.append('<tr>\n' +
                               '    <td style="width: 16%;font-weight: 600">PASSO '+(++index)+'</td>\n' +
                               '    <td>'+value+'</td>\n' +
                               '</tr>').css;
                       } );
                   } else {
                       $('.section-mode h4').hide();
                   }

                    $('.btn-print').off().on( 'click', function () {
                        $(".content-main-default").printThis({
                            debug: false,               // show the iframe for debugging
                            importCSS: true,            // import parent page css
                            importStyle: false,         // import style tags
                            printContainer: true,       // print outer container/$.selector
                            loadCSS: "/assets/css/catalog/catalog-modal-print.css",// path to additional css file - use an array [] for multiple
                            pageTitle: "",              // add title to print page
                            removeInline: false,        // remove inline styles from print elements
                            removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                            printDelay: 333,            // variable print delay
                        });
                    } );
                },
                error: function(data, jqXHR) {

                    elemModal.html( '<p class="text-danger">' + data.responseJSON.messages + '</p>' );
                }
            });
        } );

        @include('includes.filter-js')

        @php $url = 'product'.($action === 'main') @endphp

        @if( array_get(sessionOpen('get'),'role_name','') === 'Administrador' )
            cruds.bindDelete('product');
        @endif

    </script>
@endsection
