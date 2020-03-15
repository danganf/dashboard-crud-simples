
@extends('layout')

@section('css')
    <style>
        input, select{text-transform: uppercase;}
    </style>
@endsection

@section('content')

@php
    $id = array_get( $data, 'id', '' );
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
                            <label class="col-md-3 label-control" for="name">Nome*</label>
                            <div class="col-md-9">
                                <input type="text" id="name" maxlength="80" class="form-control col-md-10" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="ip_port">IP & Porta*</label>
                            <div class="col-md-9">
                                <input type="text" id="ip_port" maxlength="40" class="form-control col-md-4" name="ip_port" placeholder="EX: 192.168.1.232:9100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="cardFilter" class="card-content">
                <div class="card-body text-right">
                    <button type="button" onclick="location.href='{{route('register.printer.index')}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                    <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')

    <script>
        $( document ).ready(function() {

            let formData         = $("form#formData");
            let id               = formData.attr('data-id');
            let methodUrl        = 'post';

            if( id !== '' ){methodUrl = 'put';}

            $('#name').val('{{array_get($data, 'name')}}').focus();
            $('#ip_port').val('{{array_get($data, 'ip_port')}}');

            formData.validate({
                rules: {
                    name: "required",
                    ip_port: "required",
                },
                submitHandler: function(form) {
                    let elemBtn  = $('button[type="submit"]');
                    let textHtml = elemBtn.html();

                    elemBtn.html( helper.htmlSpinner() ).attr('disabled',true);

                    $.ajax({
                        method: 'POST',
                        url: "/api/"+methodUrl+"/printer/"+id,
                        data: formData.serialize(),
                        success: function (data, jqXHR) {
                            if(data.messages === 'OK')
                                helper.alertSucess('Ação efetuada com sucesso!');
                            else
                                helper.alertError(data.messages);

                            document.location.href="{{route('register.printer.index')}}";
                        },
                        error: function(data, jqXHR) {
                            $('button[type="submit"]').html( textHtml ).attr('disabled', false);
                            helper.alertError(data.responseJSON.messages);
                        }
                    });
                }
            });

            $.validator.messages.required = "Informação obrigatória";

        });
    </script>

@endsection
