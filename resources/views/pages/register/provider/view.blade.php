
@extends('layout')

@section('css')
    <style>
        input, select{text-transform: uppercase;}
    </style>
@endsection

@section('content')

@php
    $id           = array_get( $data, 'id'          , '' );
    $type         = array_get( $data, 'type'        , 'PJ' );
    $status       = array_get( $data, 'status'      , '' );
    $accept_order = array_get( $data, 'accept_order', '' );
    $proviTags    = array_get( $data, 'tags'        , [] );
@endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formData" data-id="{{$id}}" onsubmit="return false">
        <div class="card">
            <div class="card-header reload-card">
                <div class="heading-elements">
                    <a data-action="collapse"><i id="icon-filter" class="ft-minus"></i></a>
                    <a data-action="expand"><i class="ft-maximize"></i></a>
                </div>
            </div>
            <div id="cardFilter" class="card-content collapse show">
                <div class="card-body">

                    <div class="form-body">
                        <h4></h4>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="type">Tipo*</label>
                            <div class="col-md-9">
                                <input type="checkbox" class="switchBootstrap" id="type" data-value="{{$type}}"
                                       data-on-text="PJ" data-off-text="PF" data-size="small" data-on-color="success" data-off-color="danger" {{$type === 'PJ' ? 'checked' : ''}}/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="initials">Sigla*</label>
                            <div class="col-md-9">
                                <input type="text" id="initials" maxlength="40" class="form-control col-md-7" name="initials">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="name">Nome*</label>
                            <div class="col-md-9">
                                <input type="text" id="name" maxlength="80" class="form-control col-md-12" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="document">Documento</label>
                            <div class="col-md-9">
                                <input type="text" id="document" maxlength="40" class="form-control col-md-4" name="document">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="tags">Tags</label>
                            <div class="col-md-9">
                                <select class="form-control verify-origin-value col-md-12" id="tags" multiple="multiple" data-value="" name="tags[]">
                                    @foreach( $tags AS $row )
                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="address">Endereço*</label>
                            <div class="col-md-9">
                                <input type="text" id="address" maxlength="80" class="form-control col-md-12" name="address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="phone">Telefone</label>
                            <div class="col-md-9">
                                <input type="text" id="phone" maxlength="40" class="form-control col-md-4" name="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="contact">Contato</label>
                            <div class="col-md-9">
                                <input type="text" id="contact" maxlength="80" class="form-control col-md-5" name="contact">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="email">E-mail</label>
                            <div class="col-md-9">
                                <input type="text" id="email" maxlength="150" class="form-control col-md-7" name="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="website">Website</label>
                            <div class="col-md-9">
                                <input type="text" id="website" maxlength="150" class="form-control col-md-7" name="website" placeholder="EX: www.site.com.br">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="status">Status*</label>
                            <div class="col-md-9">
                                <input type="checkbox" class="switchBootstrap" id="status" data-value="{{$status}}"
                                       data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" {{$status ? 'checked' : ''}}/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="accept_order">Aceita encomenda*</label>
                            <div class="col-md-9">
                                <input type="checkbox" class="switchBootstrap" id="accept_order" data-value="{{$accept_order}}"
                                       data-on-text="Sim" data-off-text="Não" data-size="small" data-on-color="success" data-off-color="danger" {{$accept_order ? 'checked' : ''}}/>
                            </div>
                        </div>
                        <div class="form-group accept-order row">
                            <label class="col-md-3 label-control" for="minimum_order_value">Valor mínimo*</label>
                            <div class="col-md-9">
                                <input type="text" id="minimum_order_value" maxlength="40" class="form-control col-md-4" name="minimum_order_value">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="cardFilter" class="card-content">
                <div class="card-body text-right">
                    <button type="button" onclick="location.href='{{route('register.provider.index')}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                    <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')

    <script>
        $( document ).ready(function() {

            let type             = $('#type');
            let documente        = $('#document');
            let phone            = $('#phone');
            let status           = $('#status');
            let acceptOrder      = $('#accept_order');
            let minOrderValue    = $('#minimum_order_value');
            let contact           = $('#contact');
            let email            = $('#email');
            let elemAcceptOrder  = $('.accept-order');
            let formData         = $("form#formData");
            let id               = formData.attr('data-id');
            let methodUrl        = 'post';
            let patternPF        = "@{{999}}.@{{999}}.@{{999}}-@{{99}}";
            let patternPJ        = "@{{99}}.@{{999}}.@{{999}}/@{{9999}}-@{{99}}";
            let patternPhone     = "(@{{99}}) @{{999999999}}";

            if( id !== '' ){methodUrl = 'put';}

            $(".switchBootstrap").on('change.bootstrapSwitch', function(e, data) {

                let elem       = $( e.currentTarget );
                let stateValue = !$(this).bootstrapSwitch('state') ? 1 : 0;
                if( elem.attr('id') === 'type' ){

                    if( stateValue === 1 ){ documente.formatter().resetPattern(patternPJ);}
                    else {documente.formatter().resetPattern(patternPF);}

                    @if( empty( $id ) )
                        documente.val('');
                    @else
                        documente.focus();
                    @endif

                } else if( elem.attr('id') === 'accept_order' ){
                    if( stateValue === 1 ){
                        elemAcceptOrder.fadeIn(500);
                        minOrderValue.rules('add', 'required');
                        phone.focus();
                    } else {
                        elemAcceptOrder.fadeOut(400);
                        minOrderValue.val('').rules('remove', 'required');
                    }
                }

            });

            @if( is_array( $proviTags ) )
                @foreach( $proviTags as $row )
                    $("#tags option[value='{{$row['id']}}']").prop("selected", true);
                @endforeach
            @endif

            $("#tags").select2({
                placeholder: "Click para selecionar",
            });

            $('#initials').val('{{array_get($data, 'initials')}}').focus();
            $('#name').val('{{array_get($data, 'name')}}');
            $('#address').val('{{array_get($data, 'address')}}');
            $('#website').val('{{array_get($data, 'website')}}');
            phone.val('{{array_get($data, 'phone')}}');
            contact.val('{{array_get($data, 'contact')}}');
            email.val('{{array_get($data, 'email')}}');

            minOrderValue.val('{{ format_number( array_get($data, 'minimum_order_value'), 2 )  }}');
            minOrderValue.maskMoney({thousands:'.', decimal:',', symbolStay: false});

            status.bootstrapSwitch();
            acceptOrder.bootstrapSwitch();
            type.bootstrapSwitch();

            @if(  array_get($data, 'accept_order') !== true )
            elemAcceptOrder.hide();
            @endif

            documente.formatter({pattern: patternPJ});
            phone.formatter({pattern: patternPhone});

            @if( !empty( $id ) )
                documente.val('{{array_get($data, 'document')}}');
                documente.formatter().resetPattern( {{ $type === 'PJ' ? 'patternPJ' : 'patternPF' }} );

                phone.val('{{array_get($data, 'phone')}}');
                phone.formatter().resetPattern(patternPhone);
            @endif

            formData.validate({
                rules: {
                    initials: "required",
                    name: "required",
                    address: "required",
                },
                submitHandler: function(form) {
                    let elemBtn  = $('button[type="submit"]');
                    let textHtml = elemBtn.html();
                    let flag     = true;
                    let msgErro  = null;

                    if( acceptOrder.bootstrapSwitch('state') && ( minOrderValue.val() === '' || minOrderValue.val() === '0,00' ) ){
                        flag = false;
                        msgErro = 'Valor minimo deve ser preenchido';
                    }

                    if( flag ){

                        elemBtn.html( helper.htmlSpinner() ).attr('disabled',true);

                        let formSerialize = formData.serialize();
                        formSerialize    += '&type='+ ( type.bootstrapSwitch('state') ? 'PJ' : 'PF' );
                        formSerialize    += '&status='+ ( status.bootstrapSwitch('state') ? 1 : 0 );
                        formSerialize    += '&accept_order='+ ( acceptOrder.bootstrapSwitch('state') ? 1 : 0 );

                        $.ajax({
                            method: 'POST',
                            url: "/api/"+methodUrl+"/provider/"+id,
                            data: formSerialize,
                            success: function (data, jqXHR) {
                                if(data.messages === 'OK')
                                    helper.alertSucess('Ação efetuada com sucesso!');
                                else
                                    helper.alertError(data.messages);

                                document.location.href="{{route('register.provider.index')}}";
                            },
                            error: function(data, jqXHR) {
                                $('button[type="submit"]').html( textHtml ).attr('disabled', false);
                                helper.alertError(data.responseJSON.messages);
                            }
                        });

                    } else {
                        helper.alertError(msgErro, 'Atenção!', minOrderValue);
                    }
                }
            });

            $.validator.messages.required = "Informação obrigatória";

            @if( array_get($data, 'accept_order') === true )
                minOrderValue.rules('add', 'required');
            @endif

        });
    </script>

@endsection
