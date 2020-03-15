<div class="col-lg-12">
    <div class="card">
        <div class="card-header reload-card">
            <h4 class="card-title">Filtragem</h4>
            <div class="heading-elements">
                <a data-action="collapse" class="btn btn-sm btn-icon btn-success"><i id="icon-filter" class="ft-plus white"></i></a>
                <button type="button" class="btn btn-filter btn-sm btn-icon btn-success btn-click"><i class="ft-filter white"></i> Buscar </button>
                <button onclick="window.location.href='{{route(getRouteName())}}?reset'" type="button" class="btn btn-clear hidden btn-sm btn-icon btn-danger btn-click"><i id="icon-clear" class="ft-x-square white"></i> Limpar </button>
            </div>
        </div>
        <div id="cardFilter" class="card-content collapse">
            <div class="card-body">
                <form class="form">
                    <input type="hidden" name="filter">
                    <input type=submit class="hidden">
                    <div class="form-body">
                        <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 col-xl-2">
                                <div class="form-group">
                                    <label for="projectinput1">Busca <small style="color:#817b9d">Nome e/ou ID</small></label>
                                    <input class="form-control" name="search">
                                </div>
                            </div>
                        @if( $action === 'main' )
                            <div class="col-md-3 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <label for="type">Tipo</label>
                                    <select class="form-control" name="type">
                                        <option value="">Todos</option>
                                        <option value="SIMPLES">SIMPLES</option>
                                        <option value="ITEM">ITEM</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="product_status">Status</label>
                                    <select class="form-control" name="product_status">
                                        <option value="">Todos</option>
                                        <option value="S">ATIVO</option>
                                        <option value="N">INATIVO</option>
                                    </select>
                                </div>
                            </div>
                        @if( $action === 'main' )
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="in_app">Publicado</label>
                                    <select class="form-control" name="in_app">
                                        <option value="">Todos</option>
                                        <option value="S">SIM</option>
                                        <option value="N">NÃO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="in_home_app">Home APP</label>
                                    <select class="form-control" name="in_home_app">
                                        <option value="">Todos</option>
                                        <option value="S">SIM</option>
                                        <option value="N">NÃO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="in_home_app">Pronto p/ consumo</label>
                                    <select class="form-control" name="is_qty_ready">
                                        <option value="">Todos</option>
                                        <option value="S">SIM</option>
                                        <option value="N">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="in_home_app">Prioridade</label>
                                    <select class="form-control" name="priority">
                                        <option value="">Todos</option>
                                        @foreach( $prioritys as $priority )
                                            <option value="{{$priority['id']}}">
                                                {{$priority['id'].' - '.$priority['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="sector_id">Setor</label>
                                    <select class="form-control" name="sector_id">
                                        <option value="">Todos</option>
                                    @foreach( $sectories AS $row )
                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="unit_id">Unidade</label>
                                    <select class="form-control" name="unit_id">
                                        <option value="">Todos</option>
                                        @foreach( $units AS $row )
                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="category_id">Categoria</label>
                                    <select style="height: 400px" class="form-control" name="categories[]" multiple="multiple" id="category_filter">
                                        <option value="">Todos</option>
                                        @foreach( $categories AS $row )
                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <label for="unit_id">Tag</label><br>
                                    <select class="form-control" name="tags[]" id="tags_filter" multiple="multiple">
                                        <option value="">Todos</option>
                                        @foreach( $tags AS $row )
                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-xl-2">
                                <div class="form-group">
                                    <label for="manufacture">Fabricação</label>
                                    <select class="form-control" name="manufacture">
                                        <option value="">Todos</option>
                                        @foreach( config('app.manufacture') as $manufacture )
                                            <option value="{!! $manufacture !!}">{!! $manufacture !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if( $action === 'main' )
                            <div class="col-md-2 col-xl-2">
                                <div class="form-group">
                                    <label for="limit">Paginação</label>
                                    <select class="form-control" name="limit">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
