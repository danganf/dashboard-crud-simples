@extends('layout')

@section('content')

@php
    $id              = isset( $id )              ? $id              : '';
    $name            = isset( $name )            ? $name            : '';
    $role_id         = isset( $role_id )         ? $role_id         : '';
    $user            = isset( $user )            ? $user            : '';
    $password        = isset( $password )        ? $password        : '';
    $password_repeat = isset( $password_repeat ) ? $password_repeat : '';
    $status          = isset( $status )          ? $status          : '';
    $phone           = isset( $phone )           ? $phone           : '';
@endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formEmployee" data-id="{{$id}}" onsubmit="return false">
        <input type="hidden" name="change_store" id="change_store" value="0">
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
                                <input type="text" id="name" maxlength="100" class="form-control" placeholder="Nome completo" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="role_id">Cargo*</label>
                            <div class="col-md-9">
                                <select class="form-control col-md-5" id="role_id" name="role_id">
                                    <option value="">--selecione--</option>
                                    @foreach( $roles as $role )
                                        <option value="{{$role['id']}}">{{$role['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="user">
                                Usuário*<br>
                                <small>Para acessar o sistema</small>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="user" maxlength="100" class="form-control col-md-4" placeholder="Ex: fulano123#" name="user">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="status">
                                Status*<br/>
                                Mínimo 5 caracteres
                            </label>
                            <div class="col-md-9">
                                <input type="checkbox" class="switchBootstrap" id="status" name="status"
                                       data-on-text="ATIVO" data-off-text="INATIVO" data-size="small" data-on-color="success" data-off-color="danger" {{$status ? 'checked' : ''}}/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="password">Senha{{$action=='INSERT' ? '*' : ''}}</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Sua senha">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input type="password" name="password_repeat" id="password_repeat" class="form-control" placeholder="Confirme sua senha">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="user">Celular de contato</label>
                            <div class="col-md-9">
                                <input type="text" id="phone" maxlength="100" class="form-control col-md-3" placeholder="(99) 9999-9999" name="phone">
                            </div>
                        </div>
                    @if( !empty( $id ) && check_acl_user( 'apply_auth_token', TRUE ) )
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="user">Token</label>
                            <div class="col-md-9"><strong>{{$token}}</strong></div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div id="cardFilter" class="card-content">
                <div class="card-body text-right">
                    <div class="form-actions">
                    <button type="button" onclick="location.href='{{route('register.employee.index')}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('js')

    <script>
        let status      = $('#status');
        let phone       = $('#phone');
        let formData    = $("form#formEmployee");
        let methodUrl   = 'post';

        $('#name').val('{{$name}}').focus();
        $('#role_id').val('{{$role_id}}');
        $('#user').val('{{$user}}');
        phone.val('{{$phone}}').inputmask({"mask": "(99) 99999-9999", clearIncomplete: true, showMaskOnHover: false});

        status.val('{{$status === false ? '0' : '1'}}');
        status.bootstrapSwitch();

        /*phone.formatter({
            'pattern': "(@{{99}}) @{{9999}}-@{{9999}}",
            'persistent': true
        }).resetPattern();*/

        let fieldRules = {
            name: "required",
            user: "required",
            change_store: "required",
            role_id: "required",
        };

        @if( $action == 'INSERT')
            fieldRules.password        = "required";
            fieldRules.password_repeat = "required";
        @else
            methodUrl = 'put';
        @endif

        formData.validate({
            rules: fieldRules,
            submitHandler: function(form) {
                let elementButton = $('button[type="submit"]');
                let textButton    = elementButton.html();
                elementButton.html( helper.htmlSpinner() ).attr('disabled',true);

                let formSerialize = formData.serialize();
                formSerialize     += '&status='+ ( status.bootstrapSwitch('state') ? 1 : 0 );

                $.ajax({
                    method: 'POST',
                    url: "/api/"+methodUrl+"/employee/"+formData.attr('data-id'),
                    data: formSerialize,
                    success: function (data, jqXHR) {
                        if(data.messages === 'OK') {
                            helper.alertSucess('Ação efetuada com sucesso!');
                            document.location.href = "{{route('register.employee.index')}}";
                        }
                        else
                            helper.alertError(data.messages);

                        elementButton.html( textButton ).attr('disabled',false);
                    },
                    error: function(data, jqXHR) {
                        helper.alertError(data.responseJSON.messages);
                        elementButton.html( textButton ).attr('disabled',false);
                    }
                });
            }
        });
        $.validator.messages.required = "Informação obrigatória";
    </script>

@endsection
