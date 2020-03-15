@extends('layout')

@section('content')
    @php
        $class1 = 'col-md-8 col-lg-7 col-xl-4';
        $class2 = 'col-md-4 col-lg-5 col-xl-3';
        if( $action == 'in' ){
            $class1 = 'col-md-5 col-lg-5 col-xl-4';
            $class2 = 'col-md-3 col-lg-4 col-xl-3';
        }
    @endphp
    <form class="form form-horizontal striped-labels form-bordered" id="formStock" onsubmit="return false">
        <div class="card">
            <div class="card-content">
                <div class="card-body text-right pb-0">
                    <span class="badge hide badge-info info-success"></span>
                    <button type="submit" class="btn btn-register {{ $action == 'in' ? 'btn-success' : 'btn-warning'  }} mb-2"><i class="la la-save"></i> Registrar {{ $action == 'in' ? 'Entrada' : 'Descarte'  }}</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">
                    <div>
                        <div class="contact-repeater" data-limit="13">
                            <div>
                                <table class="table table-hover table-de mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0">
                                            Produto / Qtd
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody data-repeater-list="items">
                                    <tr data-repeater-item>
                                        <td style="padding-bottom: 0;padding-top: 25px">
                                            <div class="row mb-1">
                                                <div class="{{$class1}}">
                                                    <div class="select2-group border-0">
                                                        <select class="select2 form-control product" name="product[]">
                                                            <option value="">--Selecione--</option>
                                                            @foreach($products as $product)
                                                                <option data-config-name="{{array_get($product, 'unit.name')}}" data-prod-name="{{$product['name']}}"
                                                                        data-stock="{{array_get($product, 'qty_ready')}}"
                                                                        value="{{$product['id']}}">{{'#'.$product['id'].' - '.$product['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="{{$class2}}">
                                                    <div class="input-group border-0">
                                                        <span class="text-unit"></span>
                                                        <input type="number" name="qtd[]" maxlength="60" placeholder="Ex: 2" class="qtd form-control">
                                                        <span class="input-group-append">
                                                                  <button class="btn btn-repeater btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td style="border: 0">
                                            <button type="button" data-count="1" class="add-item btn btn-primary btn-sm pull-right"><i class="ft-plus"></i>5 novos itens</button>
                                            <a data-repeater-create class="real-add-item"></a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="card-body text-right pb-0">
                    <span class="badge hide badge-info info-success"></span>
                    <button type="submit" class="btn btn-register {{ $action == 'in' ? 'btn-success' : 'btn-warning'  }} mb-2"><i class="la la-save"></i> Registrar {{ $action == 'in' ? 'Entrada' : 'Descarte'  }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <style>
        .select2-container--default .select2-results > .select2-results__options {
            max-height: 400px;
            min-height: 400px;
            overflow-y: auto;
        }
        @media only screen and (min-width: 320px) {
            .text-unit{margin-top: -103px;}
        }
        @media only screen and (min-width: 768px) {
            .text-unit{margin-top: -23px;}
        }
        @media only screen and (min-width: 768px) {
            .swal-modal{
                width: 80%;
            }
        }
        @media only screen and (min-width: 1440px) {
            .swal-modal{
                width: 40%;
            }
        }
        @media only screen and (min-width: 1920px) {
            .swal-modal{
                width: 30%;
            }
        }
    </style>
@endsection
@section('js')

    <script>

        $(document).ready(function() {

            $('.contact-repeater').repeater({
                show: function () {

                    let limitcount = $(this).parents(".contact-repeater").data("limit");
                    let itemcount  = $('select.select2:visible').length;
                    itemcount--;
                    itemcount--;

                    if (limitcount) {
                        if (itemcount <= limitcount) {
                            $(this).fadeIn(800);
                            bindSelect2();
                        } else {
                            $(this).remove();
                            $(".add-item").attr('disabled',true);
                        }
                    } else {
                        $(this).fadeIn(800);
                        bindSelect2();
                    }

                    if (itemcount >= limitcount) {
                        $(".contact-repeater input[data-repeater-create]").hide("slow");
                    }


                },
                hide: function(remove) {

                    let limitcount = $(this).parents(".contact-repeater").data("limit");
                    let itemcount  = $('select.select2:visible').length;

                    if (confirm('Deseja realmente excluir essa linha?')) {
                        $(this).fadeOut(600);
                        $(".add-item").attr('disabled',false);
                    }

                    if (itemcount <= limitcount) {
                        $(".contact-repeater input[data-repeater-create]").show("slow");
                    }

                },
                isFirstItemUndeletable: true
            });

            let elemAddItem = $('.real-add-item');

            $(".add-item").off().on('click', function () {
                for( i=0; i<5; i++ )
                    elemAddItem.trigger('click');
            });

            for( i=0; i<4; i++ )
                elemAddItem.trigger('click');

            function bindSelect2() {
                bindSelectProduct();
                $(".select2").select2({width: '100%'});
            }

            $(window).on('resize', function() {
                $('.select2-group').each(function() {
                    let formGroup = $(this),
                        formgroupWidth = formGroup.outerWidth();
                    formGroup.find('.select2-container').css('width', formgroupWidth);

                });
            });

            $(".btn-register").on('click', function(e) {

                let elementBtnRepeater = $("btn-repeater");
                let elementProducts    = $("select.product");
                let btnScope           = $(".btn-register");
                let btnTextHtml        = btnScope.html();
                let totalElement       = 0;
                let totalEmpty         = totalElement;
                let dataSend           = {items : []};
                let action             = '{{$action}}';
                let textProdSel        = "<p align=\"center\" style=\"font-weight: bold;font-size: 1.5rem\">Tem certeza que deseja {!! $action == 'in' ? '<i>REGISTRAR A ENTRADA</i> desses produtos no' : '<i>DESCARTAR</i> esses produtos do'!!} estoque ?</p>";

                textProdSel += '<ul class="list-group" style="overflow: auto; height: 200px;">';
                elementProducts.each(function(index, val){

                    let inputQtd  = $(this).closest('#formStock').find('input.qtd').eq(index);
                    let productID = $(val).val();

                    if( typeof inputQtd !== 'undefined' && $.trim( inputQtd.val() ) !== "" && $.trim( productID ) !== "" ){
                        textProdSel += '<li class="list-group-item" style="padding:4px"><small><i class="la la-caret-right"></i> ' + $(val).children("option:selected").attr('data-prod-name') + ', QTD: <b>' + inputQtd.val() + '</b></small></li>';
                        totalElement++;
                    }

                });

                textProdSel += '</ul>';

                if( totalElement > 0 ){
                    swal({
                        confirmButtonText: "CONTINUAR",
                        cancelButtonText: "CANCELAR",
                        showCancelButton: true,
                        html: textProdSel,
                    })
                        .then((dismiss) => {
                            if (dismiss.value) {

                                elementBtnRepeater.attr( 'disabled', true );
                                btnScope.attr( 'disabled', true ).html( helper.htmlSpinner() );

                                elementProducts.each(function(index, val){

                                    totalElement++;
                                    let selectProduct = $(val);
                                    let inputQtd      = $(this).closest('#formStock').find('input.qtd').eq(index);
                                    let productID     = $(val).val();
                                    let productQtd    = inputQtd.val();

                                    if( typeof inputQtd !== 'undefined' && $.trim( productID ) !== "" && $.trim( productQtd ) !== "" ){
                                        dataSend.items.push({'product_id': productID, 'qty': productQtd });
                                    } else {
                                        totalEmpty++;
                                        selectProduct.attr( 'disabled', true );
                                        inputQtd.attr( 'disabled', true );
                                    }
                                });

                                if( totalElement === totalEmpty ){
                                    resetFields(elementProducts,btnScope,elementBtnRepeater,btnTextHtml);
                                } else {
                                    //console.log( dataSend );return false;
                                    $.ajax({
                                        type: 'POST',
                                        timeout: 10000,
                                        url:  '/api/post/product/stock@' + action,
                                        data: dataSend,
                                        success: function (data, jqXHR) {
                                            helper.alertSucess();
                                            location.reload();
                                        },
                                        error: function(data, jqXHR) {
                                            resetFields(elementProducts,btnScope,elementBtnRepeater,btnTextHtml, data.responseJSON.messages);
                                        }
                                    });
                                }
                            }
                        });

                } else {
                    helper.alertError('Nenhum produto selecionado!');
                }

            });

            function resetFields(elementProducts,btnScope,elementBtnRepeater,btnTextHtml,msgErro){

                if (typeof msgErro === "undefined")   {msgErro = 'Nenhum elemento selecionado';}

                elementProducts.each(function(index, val){
                    $(val).attr( 'disabled', false );
                    $(this).closest('#formStock').find('input').eq(index).attr( 'disabled', false );
                });
                btnScope.attr( 'disabled', false ).html( btnTextHtml );
                elementBtnRepeater.attr( 'disabled', false );
                helper.alertError(msgErro);
            }

            function bindSelectProduct(){
                $("select.product").off().on('change', function(e) {

                    let optSelected      = $(this).find('option:selected');
                    let elementText      = $(this).parent('div').parent('div').parent('div').closest('div').find('.text-unit');
                    let currentStock     = optSelected.attr('data-stock');
                    let textHtml         = '';
                    /*if( typeof currentStock !== 'undefined' && currentStock !== ''){
                        textHtml += '<small class="badge border-left-danger badge-striped" style="margin-left: 5px">Estoque: <strong>'+currentStock+'</strong></small>';
                    }*/

                    if( textHtml !== '' ){
                        elementText.hide().html(textHtml).fadeIn(600);
                    } else {
                        elementText.html('').fadeOut(600);
                    }
                });
            }

            bindSelect2();
        });

    </script>
@endsection
