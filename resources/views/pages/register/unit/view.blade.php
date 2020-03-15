
@extends('layout')

@section('content')

    @php
        $id          = isset( $id )          ? $id          : '';
        $name        = isset( $name )        ? $name        : '';
        $initials    = isset( $initials )    ? $initials    : '';
        $description = isset( $description ) ? $description : '';
        $status      = isset( $status )      ? $status      : '';
        $volume      = isset( $volume )      ? $volume      : '';
        $volume_type = isset( $volume_type ) ? $volume_type : '';
    @endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formUnit" data-id="{{$id}}" onsubmit="return false">
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
                            <label class="col-md-3 label-control" for="name">Nome*</label>
                            <div class="col-md-9">
                                <input type="text" id="name" maxlength="60" class="form-control col-md-12" placeholder="Nome da unidade" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control weight" for="weight">Volume* & unidade*</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 col-lg-5 col-xl-3">
                                        <input type="text" id="volume" class="form-control verify-origin-value col-md-10 col-lg-10 col-xl-9" placeholder="EX: 120,876" name="volume" data-value="1" value="1">
                                    </div>
                                    <div class="col-md-6 col-lg-7 div_unit unit">
                                        <select class="form-control verify-origin-value col-md-6 col-lg-4 col-xl-2" id="volume_type" data-value="" name="volume_type">
                                            <option value="">--</option>
                                            <option value="UNIDADE" data-value="un">UNIDADE</option>
                                            <option value="KG" data-value="kg">KG</option>
                                            <option value="LITRO" data-value="l">LITRO</option>
                                            <option value="GRAMA" data-value="g">GRAMA</option>
                                            <option value="LITRO" data-value="l">LIVRO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="initials">Sigla*</label>
                            <div class="col-md-9">
                                <input type="text" id="initials" maxlength="10" class="form-control col-md-3" placeholder="Sigla" name="initials">
                            </div>
                        </div>
                        {{--<div class="form-group row">
                            <label class="col-md-3 label-control" for="description">Descrição</label>
                            <div class="col-md-9">
                                <textarea type="text" id="description" maxlength="120" rows="4" class="form-control col-md-12" placeholder="Descrição da unidade" name="description"></textarea>
                            </div>
                        </div>--}}
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="status">Status*</label>
                            <div class="col-md-9">
                                <select class="form-control col-md-5" id="status" name="status">
                                    <option value="">--</option>
                                    <option value="1">Liberado</option>
                                    <option value="0">Bloqueado</option>
                                </select>
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
                        <button type="button" onclick="location.href='{{route('register.unit.index')}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js" type="text/javascript"></script>
    <script>

        function isInternetExplorer(){
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
                return true;
            else  // If another browser, return 0
                return false;
        };

        function processInitials( elemName, elemVolume, elemVolumeType, elemInitials ){
            let nameVal       = $.trim( elemName.val() );
            let volumeVal     = $.trim( elemVolume.val() );
            let volumeValType = $.trim( elemVolumeType.val() );

            if( nameVal !== '' && volumeVal !== '' && volumeValType !== '' ){
                volumeVal  = helper.formatInputValToFloat( volumeVal );
                volumeVal *= 1;
                elemInitials.val( nameVal.split(" ")[0].replace(/[aeiouà-ú]/gi, '') + '/' + volumeVal.toString().replace('.',',') + $('#volume_type option:selected').data('value') );
            }

        }

        $(document).ready(function(){

            let name        = $('#name');
            let initials    = $('#initials');
            let description = $('#description');
            let status      = $('#status');
            let volume      = $('#volume');
            let volumeType  = $('#volume_type');
            let formData    = $("form#formUnit");
            let id          = formData.attr('data-id');
            let methodUrl   = 'post';

            //str = str.replace(/abc/g, '');

            if( id !== '' ){methodUrl = 'put';}

            name.val('{{$name}}').focus();
            initials.val('{{$initials}}');
            /*description.val('{{$description}}');*/
            status.val('{{$status === false ? '0' : '1'}}');
            @if( !empty( $volume ) )
            volume.val('{{format_number( $volume, 3 )}}');
            @endif
            $('#volume_type').val('{{$volume_type}}');

            volume.maskMoney({thousands:'.', decimal:',', symbolStay: false, precision: 3})
                .on( 'keyup', function () {
                    processInitials( name, volume, volumeType, initials );
            });

            volumeType.on( 'change', function () {
                processInitials( name, volume, volumeType, initials );
            } );

            name.on( 'change', function () {
                processInitials( name, volume, volumeType, initials );
            } );

            formData.validate({
                rules: {
                    name: "required",
                    initials: "required",
                    status: "required",
                    volume: "required",
                    volume_type: "required",
                },
                // Specify validation error messages
                messages: {
                    name: "Informação obrigatória",
                    initials: "Informação obrigatória",
                    status: "Informação obrigatória",
                    volume: "Informação obrigatória",
                    volume_type: "Informação obrigatória",
                },
                submitHandler: function(form) {
                    $('button[type="submit"]').html( helper.htmlSpinner() ).attr('disabled',true);
                    $.ajax({
                        method: 'POST',
                        url: "/api/"+methodUrl+"/unit/"+id,
                        data: formData.serialize(),
                        success: function (data, jqXHR) {
                            helper.alertSucess('Ação efetuada com sucesso!');
                            document.location.href="{{route('register.unit.index')}}";
                        },
                        error: function(data, jqXHR) {
                            console.log(data);
                            helper.alertError('Ocorreu um erro!')
                        }
                    });
                }
            });

        });

    </script>

@endsection
