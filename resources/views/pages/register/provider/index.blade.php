@extends('layout')

@section('css')
    <style>
        p.contacts{
            margin: 0;
            line-height: 16px;
        }
        .attributes .tags{margin: -2px 0 0 60px}
    </style>
@endsection
@section('content')

<div class="row">
    @include($basicPath.'.sections.filter')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header reload-card" id="last-orders">
                <h4 class="card-title"></h4>
                <div class="heading-elements">
                    <button onclick="location.href='{{route('register.provider.new')}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
                    <span class="dropdown"></span>
                </div>
            </div>
            <div class="card-content collapse show">
                <div id="last-orders" class="media-list position-relative">
                    <div class="table-responsive">
                        <table class="table table-hover table-xl mb-0">
                            <thead>
                            <tr>
                                <th class="border-top-0" style="width: 5%">#</th>
                                <th class="border-top-0">Sigla</th>
                                <th class="border-top-0">Nome</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Encomenda</th>
                                <th class="border-top-0">Contatos</th>
                                <th class="border-top-0">Tags</th>
                                <th class="border-top-0 text-right">Ação</th>
                            </tr>
                            </thead>
                            <tbody class="value-last-orders">
                                @foreach( $datas AS $data )
                                    @php
                                        $proviTags = '--';
                                        if( is_array( $data['tags'] ) ){
                                            $proviTags = implode(', ', pluckMatriz($data['tags'], 'name'));
                                        }
                                    @endphp
                                <tr>
                                    <td class="text-truncate">{{$data['id']}}</td>
                                    <td class="text-truncate">
                                        <a href="{{route('register.provider.edit',[$data['id']])}}">
                                            {{$data['initials']}}
                                        </a>
                                    </td>
                                    <td class="text-truncate">{{$data['name']}}</td>
                                    <td class="text-truncate">{!! get_label_bool($data['status'], true) !!}</td>
                                    <td class="text-truncate">
                                        {!! get_label_bool($data['accept_order'], true, \Lang::get('default.yes'), \Lang::get('default.no')) !!}
                                        @if( !empty( $data['minimum_order_value'] ) )
                                            <p><small><strong>Mínimo: </strong>R$ {{format_number( $data['minimum_order_value'], 2 )}}</small></p>
                                        @endif
                                    </td>
                                    <td class="text-truncate">
                                        @php
                                            $contacts = $data['contact'];
                                            $contacts = $contacts ? $contacts : 'Não identificado.';
                                            if( $data['phone'] ){
                                                $contacts .= '<p class="contacts"><small><strong>Telefone:</strong> '.mask_string( $data['phone'] ).'</small></p>';
                                            }
                                            if( $data['email'] ){
                                                $contacts .= '<p class="contacts"><small><strong>E-mail:</strong> <a href="mailto:'.$data['email'].'">'.$data['email'].'</a></small></p>';
                                            }
                                        @endphp
                                        {!! $contacts.'</div>' !!}
                                    </td>
                                    <td>{!! str_replace(',', '<br>', $proviTags ) !!}</td>
                                    <td class="text-truncate text-right">
                                        <a class="btn-delete" data-id="{{$data['id']}}"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @component('components.paginator', ['paginator'=>$paginator, 'paginator_info' => $paginator_info])@endcomponent
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

    <script>
        $( document ).ready(function() {
            $("#tags_filter").select2({
                placeholder: "Selecione",
                width: '100%'
            });
        });

        @include('includes.filter-js')
        cruds.bindDelete('provider');

    </script>
@endsection
