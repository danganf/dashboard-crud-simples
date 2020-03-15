@extends('layout')

@section('content')

@php
    $id        = isset( $id )         ? $id         : '';
    $name      = isset( $name )       ? $name       : '';
    $status    = isset( $status )     ? $status     : '0';
    $printerID = isset( $printer_id ) ? $printer_id : '';
@endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formSector" data-id="{{$id}}" onsubmit="return false">
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
                                <input type="text" id="name" maxlength="100" class="form-control col-md-5" placeholder="Nome do setor" name="name">
                            </div>
                        </div>
                    @if( !$isInput )
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="printer_id">Impressora</label>
                            <div class="col-md-9">
                                <select class="form-control col-md-5" id="printer_id" name="printer_id">
                                    <option value=""></option>
                                @foreach( $printers as $print )
                                    <option value="{{$print['id']}}" @if( $printerID == $print['id'] ) selected @endif>{{$print['name']}}</option>
                                @endforeach
                                </select>
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

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="cardFilter" class="card-content">
                <div class="card-body text-right">
                    <div class="form-actions">
                    <button type="button" onclick="location.href='{{route('register.sector.index'.$routeSufix)}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('js')

    <script>
        let name      = $('#name');
        let status    = $('#status');
        let formData  = $("form#formSector");
        let id        = formData.attr('data-id');
        let methodUrl = 'post';

        if( id !== '' ){
            methodUrl = 'put';
        }
        name.val('{{$name}}').focus();
        status.val('{{$status === false ? '0' : '1'}}');

        formData.validate({
            rules: {
                name: "required"
            },
            // Specify validation error messages
            messages: {
                name: "Informação obrigatória",
            },
            submitHandler: function(form) {
                $('button[type="submit"]').html( helper.htmlSpinner() ).attr('disabled',true);

                let formSerialize = formData.serialize();
                formSerialize    += '&status='+ ( status.bootstrapSwitch('state') ? 1 : 0 );
                formSerialize    += '&is_input={!! $isInput ? 1 : 0 !!}';

                $.ajax({
                    method: 'POST',
                    url: "/api/"+methodUrl+"/sector/"+id,
                    data: formSerialize,
                    success: function (data, jqXHR) {
                        if(data.messages === 'OK')
                            helper.alertSucess('Ação efetuada com sucesso!');
                        else
                            helper.alertError(data.messages);

                        document.location.href="{{route('register.sector.index'.$routeSufix)}}";
                    },
                    error: function(data, jqXHR) {
                        console.log(data);
                        helper.alertError('Ocorreu um erro!')
                    }
                });
            }
        });

        status.bootstrapSwitch();

    </script>

@endsection
