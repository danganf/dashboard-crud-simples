
@extends('layout')

@section('css')
    <style>
        .bg-section{}
        .bg-section td{padding: 10px 0 10px 0 !important;background-color: #F4F5FA;font-weight: 600;}
        .table.table-xl th, .table.table-xl td{padding: 0.8rem 0 !important;}
    </style>
@endsection
@section('content')

@php
    $id              = isset( $id )      ? $id      : '';
    $name            = isset( $name )    ? $name    : '';
    $profile         = isset( $profile ) ? $profile : [];
    $aclOptionsLabel = array_get( $acls, 'options_label', [] );
@endphp

    <form class="form form-horizontal striped-labels form-bordered" id="formReg" data-id="{{$id}}" onsubmit="return false">
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
                                <input type="text" id="name" maxlength="80" class="form-control col-md-12 col-xl-7" placeholder="Nome do cargo" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 label-control" for="name">Perfil de acesso</label>
                            <div class="col-md-9">
                                @define $ant = '';
                                <div class="table-responsive">
                                    <table class="table table-hover table-xl mb-0">
                                    @define $cont=0;
                                    @foreach( $acls['data'] as $key=>$acl )
                                    @if(  $ant != $acl['section'] )

                                        <tr class="bg-section">
                                            <td colspan="2">
                                                <i class="la la-angle-double-right"></i> Sessão {{$acl['section']}}
                                            </td>
                                        </tr>

                                    @endif
                                        <tr>
                                            <td class="text-truncate text-right" style="line-height: 32px;width: 20%">{{$acl['name']}}&nbsp;&nbsp;&nbsp;</td>
                                            <td class="text-truncate">

                                            @foreach( explode( ',', $acl['options'] ) as $key2 => $opt )
                                                @if( array_key_exists( $opt, $aclOptionsLabel ) )
                                                    @php
                                                        $sectionName = str_replace(' ','-', $acl['name']);
                                                    @endphp

                                                    @if( $key2 === 0 )
                                                        <label for="{!! $sectionName.'-'.$key2 !!}">NÃO</label>
                                                            <input type="radio" value="NO" checked name="acl-resource-{{$acl['id']}}" id="{!! $sectionName.'-'.$key2 !!}" class="jui-radio-buttons">
                                                    @endif

                                                    <label for="{!! $sectionName.'-'.++$key2 !!}">{!! strtoupper( array_get( $aclOptionsLabel, $opt.'.label' ) ) !!}</label>
                                                    <input type="radio" value="{{$opt}}" name="acl-resource-{{$acl['id']}}" id="{!! $sectionName.'-'.$key2 !!}" class="jui-radio-buttons">
                                                @endif
                                            @endforeach

                                            </td>
                                        </tr>

                                    @php $ant = $acl['section'] @endphp

                                @endforeach
                                    </table>
                                </div>
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
                    <button type="button" onclick="location.href='{{route('register.role.index')}}'" class="btn btn-warning btn-click mr-1"><i class="la la-backward"></i> Voltar</button>
                        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')

    <script>
        let name         = $('#name');
        let formData     = $("form#formReg");
        let id           = formData.attr('data-id');
        let methodUrl    = 'post';
        let aclResources = [{!! implode(',', pluckMatriz( $acls['data'], 'id' ) ) !!}];

        if( id !== '' ){
            methodUrl = 'put';
        }
        name.val('{{$name}}').focus();

        @foreach( $profile as $row )
            $("input[name='acl-resource-{{$row['acl_id']}}'][value='{{$row['action']}}']").prop("checked", true);
        @endforeach

        formData.validate({
            rules: {
                name: "required",
            },
            // Specify validation error messages
            messages: {
                name: "Informação obrigatória",
            },
            submitHandler: function(form) {

                let dataSend = { name: $("input[name='name']").val(), acls: [] };

                $.each( aclResources, function (index, value ) {
                    let action = $("input[name='acl-resource-"+value+"']:checked").val();
                    if( action !== 'NO' ){
                        dataSend.acls.push( { id: value, action: action } );
                    }
                } );

                let buttonElement = $('button[type="submit"]');
                let txtHtml       =buttonElement.html();
                buttonElement.html( helper.htmlSpinner() ).attr('disabled',true);
                $.ajax({
                    method: 'POST',
                    url: "/api/"+methodUrl+"/role/"+id,
                    data: dataSend,
                    success: function (data, jqXHR) {
                        if(data.messages === 'OK')
                            helper.alertSucess('Ação efetuada com sucesso!');
                        else
                            helper.alertError(data.messages);

                        document.location.href="{{route('register.role.index')}}";
                    },
                    error: function(data, jqXHR) {
                        helper.alertError(data.responseJSON.messages);
                        buttonElement.html( txtHtml ).attr('disabled',false);
                    }
                });
            }
        });
    </script>

@endsection
