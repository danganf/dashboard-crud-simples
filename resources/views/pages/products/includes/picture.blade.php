<div class="card">
    <div class="card-header reload-card">
        <h4 class="card-title info click-collpase"><i class="la la-picture-o"></i> Imagem</h4>
        <div class="heading-elements">
            <a data-action="collapse"><i id="icon-filter" class="ft-plus"></i></a>
            <a data-action="expand"><i class="ft-maximize"></i></a>
        </div>
    </div>
    <div id="cardFilter" class="card-content collapse show">
        <div class="card-body">
                <div class="form-body">
                    <h4></h4>
                    <div class="form-group row last">
                        <label class="col-md-3 label-control" for="desc">Atual</label>
                        <div class="col-md-9">
                            <ul class="list-unstyled users-list m-0">
                                <li class="avatar avatar-100 pull-up">
                                    <img class="media-object rounded-circle no-border-top-radius no-border-bottom-radius" src="@if( empty( current($product['image']) ) ) ../../../app-assets/images/portfolio/portfolio-1.jpg @else {{current($product['image'])}} @endif" alt="Avatar">
                                </li>
                                {{--<li class="avatar p-2">
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Excluir</button>
                                </li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="form-group row last">
                        <label class="col-md-3 label-control" for="desc">Nova</label>
                        <div class="col-md-9">
                            <label id="projectinput8" class="file center-block">
                                <input type="file" id="image_file" name="product_image">
                                <span class="file-custom"></span>
                            </label>

                            <div class="progress">
                                <div class="progress-bar bg-danger bar percent" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div>
                            </div>

                            <div id="status"></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>