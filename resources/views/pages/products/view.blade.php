@extends('layout')

@section('css')
    <style>
        div.form-group{background-color: #f5f7fa !important;}
        div.form-group label{font-weight: 600;}
        @media (min-width:320px) {
            .stock-min{padding-bottom: 10px;}
            .unit{margin-top: 10px;}
        }
        @media (min-width:768px) {
            .unit {margin-left: -40px;margin-top: 0;}
            .stock-min{padding-bottom: 0;}
        }
        @media (min-width:1024px) {
            .unit {margin-left: -40px;}
        }
        @media (min-width:1440px) {
            .unit {margin-left: -50px;}
        }
        @media (min-width:1880px) {
            .unit {margin-left: -70px;}
        }
    </style>
@endsection
@section('content')

    @php
        $status      = array_has($product, 'config.status')      ? ( array_get($product, 'config.status')      ? 1 : 0 ) : '';
        $inApp       = array_has($product, 'config.in_app')      ? ( array_get($product, 'config.in_app')      ? 1 : 0 ) : '';
        $inHomeApp   = array_has($product, 'config.in_home_app') ? ( array_get($product, 'config.in_home_app') ? 1 : 0 ) : '';
        $isInput     = array_has($product, 'config.is_input')    ? ( array_get($product, 'config.is_input')    ? 1 : 0 ) : '';
        $type        = array_get($product, 'type', '');
        $manufacture = array_get($product, 'manufacture', 'PRÓPRIA');

    @endphp

    <section class="row">
        <div class="col-md-12">
            <form class="form form-horizontal striped-labels form-bordered" id="formProduct"
                  data-sku="{{ !$isDuplicate ? array_get($product, 'sku') : '' }}"
                  method="post" onsubmit="return false">
                {{csrf_field()}}
                <div class="card">
                    <div class="card-header reload-card">
                        <h4 class="card-title info"><i class="la la-info-circle"></i> Dados principais</h4>
                    </div>
                    <div id="cardFilter" class="card-content collapse show">
                        <div class="card-body">

                            <div class="form-body">
                                <h4></h4>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="type">Tipo</label>
                                    <div class="col-md-9">
                                    @if( empty( $sku ) )
                                        <select class="form-control verify-origin-value col-md-4" id="type" name="type" data-value="">
                                        @if( $action !== 'inputs' )
                                            <option value="">--</option>
                                        @endif
                                            <option value="ITEM">ITEM</option>
                                        @if( $action !== 'inputs' )
                                                <option value="SIMPLES">SIMPLES</option>
                                        @endif
                                        </select>
                                    @else
                                        @if( $isDuplicate )
                                        <input type="hidden" id="type" name="type" value="{{$type}}">
                                        @endif
                                        <strong>{{$type}}</strong>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="name">Nome*</label>
                                    <div class="col-md-9">
                                        <input type="text" id="name" class="form-control verify-origin-value" placeholder="Nome interno" value="" data-value="" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="sku">SKU*</label>
                                    <div class="col-md-9">
                                        <input type="text" id="sku" class="form-control verify-origin-value col-md-12 col-lg-6" placeholder="Identificador único" data-value="" value="" name="sku">
                                    </div>
                                </div>
                            @if( $type != 'ITEM' && $action !== 'inputs' )
                                <div class="form-group row only-simples">
                                    <label class="col-md-3 label-control" for="name_front">Nome Site/App*</label>
                                    <div class="col-md-9">
                                        <input type="text" id="name_front" class="form-control verify-origin-value" placeholder="Nome App/Site" data-value="" name="name_front" value="">
                                    </div>
                                </div>
                            @endif
                            @if( $action === 'inputs' )
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="unit_id">Unidade de saída*</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-4" id="unit_id" data-value="" name="unit_id">
                                            <option value="">--</option>
                                            @foreach( $units AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="unit_id_in">Unidade de compra*</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-4" id="unit_id_in" data-value="" name="unit_id_in">
                                            <option value="">--</option>
                                            @foreach( $units AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="category_id">Categorias*</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-10" id="categories"  multiple="multiple" data-value="" name="categories[]">
                                        @if( empty( $sku ) )
                                            <option value="">--</option>
                                        @endif
                                        @foreach( $categories AS $row )
                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="tags">Tags</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-10" id="tags" multiple="multiple" data-value="" name="tags[]">
                                            @foreach( $tags AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @if( $action === 'inputs' )
                                <div class="form-group row no-simples">
                                    <label class="col-md-3 label-control" for="providers">Fornecedores</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-10" id="providers" multiple="multiple" data-value="" name="providers[]">
                                            @foreach( $providers AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="sector_id">Setor*</label>
                                    <div class="col-md-9">
                                        <select class="form-control verify-origin-value col-md-12 col-lg-4" id="sector_id" data-value="" name="sector_id">
                                            @if( empty( $sku ) )
                                                <option value="">--</option>
                                            @endif
                                            @foreach( $sectories AS $row )
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @if( $action !== 'inputs' )
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="price">Preço*</label>
                                    <div class="col-md-9">
                                        <input type="text" id="price" class="form-control verify-origin-value col-md-6 col-lg-4 col-xl-2" placeholder="EX: 10,20" name="price" data-value="" value="">
                                    </div>
                                </div>
                            @endif
                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="status">Status*</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" class="switchBootstrap" id="status" name="status" data-value="{{$status}}"
                                               data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" {{$status ? 'checked' : ''}}/>
                                    </div>
                                </div>
                            @if( $action === 'inputs' )
                                <div class="form-group row no-simples">
                                    <label class="col-md-3 label-control" for="is_input">Prioridade*</label>
                                    <div class="col-md-9 is_input">
                                        <select class="form-control verify-origin-value col-sm-1 col-md-3 col-lg-4 col-xl-3" id="priority" name="priority" data-value="">
                                            <option value="">--</option>
                                        @foreach( $prioritys as $priority )
                                            <option value="{{$priority['id']}}">
                                                {{$priority['id'].' - '.$priority['label']}}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if( $type != 'ITEM' && $action !== 'inputs' )
                                <div class="form-group row only-simples">
                                    <label class="col-md-3 label-control" for="in_app">Publicar*</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" class="switchBootstrap" id="in_app" name="in_app" data-value="{{$inApp}}"
                                               data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" {{$inApp ? 'checked' : ''}}/>
                                    </div>
                                </div>
                                <div class="form-group row only-simples">
                                    <label class="col-md-3 label-control" for="in_home_app">Mostrar na HOME do APP?</label>
                                    <div class="col-md-9">
                                        <input type="checkbox" class="switchBootstrap" id="in_home_app" name="in_home_app" data-value="{{$inHomeApp}}"
                                               data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" {{$inHomeApp ? 'checked' : ''}}/>
                                    </div>
                                </div>
                                <div class="form-group row only-simples">
                                    <label class="col-md-3 label-control" for="manufacture">Fabricação*</label>
                                    <div class="col-md-9">
                                    @foreach( config('app.manufacture') as $key => $row )
                                            <label for="manufacture-{{$key}}">{{$row}}</label>
                                            <input type="radio" value="{{$row}}" @if( $manufacture === $row ) checked @endif name="manufacture" id="manufacture-{{$key}}" class="jui-radio-buttons">
                                    @endforeach
                                    </div>
                                </div>
                                <div class="form-group row only-simples cooking_time">
                                    <label class="col-md-3 label-control" for="cooking_time">Tempo de preparo*<br><small>em minutos</small></label>
                                    <div class="col-md-9">
                                        <input type="number" min="0" id="cooking_time" class="form-control verify-origin-value col-md-2 col-lg-2 col-xl-1" placeholder="EX: 11" name="cooking_time" data-value="" value="">
                                    </div>
                                </div>
                            @if( $action !== 'inputs' )
                                <div class="form-group row only-simples">
                                    <label class="col-md-3 label-control" for="bar_code">EAN (cód.Barras)</label>
                                    <div class="col-md-9">
                                        <input type="text" id="bar_code" class="form-control verify-origin-value col-md-12 col-lg-10 col-xl-6" name="bar_code" data-value="" value="">
                                    </div>
                                </div>
                            @endif
                            @endif
                            @if( $action !== 'inputs' )
                                <div class="form-group row">
                                    <label class="col-md-3 label-control weight" for="weight">Peso* & unidade*</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-5 col-xl-3 only-simples">
                                                <input type="text" id="weight" class="form-control verify-origin-value col-md-10 col-lg-10 col-xl-9" placeholder="EX: 200,10" name="weight" data-value="" value="">
                                            </div>
                                            <div class="col-md-6 col-lg-7 div_unit unit">
                                                <select class="form-control verify-origin-value col-md-12 col-lg-10 col-xl-5" id="unit_id" data-value="" name="unit_id">
                                                @if( empty( $sku ) )
                                                    <option value="">--</option>
                                                @endif
                                                    @foreach( $units AS $row )
                                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif

                                <div class="form-group row">
                                    <label class="col-md-3 label-control" for="stock_min">
                                        Estoque
                                    @if( !empty( $sku ) )
                                            <br/>
                                            <span class="font-weight-normal">Qtd atual: {{array_get( $product, 'config.qty_ready')}}</span>
                                    @endif
                                    </label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-5 col-xl-3 stock-min">
                                                <span style="font-weight: 600">Mínimo*</span>
                                                <input type="number" id="stock_min" min="-1" class="form-control verify-origin-value col-md-12" placeholder="EX: 10" name="stock_min" data-value="" value="">
                                            </div>
                                            <div class="col-md-6 col-lg-5 col-xl-3">
                                                <span style="font-weight: 600">Máximo:</span>
                                                <input type="number" id="stock_max" min="-1" class="form-control verify-origin-value col-md-12" placeholder="EX: 10" name="stock_max" data-value="" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @include('pages.products.includes.content')

                <div class="card">
                    <div id="cardFilter" class="card-content">
                        <div class="card-body text-right">
                            <div class="">
                                <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        @if( $isDuplicate === FALSE )sss
        <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
            @include('pages.products.includes.list-grup')
        </nav>
        @endif
    </section>

@endsection

@section('js')
    <script>

        let prodType         = $('#type');
        let name             = $('#name');
        var sku              = $('#sku');
        let status           = $('#status');
        let inApp            = $('#in_app');
        let isInput          = $('#is_input');
        let inHomeApp        = $('#in_home_app');
        let nameFront        = $('#name_front');
        let elemCooking      = $('div.cooking_time');
        let elemInputCooking = $('#cooking_time');

        @if( !empty( $sku ) )
            $('#type').val('{{$product['type']}}').attr('data-value','{{$product['type']}}');
            name.val('{{$product['name'].(!$isDuplicate ? '' : ' - DUPLICADO')}}').attr('data-value','{{$product['name'].(!$isDuplicate ? '' : ' - DUPLICADO')}}');
            sku.val('{{$sku.(!$isDuplicate ? '' : '-duplicate')}}').attr('data-value','{{$sku.(!$isDuplicate ? '' : '-duplicate')}}');
            nameFront.val('{{$product['name_front']}}').attr('data-value','{{$product['name_front']}}');
            $('#sector_id').val('{{$product['sector_id']}}').attr('data-value','{{$product['sector_id']}}');
            $('#unit_id').val('{{$product['unit_id']}}').attr('data-value','{{$product['unit_id']}}');
            $('#unit_id_in').val('{{$product['unit_id_in']}}').attr('data-value','{{$product['unit_id_in']}}');
            $('#weight').val('{{$product['weight']}}').attr('data-value','{{$product['weight']}}');
            $('#bar_code').val('{{$product['bar_code']}}').attr('data-value','{{$product['bar_code']}}');
            $('#stock_min').val('{{array_get($product,'config.stock_min')}}').attr('data-value','{{array_get($product,'config.stock_min')}}');
            $('#stock_max').val('{{array_get($product,'config.stock_max')}}').attr('data-value','{{array_get($product,'config.stock_max')}}');
            $('#priority').val('{{array_get($product,'config.priority')}}').attr('data-value','{{array_get($product,'config.priority')}}');
            elemInputCooking.val('{{array_get($product,'config.cooking_time')}}').attr('data-value','{{array_get($product,'config.cooking_time')}}');
            $('#price').val('{{format_number( array_get( current( $product['prices']), 'price' ) , 2)}}').attr('data-value','{{format_number( array_get( current( $product['prices']), 'price' ) , 2)}}');
        @elseif( $action !== 'inputs' )
            $('#type').val('SIMPLES');
        @endif

        $('#code').attr('disabled',true);

        $( document ).ready(function() {

            let formData = $("#formProduct");

            @if( empty( $sku ) )
            name.off().on('keyup', function () {
                let scope = $(this);
                sku.val( scope.val().replace(/[^a-zA-Z0-9]/g,"-") );
                nameFront.val( scope.val() );
            });
            @endif

            $(".list-group-item").on('click', function(e, data) {
                document.location.href = $(this).attr('data-url');
            });

        @if( !empty( $sku ) )
            //VERIFICANDO A EXISTE ALTERAÇÕES NOS CAMPOS
            $('#formProduct input, #formProduct select, #formProduct textarea').change(function(){
                let change = 0;
                $('.verify-origin-value').each(
                    function(index){
                        let input = $(this);
                        let name  = input.attr('name');
                        if( name !== '_token' ) {
                            if( input.val() !== input.attr('data-value') ) {
                                change++;
                                //console.log('Name: ' + input.attr('name') + ' Value: ' + input.val() + ' ORIGIN: ' + input.attr('data-value'));
                            }
                        }
                    }
                );

                let iconSave = $('.icon-save');
                if( change > 0 ){
                    iconSave.attr('data-action','INPUT').fadeIn(500);
                } else if ( iconSave.attr('data-action') !== 'ICON') {
                    iconSave.attr('data-action','').hide();
                }
            });
            $(".list-group-item").on('click', function(e, data) {

                let scope = $(this);

                if($('.icon-save').is(':visible')){

                    helper.alertConfirmation( scope.attr('data-url') );

                } else{
                    document.location.href = scope.attr('data-url');
                }

            });
            @if( $isDuplicate  === FALSE )
            {!! js_code_product_page() !!}
            @endif

            $(".switchBootstrap").on('change.bootstrapSwitch', function(e, data) {
                $('#type').trigger('change');
                let stateValue = !$(this).bootstrapSwitch('state') ? 1 : 0;
                let elemIcon   = $('.icon-save');
                if( stateValue !== parseInt(e.currentTarget.dataset.value)){
                    elemIcon.attr('data-action','ICON').fadeIn(500);
                } else if ( elemIcon.attr('data-action') !== 'INPUT' ){
                    elemIcon.hide();
                }
            });

            @if( is_array( $product['tags'] ) )
                @foreach( $product['tags'] as $row )
                    $("#tags option[value='{{$row['id']}}']").prop("selected", true);
                @endforeach
            @endif
            @if( is_array( $product['providers'] ) )
                @foreach( $product['providers'] as $row )
                    $("#providers option[value='{{$row['id']}}']").prop("selected", true);
                @endforeach
            @endif
            @foreach( $product['categories'] as $cat )
                $("#categories option[value='{{ $cat['category_id'] }}']").prop("selected", true);
            @endforeach

        @endif

            inApp.bootstrapSwitch();
            status.bootstrapSwitch();
            inHomeApp.bootstrapSwitch();

            $("#tags, #categories, #providers").select2({
                placeholder: "Click para selecionar",
            });

            prodType.change(function(){
                let scope       = $(this);
                let onlySimples = $('.only-simples');
                if( scope.val() === 'ITEM' ){
                    $('#price, #name_front').rules('remove', 'required');
                    $('#priority').rules('add', 'required');
                    onlySimples.fadeOut(400);
                    $('.div_unit').removeClass('unit');
                    $('label.weight').html('Unidade*');
                } else if( scope.val() === 'SIMPLES' ){
                    $('#price, #name_front').rules('add', 'required');
                    $('#priority').rules('remove', 'required');
                    onlySimples.fadeIn(600);
                    $('.div_unit').addClass('unit');
                    $('label.weight').html('Peso* & Unidade*');
                }
            });

            formData.validate({
                rules: {
                    name: "required",
                    name_front: "required",
                    sku: "required",
                    weight: "required",
                    categories: "required",
                    sector_id: "required",
                    type: "required",
                    unit_id: "required",
                    unit_id_in: "required",
                    price: "required",
                    stock_min: "required",
                    priority: "required",
                },
                submitHandler: function(form) {
                    let elemetBtn = $('button[type="submit"]');
                    let textBtn   = elemetBtn.html();
                    elemetBtn.html( helper.htmlSpinner() ).attr('disabled',true);

                    if( $('input[name="manufacture"]:checked').val() !== 'PRÓPRIA' ){
                        elemInputCooking.val('');
                    }

                    let formSerialize = formData.serialize();
                    formSerialize    += '&status='+ ( status.bootstrapSwitch('state') ? 1 : 0 );
                    let stateIsInput  = 0;

                    @if( $action === 'inputs' )
                        formSerialize  += '&in_app=0';
                        formSerialize  += '&in_home_app=0';
                        stateIsInput    = 1;
                    @elseif( empty( $sku ) || $product['type'] === 'SIMPLES' )
                        formSerialize  += '&in_app='     + ( inApp.bootstrapSwitch('state')     ? 1 : 0 );
                        formSerialize  += '&in_home_app='+ ( inHomeApp.bootstrapSwitch('state') ? 1 : 0 );
                    @else
                        formSerialize  += '&in_app=0';
                        formSerialize  += '&in_home_app=0';
                    @endif

                    formSerialize += '&is_input='+stateIsInput;

                    //console.log( formSerialize );return false;

                    if( $('#categories').val().length > 0 ){
                        $.ajax({
                            method: 'POST',
                            url: "/api/{{empty($sku) || $isDuplicate ? 'post' : 'put'}}/product@"+formData.attr('data-sku'),
                            data: formSerialize,
                            success: function (data, jqXHR) {
                                if(data.messages === 'OK')
                                    helper.alertSucess('Ação efetuada com sucesso!');
                                else
                                    helper.alertError(data.messages);

                                document.location.href = '{{route('catalog.products.index_'.$action)}}';
                            },
                            error: function(data, jqXHR) {
                                helper.alertError(data.responseJSON.messages);
                                elemetBtn.html( textBtn ).attr('disabled',false);
                            }
                        });
                    } else {
                        helper.alertError('Escolha pelo menos uma categoria');
                        elemetBtn.html( textBtn ).attr('disabled',false);
                    }
                }
            });

            $.validator.messages.required = "Informação obrigatória";

            @if( $manufacture !== 'PRÓPRIA' )
                elemCooking.hide();
            @else
                elemInputCooking.rules('add', 'required');
            @endif

            $('input[name="manufacture"]').on('change', function(e, data) {
                let scope = $(this);
                if( scope.val() === 'PRÓPRIA' ){
                    elemCooking.fadeIn(600);
                    elemInputCooking.rules('add', 'required');
                } else {
                    elemCooking.fadeOut(400);
                    elemInputCooking.rules('remove', 'required');
                }
            });

            @if( !empty( $sku ) )
                $('#type').rules('remove', 'required');

                @if( $action === 'inputs' )
                    $('#weight').rules('remove', 'required');
                @else
                    $('#priority').rules('remove', 'required');
                @endif
            @endif

            @if( $action !== 'inputs' )
                prodType.val('SIMPLES').trigger('change');

                @if( empty( $isInput ) )
                    $('div.priority, div.priority2').hide();
                @endif

                $('#unit_id_in').rules('remove', 'required');

            @endif

            @if( $type === 'SIMPLES' )
                $('.no-simples').hide();
            @endif

            $('#price').maskMoney({thousands:'.', decimal:',', symbolStay: false});

        });

    </script>

@endsection
