@if( $type != 'ITEM' && $action != 'inputs' )
<div class="card only-simples">
    <div class="card-header reload-card">
        <h4 class="card-title info click-collpase"><i class="la la-edit"></i> Conteúdo</h4>
        <div class="heading-elements">
            <a data-action="collapse"><i id="icon-filter" class="ft-minus"></i></a>
            <a data-action="expand"><i class="ft-maximize"></i></a>
        </div>
    </div>
    <div id="cardFilter" class="card-content">
        <div class="card-body">

                <div class="form-body">
                    <h4></h4>
                    <div class="form-group row">
                        <label class="col-md-3 label-control" for="short_description">Descrição curta</label>
                        <div class="col-md-9">
                            <input type="text" id="short_description" class="form-control verify-origin-value" data-value="{{array_get($product,'short_description','')}}" value="{{array_get($product,'short_description','')}}" placeholder="Descrição rápida" name="short_description">
                        </div>
                    </div>
                    <div class="form-group row last">
                        <label class="col-md-3 label-control" for="description">Descrição</label>
                        <div class="col-md-9">
                            <textarea id="description" rows="5" class="form-control verify-origin-value" name="description" data-value="{{array_get($product,'description','')}}" placeholder="Descrição completa">{{array_get($product,'description','')}}</textarea>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
@endif