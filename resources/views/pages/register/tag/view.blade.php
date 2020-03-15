
@extends('layout')

@section('content')

@php
    $id   = isset( $id )   ? $id   : '';
    $name = isset( $name ) ? $name : '';
@endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formTag" data-id="{{$id}}" onsubmit="return false">
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
                                <input type="text" id="name" maxlength="80" class="form-control col-md-7" placeholder="Nome da tag" name="name">
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
                    <button type="button" onclick="location.href='{{route('register.tag.index'.$routeSufix)}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
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
        let formData  = $("form#formTag");
        let id        = formData.attr('data-id');
        let methodUrl = 'post';

        if( id !== '' ){
            methodUrl = 'put';
        }
        name.val('{{$name}}').focus();

        formData.validate({
            rules: {
                name: "required",
            },
            // Specify validation error messages
            messages: {
                name: "Informação obrigatória",
            },
            submitHandler: function(form) {
                $('button[type="submit"]').html( helper.htmlSpinner() ).attr('disabled',true);

                let formSerialize = formData.serialize();
                formSerialize    += '&is_input={!! $isInput ? 1 : 0 !!}';

                $.ajax({
                    method: 'POST',
                    url: "/api/"+methodUrl+"/tag/"+id,
                    data: formSerialize,
                    success: function (data, jqXHR) {
                        if(data.messages === 'OK')
                            helper.alertSucess('Ação efetuada com sucesso!');
                        else
                            helper.alertError(data.messages);

                        document.location.href="{{route('register.tag.index'.$routeSufix)}}";
                    },
                    error: function(data, jqXHR) {
                        console.log(data);
                        helper.alertError('Ocorreu um erro!')
                    }
                });
            }
        });

    </script>

@endsection
