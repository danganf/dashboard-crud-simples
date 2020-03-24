@extends('layout')

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
                        <button onclick="location.href='{{route('customer.new')}}'" class="btn btn-primary btn-sm btn-icon"><i class="ft-plus white"></i> Novo</button>
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
                                    <th class="border-top-0">Nome</th>
                                    <th class="border-top-0">E-mail</th>
                                    <th class="border-top-0">Documento</th>
                                    <th class="border-top-0">Telefone</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0 text-right">Ação</th>
                                </tr>
                                </thead>
                                <tbody class="value-last-orders">
                                @foreach( $results AS $row )
                                    <tr>
                                        <td class="text-truncate">{{$row['id']}}</td>
                                        <td class="text-truncate">
                                            <a href="{{route('customer.edit',[$row['id']])}}">
                                                {{$row['name']}}
                                            </a>
                                        </td>
                                        <td class="text-truncate">{{$row['email']}}</td>
                                        <td class="text-truncate">{{mask_string( $row['document'], 'CPF' )}}</td>
                                        <td class="text-truncate">{{mask_string( $row['phone'] )}}</td>
                                        <td class="text-truncate">{!! get_label_bool($row['status'], true) !!}</td>
                                        <td class="text-truncate text-right">
                                            <a class="btn-delete" data-id="{{$row['id']}}"><i class="la la-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @component('components.paginator', [ 'paginator' => $paginator ] )@endcomponent
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        cruds.bindDelete('customer');
        @include('includes.filter-js')
    </script>
@endsection
