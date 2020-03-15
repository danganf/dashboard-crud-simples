@extends('layout')

@section('content')

    <section class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="cardFilter" class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 col-xl-7">
                                <div class="row config">
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <h4 class="p-1">
                                            <i class="la la-sitemap"></i> Rendimento <small>(Porções)</small>
                                            <input type="number" min="1" id="main-yield" class="form-control input update col-md-5 col-lg-4" value="0">
                                        </h4>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <h4 class="p-1 mb-0">
                                            <i class="la la-arrow-circle-up"></i> Markup
                                            <input type="number" step=".01" id="markup" min="1" class="form-control input update col-md-5 col-lg-4" value="0">
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-5">
                                @component('components.catalog.financial-information') @endcomponent
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-12">
                                <h4 class="back-section"><i class="la la-sliders"></i> Receita</h4>
                                <div class="row mb-1">
                                    <div class="col-md-6 col-lg-5 col-xl-4">
                                        <div class="input-group search-input">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ft-search"></i></span></div>
                                            <input type="text" class="form-control ac-remote-datasource ui-autocomplete-input" data-action="recipe" placeholder="Digite nome ou ID de um insumo" autocomplete="off">
                                        </div>
                                        <div><small class="search-error search-error-recipe text-danger font-weight-bold"></small></div>
                                    </div>
                                </div>

                                <table class="table table-hover table-striped table-de table-products border mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Insumo</th>
                                            <th class="border-top-0">Volume Bruto</th>
                                            <th class="border-top-0">Quantidade de Saída</th>
                                            <th class="border-top-0">Rendimento</th>
                                            <th class="border-top-0">Custo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="product-list product-list-recipe">

                                    </tbody>
                                    <tfoot>
                                        <tr class="tr-footer tr-footer-recipe">
                                            <td class="td-line truncate td-prod-name" style="text-align: right !important;" colspan="3">SUBTOTAL</td>
                                            <td class="td-line truncate td-prod-name liquid-weight" data-value="0.00">0,00</td>
                                            <td class="td-line truncate td-prod-name liquid-price" data-value="0.00">R$ 0,00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-12">
                                <h4 class="back-section"><i class="la la-list"></i> Materiais de apoio (Embalagens, sacos, etc...)</h4>
                                <div class="row mb-1">
                                    <div class="col-md-6 col-lg-5 col-xl-4">
                                        <div class="input-group search-input">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ft-search"></i></span></div>
                                            <input type="text" class="form-control ac-remote-datasource ui-autocomplete-input" data-action="inputs" placeholder="Digite nome ou ID de um insumo" autocomplete="off">
                                        </div>
                                        <div><small class="search-error search-error-inputs text-danger font-weight-bold"></small></div>
                                    </div>
                                </div>

                                <table class="table table-hover table-striped table-de table-products border mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Insumo</th>
                                            <th class="border-top-0">Volume</th>
                                            <th class="border-top-0">Quantidade de Saída</th>
                                            <th class="border-top-0">Custo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="product-list product-list-inputs">

                                    </tbody>
                                    <tfoot>
                                        <tr class="tr-footer tr-footer-inputs">
                                            <td class="td-line truncate td-prod-name" style="text-align: right !important;" colspan="3">SUBTOTAL</td>
                                            <td class="td-line truncate td-prod-name liquid-price" data-value="0.00">R$ 0,00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-12">
                                <h4 class="back-section"><i class="la la-list"></i> Sub-receitas</h4>
                                <div class="row mb-1">
                                    <div class="col-md-6 col-lg-5 col-xl-4">
                                        <div class="input-group search-input">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ft-search"></i></span></div>
                                            <input type="text" class="form-control ac-remote-datasource ui-autocomplete-input" data-action="subrecipe" placeholder="Digite nome ou ID de um produto" autocomplete="off">
                                        </div>
                                        <div><small class="search-error search-error-inputs text-danger font-weight-bold"></small></div>
                                    </div>
                                </div>

                                <table class="table table-hover table-striped table-de table-products border mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0">Produto</th>
                                        {{--<th class="border-top-0">Volume</th>--}}
                                        <th class="border-top-0">Quantidade de Saída</th>
                                        <th class="border-top-0">Custo</th>
                                    </tr>
                                    </thead>
                                    <tbody class="product-list product-list-subrecipe">

                                    </tbody>
                                    <tfoot>
                                    <tr class="tr-footer tr-footer-subrecipe">
                                        <td class="td-line truncate td-prod-name" style="text-align: right !important;" colspan="2">SUBTOTAL</td>
                                        <td class="td-line truncate td-prod-name liquid-price" data-value="0.00">R$ 0,00</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="container-fluid back-section">
                                    <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <h4><i class="la la-sort-numeric-asc"></i> Modo de preparo </h4>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                <button type="button" class="btn btn-add-mode btn-sm btn-secondary"><i class="la la-plus" style="opacity: 0.9;font-size: 1.2rem;"></i></button>
                                            </div>                                            
                                    </div>
                                    <div class="content-mode"></div>
                                </div>
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
        .td-line{line-height: 20px}
        .border tr th, .border tr td{border: 1px solid #e3ebf3 !important;}
        .border tr td.value-total{font-weight: 700;font-size: 1.3rem;}
        .table.table-de th, .table.table-de td {padding: 0.75rem 0.6rem !important;}
        .table-products td {text-align: center;}
        .table.table-de td input {font-weight: 600;font-size: 1.1rem;text-align: center;}
        .td-prod-name{text-align: left !important;}
        .td-prod-weight{width: 15%;}
        .td-prod-others{width: 10%;}
        .truncate {text-overflow: ellipsis;overflow: hidden;white-space: nowrap;}
        .config h4{background-color: #F1F1F4;line-height: 30px;}
        .config input.input{font-size: 1.3rem;top: -7px;float: right;}
        .search-input{margin-top: 10px;}
        .search-input input{padding: 15px;}
        .tr-footer td{font-size: 1.3rem;font-weight: 600;}
        .tr-footer .liquid-weight, .tr-footer .liquid-price{text-align: center !important;}
        .content-mode{margin-bottom: 20px;}
        .content-mode .list{border-top: 2px dashed #d4d4dd;padding-top: 10px;margin-top: 20px;}
        .content-mode .list input{padding: 15px;}
        .content-mode .list span{font-weight: 600;text-transform: uppercase;}
        .back-section{background-color: #F1F1F4;padding: 10px;max-width: 100%;}

        .input-group { min-width: 150px; }

        .class-warning-prod{float: left;position: absolute;margin: -3px 0 0 36px;background: #f8546a;color: white !important;padding: 3px;border-radius: 7px;border-left: 10px solid #FC9148;text-transform: uppercase;}
        .class-warning-prod i{float: left;padding-right: 4px;}

        @media (min-width:320px) {

        }
        @media (min-width:768px) {
            .config {margin-bottom: 10px;}
            .config h4{padding-bottom: 16px !important;}
        }
        @media (min-width:1024px) {
            .config {margin-bottom: 0;}
            .config input.input{font-size: 1.3rem;}
        }
        @media (min-width:1366px) {
            .config h4{padding-bottom: 65px !important;}
            .config input.input{font-size: 1.3rem;}
        }
        @media (min-width:1440px) {

        }
        @media (min-width:1880px) {

        }
    </style>
@endsection
@section('js')
    <script>
        $(document).ready(function(){

            {!! js_code_product_page() !!}

            let productionSheet = new ProductionSheet();
            productionSheet.init( '{!! $sku !!}', productionSheet );

            @if( !empty( array_get( $product, 'production_sheets' ) ) )

                productionSheet.c._elemMainYield.val('{!! array_get( $product, 'production_sheets.tt_yield' ) !!}');
                productionSheet.c._elemMarkup.val('{!! array_get( $product, 'production_sheets.markup' ) !!}');

                let items       = [];
                let grossWeight = 0;

                @foreach( array_get( $product, 'production_sheets.items' ) as $item)
                    grossWeight = helper.formatInputValToFloat( '{!! $item['item_gross_weight'] !!}', 2 );
                    items.push( { label: '{!! $item['name'] !!}', 
                                  value: '{!! $item['item_id'] !!}', 
                                  gross_weight: grossWeight, 
                                  unit: '{!! $item['volume'] .' '.$item['volume_type'] !!}', 
                                  yield: '{!! $item['item_yield'] !!}', 
                                  volume: '{!! $item['volume'] !!}', 
                                  volume_type: '{!! $item['volume_type'] !!}', 
                                  name: '{!! $item['name'] !!}', 
                                  initials: '{!! $item['initials'] !!}',
                                  action: '{!! $item['item_session'] !!}', 
                                  price: helper.formatInputValToFloat( '{!! $item['price'] !!}', 2 ) } );
                @endforeach

                @if( is_array( array_get( $product, 'production_sheets.mode' ) ) )
                    @foreach( array_get( $product, 'production_sheets.mode' ) as $item )
                        $('.btn-add-mode').trigger('click');
                        $('input.mode').last().val('{!! $item !!}');
                    @endforeach
                @endif

                $.each( items, function (index, elem) {
                    productionSheet.addProduct( elem, elem.action );
                } );
                productionSheet.updateValues( productionSheet );
                productionSheet.bind( productionSheet );

             @else

                productionSheet.c._elemMainYield.val('4');
                productionSheet.c._elemMarkup.val('3');

            @endif

            productionSheet.c._elemMainYield.focus()
        } );

    </script>
@endsection
